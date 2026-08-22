<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tryoutin - Bimbel & Platform Simulasi CAT CPNS & Kedinasan Terbaik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --brand-primary: #1b365d;
            --brand-secondary: #00d2ff;
            --brand-dark: #0f1f38;
            --brand-accent: #ffb703;
            --bg-light: #f8faff;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-light);
            color: #333;
        }

        /* Top Bar Info */
        .top-bar {
            background-color: var(--brand-dark);
            color: #ccc;
            font-size: 0.85rem;
        }

        /* Navbar */
        .brand-navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .brand-logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--brand-dark);
            text-decoration: none;
        }

        .brand-logo span {
            color: var(--brand-secondary);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--brand-dark) 0%, var(--brand-primary) 100%);
            color: white;
            padding: 90px 0 100px 0;
            position: relative;
            overflow: hidden;
        }

        .badge-hero {
            background: rgba(0, 210, 255, 0.15);
            color: var(--brand-secondary);
            border: 1px solid var(--brand-secondary);
        }

        /* Cards & Section Component */
        .card-custom {
            border: none;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(27, 54, 93, 0.12);
        }

        .icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
        }

        .price-card-popular {
            border: 2px solid var(--brand-secondary);
            position: relative;
        }

        .badge-popular {
            position: absolute;
            top: -14px;
            right: 20px;
            background: var(--brand-secondary);
            color: var(--brand-dark);
            font-weight: 800;
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            text-uppercase: uppercase;
        }

        .section-title {
            font-weight: 800;
            color: var(--brand-dark);
        }

        .section-subtitle {
            color: #6c757d;
            font-size: 1.05rem;
        }
    </style>
</head>

<body>

    <!-- 1. Top Bar Information -->
    <div class="top-bar py-2 d-none d-md-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span class="me-3"><i class="fa-solid fa-envelope text-info me-1"></i> info@tryoutin.com</span>
                <span><i class="fa-solid fa-phone text-info me-1"></i> Customer Service: 0812-3456-7890</span>
            </div>
            <div>
                <span class="badge bg-success me-2"><i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i>
                    Pendaftaran CPNS 2026 Dibuka</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Navigation Bar -->
    <nav class="navbar navbar-expand-lg brand-navbar sticky-top py-3">
        <div class="container">
            <a class="brand-logo" href="#">
                <i class="fa-solid fa-graduation-cap text-info me-2"></i>Tryout<span>in</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-menu navbar-nav mx-auto fw-semibold">
                    <li class="nav-item"><a class="nav-link text-dark" href="#program">Program Pilihan</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#keunggulan">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#harga">Paket Tryout</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#testimoni">Testimoni</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#faq">FAQ</a></li>
                </ul>
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Dashboard
                            Siswa</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-info text-dark rounded-pill px-4 fw-bold">Daftar
                            Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 3. Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <span class="badge badge-hero px-3 py-2 rounded-pill fw-bold mb-3">
                        <i class="fa-solid fa-shield-halved me-1"></i> ACCREDITED CAT BKN SIMULATOR
                    </span>
                    <h1 class="display-4 fw-extrabold mb-3 lh-sm">
                        Persiapkan Seleksi <span style="color: var(--brand-secondary);">SKD CPNS & Kedinasan</span>
                        Dengan Sistem Teruji
                    </h1>
                    <p class="lead opacity-85 mb-4 fs-6">
                        Latihan soal terlengkap sesuai Kisi-Kisi PermenPAN-RB terbaru. Dilengkapi Timer Presisi
                        Anti-Reset, Pembobotan Nilai Akurat, serta AI Performance Analytics untuk memetakan kelulusanmu.
                    </p>
                    <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap">
                        <a href="{{ route('register') }}"
                            class="btn btn-info text-dark btn-lg rounded-pill px-5 py-3 fw-bold shadow">
                            Mulai Simulasi Gratis <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                        <a href="#harga" class="btn btn-outline-light btn-lg rounded-pill px-4 py-3 fw-bold">
                            Lihat Pilihan Paket
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <div class="position-relative">
                        <img src="https://img.freepik.com/free-vector/online-test-concept-illustration_114360-5486.jpg"
                            class="img-fluid rounded-4 shadow-lg border border-3 border-info" alt="Tryoutin CAT Engine"
                            style="max-height: 380px;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Floating Stat Bar -->
    <div class="container" style="margin-top: -50px; position: relative; z-index: 10;">
        <div class="card card-custom p-4 bg-white shadow-lg border-0">
            <div class="row text-center g-4">
                <div class="col-md-3 col-6">
                    <h2 class="fw-bold text-primary m-0">25,000+</h2>
                    <span class="text-muted small fw-semibold">Peserta Terdaftar</span>
                </div>
                <div class="col-md-3 col-6">
                    <h2 class="fw-bold text-info m-0">150,000+</h2>
                    <span class="text-muted small fw-semibold">Soal Selesai Dikerjakan</span>
                </div>
                <div class="col-md-3 col-6">
                    <h2 class="fw-bold text-success m-0">98.4%</h2>
                    <span class="text-muted small fw-semibold">Kemiripan CAT BKN</span>
                </div>
                <div class="col-md-3 col-6">
                    <h2 class="fw-bold text-warning m-0">Groq AI</h2>
                    <span class="text-muted small fw-semibold">Personal Mentor Engine</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Program Pilihan Ujian -->
    <section id="program" class="py-5 mt-4">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="section-title">Program Bimbingan & Tryout Pilihan</h2>
                <p class="section-subtitle">Didesain khusus sesuai dengan formasi ujian seleksi nasional</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100 text-center">
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                            <i class="fa-solid fa-landmark"></i>
                        </div>
                        <h5 class="fw-bold text-dark">SKD CPNS 2026</h5>
                        <p class="text-muted small">Paket soal lengkap TWK, TIU, TKP dengan passing grade standar BKN
                            dan pembahasan rinci.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100 text-center">
                        <div class="icon-circle bg-info bg-opacity-10 text-info mx-auto mb-3">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Sekolah Kedinasan</h5>
                        <p class="text-muted small">Simulasi latihan untuk STAN, STIS, IPDN, POLTEKIP, dan instansi
                            kedinasan favorit lainnya.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100 text-center">
                        <div class="icon-circle bg-success bg-opacity-10 text-success mx-auto mb-3">
                            <i class="fa-solid fa-shield-cat"></i>
                        </div>
                        <h5 class="fw-bold text-dark">PPPK & BUMN</h5>
                        <p class="text-muted small">Materi tes kompetensi manajerial, sosio-kultural, dan tes wawancara
                            berbasis sistem digital.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Keunggulan Fasilitas -->
    <section id="keunggulan" class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="section-title">Fasilitas Modern Di Tryoutin</h2>
                <p class="section-subtitle">Nikmati pengalaman belajar yang terstruktur dan mudah dipahami</p>
            </div>
            <div class="row g-4 align-items-center">
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex mb-4">
                        <div class="icon-circle bg-primary text-white me-3 flex-shrink-0"><i
                                class="fa-solid fa-stopwatch"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Timer Presisi Server-Side</h6>
                            <p class="text-muted small m-0">Waktu ujian tidak akan ter-reset saat browser terdeteksi
                                refresh atau koneksi terputus.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="icon-circle bg-info text-white me-3 flex-shrink-0"><i
                                class="fa-solid fa-robot"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Evaluasi Otomatis AI Mentor</h6>
                            <p class="text-muted small m-0">Groq AI memberikan ulasan kekurangan dan rekomendasi
                                belajar langsung setelah ujian diselesaikan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 text-center d-none d-lg-block">
                    <img src="https://img.freepik.com/free-vector/learning-concept-illustration_114360-6186.jpg"
                        class="img-fluid" alt="Fasilitas Belajar">
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex mb-4">
                        <div class="icon-circle bg-success text-white me-3 flex-shrink-0"><i
                                class="fa-solid fa-trophy"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Leaderboard & Ranking Nasional</h6>
                            <p class="text-muted small m-0">Ketahui peringkatmu secara nasional dari seluruh peserta
                                pendaftar paket ujian yang sama.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="icon-circle bg-warning text-dark me-3 flex-shrink-0"><i
                                class="fa-solid fa-book-open"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Pembahasan & Kunci Jawaban</h6>
                            <p class="text-muted small m-0">Akses lembar pembahasan lengkap beserta cara cepat
                                menyelesaikan soal TIU dan TKP.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Pilihan Paket & Tarif -->
    <section id="harga" class="py-5">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="section-title">Pilihan Paket Tryout Hemat</h2>
                <p class="section-subtitle">Investasi masa depanmu dengan biaya terjangkau tanpa biaya tersembunyi</p>
            </div>
            <div class="row g-4 justify-content-center">
                <!-- Paket Gratis -->
                <div class="col-lg-4 col-md-6">
                    <div class="card card-custom p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark">Paket Trial Gratis</h5>
                            <p class="text-muted small">Coba langsung simulasi awal tanpa dipungut biaya</p>
                            <h2 class="fw-bold text-success my-3">FREE</h2>
                            <hr>
                            <ul class="list-unstyled small text-muted mb-4">
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>1 Sesi Tryout
                                    SKD Singkat</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Timer Standar
                                    CAT BKN</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Skor & Nilai
                                    Langsung Keluar</li>
                                <li class="mb-2 text-decoration-line-through"><i
                                        class="fa-solid fa-xmark text-danger me-2"></i>Analisis Kelemahan AI Mentor
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}"
                            class="btn btn-outline-primary w-100 rounded-pill fw-bold py-2">Coba Gratis</a>
                    </div>
                </div>

                <!-- Paket Premium (Popular) -->
                <div class="col-lg-4 col-md-6">
                    <div
                        class="card card-custom price-card-popular p-4 h-100 d-flex flex-column justify-content-between">
                        <span class="badge-popular">BEST VALUE</span>
                        <div>
                            <h5 class="fw-bold text-dark">Paket SKD Premium</h5>
                            <p class="text-muted small">Akses penuh seluruh paket tryout & fitur AI Mentor</p>
                            <h2 class="fw-bold text-primary my-3">Rp 50.000 <small class="fs-6 text-muted fw-normal">/
                                    sekali bayar</small></h2>
                            <hr>
                            <ul class="list-unstyled small text-muted mb-4">
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Akses Semua
                                    Paket Ujian Premium</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Pembahasan Soal
                                    Lengkap</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Ranking &
                                    Leaderboard Nasional</li>
                                <li class="mb-2 fw-bold text-primary"><i
                                        class="fa-solid fa-robot text-info me-2"></i>Evaluasi AI Mentor Groq</li>
                                <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Akses Selamanya
                                    Tanpa Batas Waktu</li>
                            </ul>
                        </div>
                        <a href="{{ route('register') }}"
                            class="btn btn-info text-dark w-100 rounded-pill fw-bold py-3 shadow">Beli Paket
                            Premium</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Testimoni Alumni & Peserta -->
    <section id="testimoni" class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill mb-2">KATA
                    MEREKA</span>
                <h2 class="section-title">Kisah Sukses Alumni Tryoutin</h2>
                <p class="section-subtitle">Ribuan peserta telah membuktikan kemiripan soal dan efektivitas simulasi
                    CAT Tryoutin</p>
            </div>

            <div class="row g-4">
                <!-- Testimoni 1 -->
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-warning mb-3">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <p class="text-muted small fst-italic mb-4">
                                "Fitur Timer Anti-Reset dan pembahasan soal TIU di Tryoutin bener-bener membantu banget
                                pas hari-H ujian asli. Soal-soalnya mirip banget sama standar BKN!"
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3"
                                style="width: 48px; height: 48px; font-size: 1.1rem;">
                                AR
                            </div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark">Anisa Rahmawati, S.Pd.</h6>
                                <small class="text-success fw-semibold fs-7"><i
                                        class="fa-solid fa-circle-check me-1"></i>Lolos CPNS Kemendikbud 2025</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimoni 2 -->
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-warning mb-3">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <p class="text-muted small fst-italic mb-4">
                                "Saran AI Mentor Groq-nya luar biasa presisi! Saya jadi tahu kalau kelemahan saya ada di
                                TWK Sejarah, jadi bisa fokus alokasi waktu belajar ke area situ."
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-info text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold me-3"
                                style="width: 48px; height: 48px; font-size: 1.1rem;">
                                RPr
                            </div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark">Rian Pratama</h6>
                                <small class="text-success fw-semibold fs-7"><i
                                        class="fa-solid fa-circle-check me-1"></i>Lolos IPDN (Kedinasan) 2025</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimoni 3 -->
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-warning mb-3">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <p class="text-muted small fst-italic mb-4">
                                "Ranking Nasionalnya bikin makin tertantang. Harganya terjangkau banget dibanding bimbel
                                tatap muka tapi kualitas soal dan sistem CAT-nya juara!"
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3"
                                style="width: 48px; height: 48px; font-size: 1.1rem;">
                                BS
                            </div>
                            <div>
                                <h6 class="fw-bold m-0 text-dark">Budi Santoso, S.T.</h6>
                                <small class="text-success fw-semibold fs-7"><i
                                        class="fa-solid fa-circle-check me-1"></i>Lolos CPNS KemenPUPR 2025</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. FAQ Section -->
    <section id="faq" class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="section-title">Pertanyaan Sering Diajukan (FAQ)</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion accordion-flush" id="faqAccordion">
                        <div class="accordion-item border rounded-3 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Apakah paket tryout bisa diakses dari HP / Smartphone?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted small">
                                    Ya, sistem Tryoutin sepenuhnya responsif dan dapat diakses dari smartphone, tablet,
                                    maupun laptop/PC dengan lancar.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border rounded-3 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Bagaimana cara pembayaran paket di Tryoutin?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted small">
                                    Pembayaran dilakukan secara otomatis via Tripay Payment Gateway (QRIS
                                    GoPay/OVO/ShopeePay, Virtual Account Bank BCA/Mandiri/BRI/BNI, serta Minimarket
                                    Alfamart/Indomaret).
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5">
                    <a class="brand-logo text-white d-block mb-3" href="#">
                        <i class="fa-solid fa-graduation-cap text-info me-2"></i>Tryout<span>in</span>
                    </a>
                    <p class="text-light opacity-75 small">Platform bimbingan dan simulasi ujian CAT CPNS & Kedinasan
                        terpercaya berbasis kecerdasan buatan.</p>
                </div>
                <div class="col-lg-3 col-6">
                    <h6 class="fw-bold mb-3">Tautan Pintar</h6>
                    <ul class="list-unstyled small text-light opacity-75">
                        <li class="mb-2"><a href="#program" class="text-light text-decoration-none">Program
                                Pilihan</a></li>
                        <li class="mb-2"><a href="#keunggulan"
                                class="text-light text-decoration-none">Keunggulan</a></li>
                        <li class="mb-2"><a href="#harga" class="text-light text-decoration-none">Paket Tryout</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-6">
                    <h6 class="fw-bold mb-3">Hubungi Kami</h6>
                    <p class="text-light opacity-75 small m-0"><i class="fa-solid fa-location-dot me-2"></i> Jakarta /
                        Indonesia</p>
                    <p class="text-light opacity-75 small mt-2"><i class="fa-solid fa-phone me-2"></i> 0812-3456-7890
                    </p>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="text-center small opacity-50">
                &copy; 2026 Tryoutin. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
