<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Afiliator - Tryoutin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: #f4f7fa;
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>

<body class="py-4">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold m-0">Dashboard Afiliator Tryoutin</h3>
                <p class="text-muted small m-0">Bagikan link unik Anda dan dapatkan komisi 20% dari setiap penjualan
                    paket</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">@csrf <button type="submit"
                    class="btn btn-outline-danger btn-sm rounded-pill">Logout</button></form>
        </div>

        <!-- Banner Link Referral -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white mb-4"
            style="background: linear-gradient(135deg, #0f1f38, #1b365d);">
            <h6 class="fw-bold mb-2"><i class="fa-solid fa-link text-info me-2"></i>Link Referral Unik Anda:</h6>
            <div class="input-group">
                <input type="text" id="refLink" class="form-control form-control-lg bg-white text-dark fw-bold"
                    value="{{ $referralLink }}" readonly>
                <button class="btn btn-info text-dark fw-bold px-4" onclick="copyRef()">Salin Link</button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <small class="text-muted fw-bold">TOTAL PENDAFTAR RUJUKAN</small>
                    <h3 class="fw-bold text-dark m-0 mt-1">{{ $totalReferred }} Peserta</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <small class="text-muted fw-bold">TOTAL OMSET PENJUALAN</small>
                    <h3 class="fw-bold text-primary m-0 mt-1">Rp {{ number_format($totalSales, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <small class="text-muted fw-bold">ESTIMASI KOMISI (20%)</small>
                    <h3 class="fw-bold text-success m-0 mt-1">Rp {{ number_format($totalCommission, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyRef() {
            var copyText = document.getElementById("refLink");
            copyText.select();
            document.execCommand("copy");
            alert("Link referral berhasil disalin!");
        }
    </script>

</body>

</html>
