<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Order;
use App\Models\UserExam;
use App\Services\TripayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $tripayService;

    public function __construct(TripayService $tripayService)
    {
        $this->tripayService = $tripayService;
    }

    /**
     * 1. Halaman Pilih Metode Pembayaran
     */
    public function checkout($examId)
    {
        $exam = Exam::findOrFail($examId);
        $channels = $this->tripayService->getPaymentChannels();

        return view('order.checkout', compact('exam', 'channels'));
    }

    /**
     * 2. Proses Buat Tagihan ke Tripay
     */
    public function store(Request $request, $examId)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $exam = Exam::findOrFail($examId);
        $user = Auth::user();
        $merchantRef = 'TRYO-' . date('YmdHis') . '-' . rand(100, 999);

        try {
            // Panggil Tripay API
            $tripayData = $this->tripayService->createClosedTransaction(
                $merchantRef,
                $request->payment_method,
                $exam->price,
                $user,
                $exam
            );

            // Simpan ke Database
            $order = Order::create([
                'reference'      => $tripayData['reference'],
                'merchant_ref'   => $merchantRef,
                'order_number'   => $merchantRef,
                'user_id'        => $user->id,
                'exam_id'        => $exam->id,
                'payment_method' => $tripayData['payment_method'],
                'payment_name'   => $tripayData['payment_name'],
                'amount'         => $tripayData['amount'],
                'pay_code'       => $tripayData['pay_code'] ?? null,
                'qr_url'         => $tripayData['qr_url'] ?? null,
                'status'         => 'UNPAID',
            ]);

            return redirect()->route('order.detail', $order->reference);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * 3. Halaman Detail Instruksi Pembayaran (QRIS / No VA)
     */
    public function detail($reference)
    {
        $order = Order::with('exam')->where('reference', $reference)->where('user_id', Auth::id())->firstOrFail();
        return view('order.detail', compact('order'));
    }

    /**
     * 4. Webhook Callback Otomatis dari Server Tripay (Validasi HMAC Signature)
     */
    public function webhook(Request $request)
    {
        // 1. Ambil Private Key dari Config / ENV
        $privateKey = config('services.tripay.private_key') ?? env('TRIPAY_PRIVATE_KEY');

        // 2. Ambil RAW Body Request (JSON Mentah)
        $json = $request->getContent();

        // 3. Ambil Signature dari Header yang dikirim Tripay
        $callbackSignature = $request->header('X-Callback-Signature');

        // 4. Hitung Ulang Signature HMAC SHA256
        $signature = hash_hmac('sha256', $json, $privateKey);

        // 5. Validasi Ketepatan Signature
        if ($callbackSignature !== $signature) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Signature'
            ], 403);
        }

        $event = $request->header('X-Callback-Event');

        if ($event === 'payment_status') {
            $data = json_decode($json, true);

            if ($data['status'] === 'PAID') {
                $order = Order::where('reference', $data['reference'])->first();

                if ($order && $order->status !== 'PAID') {
                    $order->update(['status' => 'PAID']);

                    // Otomatis Buka Akses Ujian
                    $existingUserExam = UserExam::where('user_id', $order->user_id)
                        ->where('exam_id', $order->exam_id)
                        ->first();

                    if (!$existingUserExam) {
                        UserExam::create([
                            'user_id'    => $order->user_id,
                            'exam_id'    => $order->exam_id,
                            'started_at' => now(),
                            'status'     => 'ON_PROGRESS',
                        ]);
                    }
                }
            } elseif (in_array($data['status'], ['EXPIRED', 'FAILED'])) {
                Order::where('reference', $data['reference'])->update(['status' => $data['status']]);
            }
        }

        return response()->json(['success' => true]);
    }
}
