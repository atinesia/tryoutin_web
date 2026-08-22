<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Tryoutin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --brand-primary: #1b365d;
            --brand-dark: #0f1f38;
            --brand-secondary: #00d2ff;
        }

        body {
            background: #f4f7fa;
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, var(--brand-dark) 0%, var(--brand-primary) 100%);
            color: #fff;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .admin-main {
            margin-left: 260px;
            padding: 30px;
        }

        .nav-link-admin {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link-admin:hover,
        .nav-link-admin.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--brand-secondary);
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar">
        <div class="p-4 fs-4 fw-bold border-bottom border-secondary border-opacity-25">
            <i class="fa-solid fa-graduation-cap text-info me-2"></i>Tryout<span class="text-info">in</span>
        </div>
        <div class="py-3">
            <!-- Menu Dashboard, User, & Tiket HANYA MUNCUL UNTUK SUPER ADMIN -->
            @if (auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie me-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users me-3"></i> Kelola User
                </a>
                <a href="{{ route('admin.tickets.index') }}"
                    class="nav-link-admin {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-headset me-3"></i> Tiket Kendala
                </a>
            @endif
            <!-- Menu Khusus Paket Soal (Diakses Admin & Tutor) -->
            <a href="{{ route('admin.exams.index') }}"
                class="nav-link-admin {{ request()->routeIs('admin.exams.index') || request()->routeIs('admin.exams.questions*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group me-3"></i> Daftar Paket Soal
            </a>
            <a href="{{ route('admin.exams.create') }}"
                class="nav-link-admin {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}">
                <i class="fa-solid fa-wand-magic-sparkles me-3"></i> AI Question Generator
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <main class="admin-main">
        <!-- Topbar Header -->
        <header class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <div>
                <h4 class="fw-bold m-0 text-dark">@yield('page_title', 'Admin Panel')</h4>
                <small class="text-muted">Control Center Tryoutin</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-primary px-3 py-2 rounded-pill">Role:
                    {{ strtoupper(auth()->user()->role) }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar
                    </button>
                </form>
            </div>
        </header>

        <!-- Global Flash Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Dynamic Content -->
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
