<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Pembayaran - Tryoutin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
        }

        .channel-card {
            cursor: pointer;
            border: 1px solid #dee2e6;
            transition: all 0.2s;
        }

        .channel-card:hover {
            border-color: #0d6efd;
            background-color: #f8faff;
        }

        .channel-radio:checked+.channel-label {
            border-color: #0d6efd;
            background-color: #eef4ff;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h4 class="fw-bold text-primary mb-1">Checkout Pembelian</h4>
                    <p class="text-muted small mb-4">Pilih metode pembayaran yang paling nyaman untuk Anda</p>

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="bg-light p-3 rounded-3 mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block">Paket Ujian:</small>
                            <strong class="fs-6">{{ $exam->title }}</strong>
                        </div>
                        <span class="fs-5 fw-bold text-success">Rp {{ number_format($exam->price, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('checkout.store', $exam->id) }}" method="POST">
                        @csrf
                        <h6 class="fw-bold mb-3">Pilih Channel Pembayaran:</h6>

                        <div class="row g-3 mb-4">
                            @foreach ($channels as $ch)
                                @if ($ch['active'])
                                    <div class="col-md-6">
                                        <input type="radio" class="btn-check channel-radio" name="payment_method"
                                            id="ch_{{ $ch['code'] }}" value="{{ $ch['code'] }}" required>
                                        <label class="card channel-card channel-label p-3 w-100 rounded-3"
                                            for="ch_{{ $ch['code'] }}">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <strong class="d-block small text-dark">{{ $ch['name'] }}</strong>
                                                    <small class="text-muted fs-7">Biaya: Rp
                                                        {{ number_format($ch['total_fee']['flat'] ?? 0, 0, ',', '.') }}</small>
                                                </div>
                                                <img src="{{ $ch['icon_url'] }}" alt="{{ $ch['name'] }}"
                                                    height="24">
                                            </div>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3">Bayar
                            Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
