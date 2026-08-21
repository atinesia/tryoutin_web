<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Paket Tryout SKD CPNS - Tryoutin</title>
    <!-- Bootstrap 5 CSS & FontAwesome Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --brand-primary: #1b365d;
            --brand-secondary: #00d2ff;
            --brand-dark: #0f1f38;
            --bg-light: #f4f7fa;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* Navbar Header */
        .brand-navbar {
            background: linear-gradient(135deg, var(--brand-dark) 0%, var(--brand-primary) 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .brand-logo {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
            color: #ffffff;
        }

        .brand-logo span {
            color: var(--brand-secondary);
        }

        /* Card Pricing / Package Styling */
        .package-card {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .package-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(27, 54, 93, 0.12);
        }

        .package-featured {
            border: 2px solid var(--brand-secondary);
        }

        .badge-popular {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #00d2ff, #0072ff);
            color: #fff;
            font-weight: 700;
            font-size: 0.75rem;
            padding: 5px 12px;
            border-radius: 20px;
            text-uppercase: uppercase;
        }

        .price-tag {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--brand-primary);
        }

        .feature-list li {
            padding: 8px 0;
            font-size: 0.95rem;
            color: #495057;
            border-bottom: 1px dashed #edf2f7;
        }

        .feature-list li:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar brand-navbar py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand brand-logo m-0" href="#">
                <i class="fa-solid fa-graduation-cap text-info me-2"></i>Tryout<span>in</span>
            </a>
            @auth
                <div class="d-flex align-items-center text-white gap-3">
                    <small class="m-0"><i class="fa-regular fa-circle-user text-info me-1"></i>
                        {{ auth()->user()->name }}</small>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light rounded-pill px-3">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-info text-white rounded-pill px-4 fw-bold">Login</a>
            @endauth
        </div>
    </nav>

    <div class="container py-4">

        <!-- Header Section -->
        <div class="text-center mb-5">
            <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill mb-2">SIMULASI CAT CPNS
                2026</span>
            <h2 class="fw-bold display-6 text-dark">Pilih Paket Tryout Terbaik Anda</h2>
            <p class="text-muted col-lg-6 mx-auto">
                Persiapkan diri menghadapi seleksi SKD CPNS dengan simulasi standar BKN, sistem pembobotan nilai akurat,
                serta analisis kelemahan berbasis AI.
            </p>
        </div>

        <!-- Grid Paket Tryout -->
        <div class="row g-4 justify-content-center">
            @foreach ($exams as $exam)
                @php
                    $hasPurchased = in_array($exam->id, $userExamIds);
                    $isFree = $exam->price == 0;
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="card package-card h-100 p-4 {{ !$isFree ? 'package-featured' : '' }}">

                        @if (!$isFree)
                            <span class="badge-popular"><i class="fa-solid fa-star me-1"></i> Best Value</span>
                        @endif

                        <div class="card-body p-0 d-flex flex-column justify-content-between">
                            <div>
                                <!-- Header Paket -->
                                <h4 class="fw-bold text-dark mb-2">{{ $exam->title }}</h4>
                                <p class="text-muted small mb-3">
                                    {{ $exam->description ?? 'Simulasi Ujian SKD CPNS lengkap dengan Sistem CAT BKN.' }}
                                </p>

                                <!-- Harga -->
                                <div class="mb-4">
                                    @if ($isFree)
                                        <span class="price-tag text-success">GRATIS</span>
                                    @else
                                        <span class="price-tag">Rp {{ number_format($exam->price, 0, ',', '.') }}</span>
                                        <small class="text-muted d-block fs-7">Akses Selamanya / Sekali Bayar</small>
                                    @endif
                                </div>

                                <hr>

                                <!-- Fasilitas & Fitur Paket -->
                                <h6 class="fw-bold text-dark mb-3"><i
                                        class="fa-solid fa-shield-halved text-primary me-2"></i>Fasilitas Paket:</h6>
                                <ul class="list-unstyled feature-list mb-4">
                                    <li>
                                        <i class="fa-solid fa-circle-check text-success me-2"></i>
                                        <strong>{{ $exam->duration_minutes }} Menit</strong> Durasi Ujian Real-time
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-circle-check text-success me-2"></i>
                                        <strong>Standar BKN:</strong> TWK ({{ $exam->passing_grade_twk }}), TIU
                                        ({{ $exam->passing_grade_tiu }}), TKP ({{ $exam->passing_grade_tkp }})
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-circle-check text-success me-2"></i>
                                        Timer Anti-Reset & Auto-Save Jawaban
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-circle-check text-success me-2"></i>
                                        Peringkat & Leaderboard Nasional
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-circle-check text-success me-2"></i>
                                        Lembar Pembahasan Soal Lengkap
                                    </li>
                                    @if (!$isFree)
                                        <li class="fw-semibold text-primary">
                                            <i class="fa-solid fa-robot text-info me-2"></i>
                                            Analisis Performa & Saran AI Mentor (Groq AI)
                                        </li>
                                        <li>
                                            <i class="fa-solid fa-circle-check text-success me-2"></i>
                                            Pembobotan Nilai TKP Skala 1 - 5 Presisi
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <!-- Tombol Aksi -->
                            <div>
                                @if ($hasPurchased)
                                    <a href="{{ route('exam.show', $exam->id) }}"
                                        class="btn btn-success w-100 py-3 fw-bold rounded-pill">
                                        <i class="fa-solid fa-play me-2"></i> Mulai Mengerjakan
                                    </a>
                                @elseif($isFree)
                                    <a href="{{ route('exam.show', $exam->id) }}"
                                        class="btn btn-outline-primary w-100 py-3 fw-bold rounded-pill">
                                        Coba Gratis Sekarang
                                    </a>
                                @else
                                    <a href="{{ route('checkout', $exam->id) }}"
                                        class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm">
                                        <i class="fa-solid fa-cart-shopping me-2"></i> Beli Paket Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</body>

</html>
