<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruksi Pembayaran - {{ $order->reference }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
                    <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill mb-3 w-auto mx-auto">MENUNGGU
                        PEMBAYARAN</span>

                    <h5 class="text-muted mb-1">Total Tagihan:</h5>
                    <h2 class="text-primary fw-bold mb-4">Rp {{ number_format($order->amount, 0, ',', '.') }}</h2>

                    <!-- Tampilan QRIS jika metode pembayaran QRIS -->
                    @if ($order->qr_url)
                        <div class="mb-4">
                            <p class="small text-muted mb-2">Scan QRIS di bawah ini menggunakan GoPay / OVO / ShopeePay
                                / BCA / QRIS Bank:</p>
                            <img src="{{ $order->qr_url }}" alt="QRIS" class="img-fluid border p-2 rounded-3"
                                style="max-width: 250px;">
                        </div>
                        <!-- Tampilan Kode VA / Alfamart -->
                    @elseif($order->pay_code)
                        <div class="bg-light p-3 rounded-3 mb-4">
                            <small class="text-muted d-block mb-1">Kode Pembayaran / Virtual Account:</small>
                            <h3 class="fw-bold text-dark text-break m-0">{{ $order->pay_code }}</h3>
                        </div>
                    @endif

                    <div class="alert alert-info fs-7 text-start mb-4">
                        <strong>Catatan:</strong> Setelah pembayaran Anda terverifikasi oleh Tripay, akses ujian Anda
                        akan terbuka secara otomatis 24/7 tanpa perlu konfirmasi manual.
                    </div>

                    <a href="{{ route('exam.show', $order->exam_id) }}"
                        class="btn btn-outline-primary w-100 fw-bold py-2">
                        Cek Status Akses Ujian
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
