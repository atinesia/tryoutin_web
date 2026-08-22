<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tryoutin</title>

    <!-- Bootstrap 5.3 CSS & FontAwesome 6 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --brand-primary: #1b365d;
            --brand-secondary: #00d2ff;
            --brand-dark: #0f1f38;
            --bg-light: #f4f7fa;
            --sidebar-width: 260px;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, var(--brand-dark) 0%, var(--brand-primary) 100%);
            color: #ffffff;
            transition: all 0.3s ease;
            z-index: 1050;
            box-shadow: 4px 0 16px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: #ffffff;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-brand span { color: var(--brand-secondary); }

        .nav-link-custom {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: rgba(255,255,255,0.7);
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            border-left-color: var(--brand-secondary);
        }
        .nav-link-custom i {
            width: 24px;
            font-size: 1.1rem;
            margin-right: 12px;
        }

        /* Main Content Styling */
        #main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        /* Top Navbar */
        .top-navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            padding: 0.8rem 1.5rem;
        }

        /* Cards & Components */
        .card-custom {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            transition: transform 0.2s ease;
        }

        .icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .bg-soft-primary { background-color: rgba(27, 54, 93, 0.1); color: var(--brand-primary); }
        .bg-soft-info { background-color: rgba(0, 210, 255, 0.15); color: #008ba3; }
        .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); color: #198754; }
        .bg-soft-warning { background-color: rgba(255, 193, 7, 0.15); color: #997404; }

        @media (max-width: 991.98px) {
            #sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            #sidebar.show { margin-left: 0; }
            #main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

    <!-- 1. Sidebar Navigasi -->
    <aside id="sidebar">
        <a href="#" class="sidebar-brand">
            <i class="fa-solid fa-graduation-cap text-info me-2"></i>Tryout<span>in</span>
        </a>

        <div class="py-3">
            <small class="px-4 text-uppercase text-light opacity-50 fw-bold fs-7 d-block mb-2">Main Menu</small>
            <nav class="nav flex-column">
                <a href="#" class="nav-link-custom active">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('admin.exams.create') }}" class="nav-link-custom">
                    <i class="fa-solid fa-wand-magic-sparkles text-info"></i> AI Exam Generator
                </a>
                <a href="#" class="nav-link-custom">
                    <i class="fa-solid fa-box-archive"></i> Paket Tryout
                </a>
                <a href="#" class="nav-link-custom">
                    <i class="fa-solid fa-receipt"></i> Transaksi & Tripay
                </a>
                <a href="#" class="nav-link-custom">
                    <i class="fa-solid fa-users"></i> Data Peserta
                </a>
            </nav>

            <small class="px-4 text-uppercase text-light opacity-50 fw-bold fs-7 d-block mt-4 mb-2">Sistem</small>
            <nav class="nav flex-column">
                <a href="#" class="nav-link-custom">
                    <i class="fa-solid fa-sliders"></i> Pengaturan Web
                </a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="nav-link-custom border-0 bg-transparent w-100 text-start text-danger">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar / Logout
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    <!-- 2. Main Content Wrapper -->
    <div id="main-content">
        
        <!-- Top Navbar -->
        <nav class="navbar top-navbar d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" type="button" id="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="fw-bold m-0 text-dark">Admin Control Center</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-light rounded-circle p-2 position-relative" type="button" data-bs-toggle="dropdown">
                        <i class="fa-regular fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li><h6 class="dropdown-header">Notifikasi Transaksi</h6></li>
                        <li><a class="dropdown-item small" href="#">Pembayaran Baru Rp 50.000 (PAID)</a></li>
                    </ul>
                </div>

                <div class="vr mx-1"></div>

                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="d-none d-sm-block">
                        <span class="fw-semibold d-block lh-1 small">{{ auth()->user()->name ?? 'Administrator' }}</span>
                        <small class="text-muted fs-7">Super Admin</small>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Container Isi Content -->
        <div class="container-fluid px-4 pb-5">

            <!-- Banner Header -->
            <div class="card card-custom border-0 bg-primary text-white p-4 mb-4" style="background: linear-gradient(135deg, var(--brand-dark) 0%, var(--brand-primary) 100%);">
                <div class="d-md-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="fw-bold m-0">Selamat Datang di Panel Tryoutin! 🚀</h3>
                        <p class="text-white-50 m-0 mt-1">Kelola paket tryout, transaksi pembayaran Tripay, dan pembuat soal berbasis AI dari satu layar.</p>
                    </div>
                    <a href="{{ route('admin.exams.create') }}" class="btn btn-info text-white fw-bold rounded-pill px-4 py-2 mt-3 mt-md-0 shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> Buat Paket & Soal AI
                    </a>
                </div>
            </div>

            <!-- Stats Metric Cards -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-custom p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold">TOTAL OMSET</span>
                                <h3 class="fw-bold m-0 mt-1 text-primary">Rp 12.450.000</h3>
                                <small class="text-success fw-semibold fs-7"><i class="fa-solid fa-arrow-trend-up me-1"></i>+15% bulan ini</small>
                            </div>
                            <div class="icon-box bg-soft-primary">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-custom p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold">PESERTA TERDAFTAR</span>
                                <h3 class="fw-bold m-0 mt-1 text-dark">1,280</h3>
                                <small class="text-success fw-semibold fs-7"><i class="fa-solid fa-user-plus me-1"></i>+42 peserta baru</small>
                            </div>
                            <div class="icon-box bg-soft-info">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-custom p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold">PAKET TRYOUT</span>
                                <h3 class="fw-bold m-0 mt-1 text-dark">8 Paket</h3>
                                <small class="text-muted fs-7">6 Aktif / 2 Draft</small>
                            </div>
                            <div class="icon-box bg-soft-success">
                                <i class="fa-solid fa-box-archive"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-custom p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold">TRANSAKSI TRIPAY</span>
                                <h3 class="fw-bold m-0 mt-1 text-dark">240</h3>
                                <small class="text-warning fw-semibold fs-7"><i class="fa-solid fa-clock me-1"></i>5 Menunggu Bayar</small>
                            </div>
                            <div class="icon-box bg-soft-warning">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Transaksi Terakhir & Paket Populer -->
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card card-custom p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold m-0"><i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Transaksi Pembelian Terbaru</h5>
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle m-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ref Order</th>
                                        <th>Peserta</th>
                                        <th>Paket Ujian</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong class="text-primary">TRYO-20260817-001</strong></td>
                                        <td>Budi Santoso</td>
                                        <td>Paket SKD Premium 1</td>
                                        <td class="fw-bold">Rp 50.000</td>
                                        <td><span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill">PAID</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong class="text-primary">TRYO-20260817-002</strong></td>
                                        <td>Siti Rahma</td>
                                        <td>Tryout Akbar CPNS 2026</td>
                                        <td class="fw-bold">Rp 75.000</td>
                                        <td><span class="badge bg-warning bg-opacity-20 text-dark px-3 py-1 rounded-pill">UNPAID</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card card-custom p-4">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-robot text-info me-2"></i>Status Groq AI</h5>
                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <small class="text-muted d-block">Model Aktif:</small>
                            <strong class="text-primary">llama-3.3-70b-versatile</strong>
                        </div>
                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <small class="text-muted d-block">Status API Key:</small>
                            <span class="badge bg-success">TERHUBUNG (.env)</span>
                        </div>
                        <a href="{{ route('admin.exams.create') }}" class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold">
                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Buka Generator Soal
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar Responsive
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
</body>
</html>