<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian & Pembahasan - Tryoutin</title>
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

        /* Navbar / Header Brand Tryoutin */
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

        /* Banner Status Skor Utama */
        .hero-score-card {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(27, 54, 93, 0.08);
            position: relative;
            overflow: hidden;
        }

        .hero-score-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
        }

        .hero-passed::before {
            background: linear-gradient(90deg, #198754, #20c997);
        }

        .hero-failed::before {
            background: linear-gradient(90deg, #dc3545, #ff6b6b);
        }

        .score-display {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1;
        }

        /* Base Card Styling */
        .custom-card {
            border: none;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s ease;
        }

        /* AI Recommendation Box */
        .ai-card {
            background: linear-gradient(135deg, #f8faff 0%, #eef4ff 100%);
            border: 1px solid #d0e1ff !important;
        }

        /* Pembahasan Soal */
        .question-card {
            border-left: 5px solid #ccc;
        }

        .question-card.is-correct {
            border-left-color: #198754;
        }

        .question-card.is-wrong {
            border-left-color: #dc3545;
        }

        .opt-box {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.9rem;
            border: 1px solid #e9ecef;
            background-color: #f8f9fa;
        }

        .opt-correct {
            background-color: #d1e7dd !important;
            border-color: #198754 !important;
            color: #0f5132 !important;
            font-weight: 600;
        }

        .opt-wrong {
            background-color: #f8d7da !important;
            border-color: #dc3545 !important;
            color: #842029 !important;
            font-weight: 600;
        }

        .opt-key {
            border: 1px solid #198754 !important;
            color: #198754 !important;
            font-weight: 600;
        }

        .badge-brand {
            background-color: var(--brand-primary);
            color: white;
        }
    </style>
</head>

<body>

    <!-- Header Top Navigation -->
    <nav class="navbar brand-navbar py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand brand-logo m-0" href="#">
                <i class="fa-solid fa-graduation-cap text-info me-2"></i>Tryout<span>in</span>
            </a>
            <div class="text-white small">
                <i class="fa-regular fa-circle-user me-1 text-info"></i> {{ $userExam->user->name }}
            </div>
        </div>
    </nav>

    <div class="container pb-5">

        <!-- 1. Hero Card Status Kelulusan & Total Skor -->
        <div
            class="card hero-score-card {{ $userExam->is_passed ? 'hero-passed' : 'hero-failed' }} p-4 mb-4 text-center">
            <div class="card-body py-3">
                @if ($userExam->is_passed)
                    <span class="badge bg-success bg-opacity-10 text-success fs-6 px-3 py-2 rounded-pill mb-3">
                        <i class="fa-solid fa-circle-check me-1"></i> SELAMAT! ANDA LULUS PASSING GRADE
                    </span>
                    <div class="score-display text-success my-2">{{ $userExam->total_score }}</div>
                @else
                    <span class="badge bg-danger bg-opacity-10 text-danger fs-6 px-3 py-2 rounded-pill mb-3">
                        <i class="fa-solid fa-circle-xmark me-1"></i> BELUM LULUS PASSING GRADE
                    </span>
                    <div class="score-display text-danger my-2">{{ $userExam->total_score }}</div>
                @endif

                <p class="text-muted m-0 fs-6">
                    Peringkat Nasional Anda: <strong class="text-dark">#{{ $userRank }}</strong> dari total peserta
                </p>
            </div>
        </div>

        <!-- 2. AI Mentor & Pemetaan Performa -->
        <div class="row g-4 mb-4">
            <!-- AI Advisor -->
            <div class="col-lg-7">
                <div class="card custom-card ai-card h-100 p-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-robot"></i>
                            </div>
                            <h5 class="fw-bold m-0 text-primary">Analisis & Rekomendasi Groq AI</h5>
                        </div>
                        <div class="lh-lg text-secondary small">
                            {!! nl2br(e($aiAnalysis)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Matriks Kekuatan & Kelemahan -->
            <div class="col-lg-5">
                <div class="card custom-card h-100 p-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3"><i class="fa-solid fa-bullseye text-danger me-2"></i>Pemetaan Performa
                        </h5>

                        <div class="mb-3">
                            <small class="text-muted d-block fw-bold mb-2">AREA KEKUATAN:</small>
                            @forelse($strengths as $str)
                                <span
                                    class="badge bg-success bg-opacity-10 text-success fs-6 me-1 mb-1 px-3 py-2 rounded-pill">
                                    <i class="fa-solid fa-check me-1"></i> {{ $str }}
                                </span>
                            @empty
                                <span class="text-muted small">Belum ada kategori yang melampaui passing grade.</span>
                            @endforelse
                        </div>

                        <hr class="my-3">

                        <div>
                            <small class="text-muted d-block fw-bold mb-2">AREA PERLU EVALUASI:</small>
                            @forelse($weaknesses as $weak)
                                <span
                                    class="badge bg-warning bg-opacity-20 text-dark fs-6 me-1 mb-1 px-3 py-2 rounded-pill">
                                    <i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i>
                                    {{ $weak }}
                                </span>
                            @empty
                                <span class="text-success small fw-semibold">Luar biasa! Semua kategori melampaui
                                    passing grade.</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Rincian Statistik Kategori & Leaderboard -->
        <div class="row g-4 mb-4">
            <!-- Table Rincian Nilai -->
            <div class="col-lg-6">
                <div class="card custom-card h-100">
                    <div class="card-header bg-white fw-bold py-3 border-0">
                        <i class="fa-solid fa-chart-pie me-2 text-primary"></i>Rincian SKD Per Kategori
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle m-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Kategori</th>
                                        <th>Nilai</th>
                                        <th>Benar</th>
                                        <th>Salah</th>
                                        <th>Kosong</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stats as $cat => $st)
                                        <tr>
                                            <td class="ps-3"><strong>{{ $cat }}</strong></td>
                                            <td class="fw-bold text-primary">{{ $st['score'] }}</td>
                                            <td><span class="badge bg-success px-2 py-1">{{ $st['correct'] }}</span>
                                            </td>
                                            <td><span class="badge bg-danger px-2 py-1">{{ $st['wrong'] }}</span></td>
                                            <td><span class="badge bg-secondary px-2 py-1">{{ $st['empty'] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leaderboard -->
            <div class="col-lg-6">
                <div class="card custom-card h-100">
                    <div class="card-header bg-white fw-bold py-3 border-0">
                        <i class="fa-solid fa-trophy me-2 text-warning"></i>Leaderboard 10 Besar
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle m-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">#</th>
                                        <th>Peserta</th>
                                        <th>TWK</th>
                                        <th>TIU</th>
                                        <th>TKP</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($leaderboard as $index => $rank)
                                        <tr
                                            class="{{ $rank->user_id === auth()->id() ? 'table-primary fw-bold' : '' }}">
                                            <td class="ps-3">
                                                @if ($index == 0)
                                                    <i class="fa-solid fa-crown text-warning"></i>
                                                @elseif($index == 1)
                                                    <i class="fa-solid fa-medal text-secondary"></i>
                                                @elseif($index == 2)
                                                    <i class="fa-solid fa-award text-danger"></i>
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </td>
                                            <td>{{ $rank->user->name }}</td>
                                            <td>{{ $rank->score_twk }}</td>
                                            <td>{{ $rank->score_tiu }}</td>
                                            <td>{{ $rank->score_tkp }}</td>
                                            <td class="fw-bold text-primary">{{ $rank->total_score }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Lembar Pembahasan Soal -->
        <div class="card custom-card mb-4">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold m-0"><i class="fa-solid fa-book-open me-2 text-info"></i>Pembahasan Soal Lengkap</h5>
                <span class="badge badge-brand fs-7 px-3 py-2 rounded-pill">Total: {{ count($questions) }} Soal</span>
            </div>
            <div class="card-body p-4">
                @foreach ($questions as $index => $q)
                    @php
                        $ans = $answers[$q->id] ?? null;
                        $userOpt = $ans ? $ans->selected_option : 'Tidak Dijawab';
                        $scoreObtained = $ans ? $ans->score_obtained : 0;
                    @endphp

                    <div
                        class="card question-card {{ $scoreObtained > 0 ? 'is-correct' : 'is-wrong' }} p-3 mb-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-primary">Soal No. {{ $index + 1 }} <span
                                    class="badge bg-secondary ms-1">{{ $q->category }}</span></span>
                            @if ($scoreObtained > 0)
                                <span class="badge bg-success"><i class="fa-solid fa-plus me-1"></i>Poin:
                                    {{ $scoreObtained }}</span>
                            @else
                                <span class="badge bg-danger"><i class="fa-solid fa-xmark me-1"></i>Poin: 0</span>
                            @endif
                        </div>

                        <p class="fs-6 mb-3 text-dark">{!! $q->question_text !!}</p>

                        <!-- Pilihan Opsi -->
                        <div class="row g-2 mb-3">
                            @foreach (['a', 'b', 'c', 'd', 'e'] as $opt)
                                @php
                                    $optUpper = strtoupper($opt);
                                    $optText = $q->{'option_' . $opt};
                                    $optScore = $q->{'score_' . $opt};

                                    $bgClass = 'opt-box';
                                    if ($userOpt === $optUpper && $optScore > 0) {
                                        $bgClass .= ' opt-correct';
                                    } elseif ($userOpt === $optUpper && $optScore == 0) {
                                        $bgClass .= ' opt-wrong';
                                    } elseif ($optScore == 5) {
                                        $bgClass .= ' opt-key';
                                    }
                                @endphp
                                @if ($optText)
                                    <div class="col-md-6">
                                        <div class="{{ $bgClass }}">
                                            <strong>{{ $optUpper }}.</strong> {{ $optText }}
                                            @if ($q->category === 'TKP')
                                                <span class="float-end badge bg-secondary opacity-75">Poin:
                                                    {{ $optScore }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Pembahasan Soal -->
                        <div class="bg-light p-3 rounded border-start border-4 border-info">
                            <strong class="text-info"><i class="fa-solid fa-lightbulb me-1"></i> Pembahasan:</strong>
                            <p class="m-0 mt-1 text-secondary small">{!! $q->discussion_text ?? 'Pembahasan belum tersedia.' !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Navigation Footer -->
        <div class="text-center mt-4">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger px-4 py-2 rounded-pill fw-bold">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar / Logout
                </button>
            </form>
        </div>

    </div>

</body>

</html>
