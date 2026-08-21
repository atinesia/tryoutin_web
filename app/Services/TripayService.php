<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TripayService
{
    protected $apiKey;
    protected $privateKey;
    protected $merchantCode;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('TRIPAY_API_KEY');
        $this->privateKey = env('TRIPAY_PRIVATE_KEY');
        $this->merchantCode = env('TRIPAY_MERCHANT_CODE');

        $isProduction = env('TRIPAY_IS_PRODUCTION', false);
        $this->baseUrl = $isProduction
            ? 'https://tripay.co.id/api/'
            : 'https://tripay.co.id/api-sandbox/';
    }

    /**
     * Ambil daftar Channel Pembayaran aktif (QRIS, VA, Minimarket)
     */
    public function getPaymentChannels()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->baseUrl . 'merchant/payment-channel');

        if ($response->successful()) {
            return $response->json()['data'] ?? [];
        }

        return [];
    }

    /**
     * Buat Transaksi Pembayaran Baru ke Tripay
     */
    public function createClosedTransaction($merchantRef, $paymentMethod, $amount, $user, $exam)
    {
        // Hitung Signature SHA256 Tripay
        $signature = hash_hmac('sha256', $this->merchantCode . $merchantRef . $amount, $this->privateKey);

        $payload = [
            'method'         => $paymentMethod,
            'merchant_ref'   => $merchantRef,
            'amount'         => (int) $amount,
            'customer_name'  => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '081234567890',
            'order_items'    => [
                [
                    'sku'      => 'EXAM-' . $exam->id,
                    'name'     => substr($exam->title, 0, 50),
                    'price'    => (int) $amount,
                    'quantity' => 1,
                ]
            ],
            'return_url'     => route('exam.show', $exam->id),
            'expired_time'   => (time() + (24 * 60 * 60)), // Expired 24 Jam
            'signature'      => $signature
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUrl . 'transaction/create', $payload);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        throw new \Exception($response->json()['message'] ?? 'Gagal membuat transaksi ke Tripay.');
    }
}
