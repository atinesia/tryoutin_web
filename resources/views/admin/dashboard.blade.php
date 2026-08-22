<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard - Tryoutin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --brand-primary: #1b365d;
            --brand-dark: #0f1f38;
        }

        body {
            background: #f4f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: linear-gradient(180deg, var(--brand-dark), var(--brand-primary));
            color: #fff;
        }

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .nav-link-custom {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 24px;
            display: block;
            text-decoration: none;
            font-weight: 500;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #00d2ff;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="p-4 fs-4 fw-bold border-bottom border-secondary"><i
                class="fa-solid fa-graduation-cap text-info me-2"></i>Tryout<span class="text-info">in</span></div>
        <div class="py-3">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-custom active"><i
                    class="fa-solid fa-chart-pie me-2"></i> Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="nav-link-custom"><i class="fa-solid fa-users me-2"></i>
                Kelola User</a>
            <a href="{{ route('admin.exams.create') }}" class="nav-link-custom"><i
                    class="fa-solid fa-wand-magic-sparkles me-2"></i> AI Question Generator</a>
            <a href="{{ route('admin.tickets.index') }}" class="nav-link-custom"><i
                    class="fa-solid fa-headset me-2"></i> Tiket Kendala</a>
        </div>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0">Control Center Super Admin</h4>
            <span class="badge bg-primary px-3 py-2">Role: Super Admin</span>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <small class="text-muted fw-bold">TOTAL OMSET</small>
                    <h3 class="fw-bold text-success m-0 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <small class="text-muted fw-bold">TOTAL USER</small>
                    <h3 class="fw-bold text-primary m-0 mt-1">{{ $totalUsers }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <small class="text-muted fw-bold">PAKET UJIAN</small>
                    <h3 class="fw-bold text-info m-0 mt-1">{{ $totalExams }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3">
                    <small class="text-muted fw-bold">TIKET OPEN</small>
                    <h3 class="fw-bold text-warning m-0 mt-1">{{ $pendingTickets }}</h3>
                </div>
            </div>
        </div>

        <!-- Tables -->
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card card-custom p-4">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-receipt text-primary me-2"></i>Transaksi Pembayaran
                        Terbaru</h6>
                    <table class="table align-middle small">
                        <thead>
                            <tr>
                                <th>Ref</th>
                                <th>User</th>
                                <th>Nominal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $o)
                                <tr>
                                    <td><strong>{{ $o->reference }}</strong></td>
                                    <td>{{ $o->user->name ?? '-' }}</td>
                                    <td class="fw-bold">Rp {{ number_format($o->amount, 0, ',', '.') }}</td>
                                    <td><span
                                            class="badge {{ $o->status === 'PAID' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $o->status }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card card-custom p-4">
                    <h6 class="fw-bold mb-3"><i class="fa-solid fa-headset text-warning me-2"></i>Laporan Kendala
                        Terbaru</h6>
                    <div class="list-group list-group-flush small">
                        @foreach ($tickets as $t)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $t->subject }}</strong>
                                    <span
                                        class="badge {{ $t->status === 'OPEN' ? 'bg-danger' : 'bg-success' }}">{{ $t->status }}</span>
                                </div>
                                <p class="m-0 text-muted fs-7">{{ $t->user->name }} -
                                    {{ $t->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
