<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Tryoutin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white border-bottom py-3 mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#"><i
                    class="fa-solid fa-graduation-cap me-2"></i>Tryoutin</a>
            <div class="d-flex align-items-center gap-3">
                <span class="small text-muted"><i class="fa-solid fa-school me-1"></i>
                    {{ auth()->user()->school_origin }}</span>
                <button class="btn btn-sm btn-outline-warning rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#modalKendala">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> Lapor Kendala
                </button>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-3">

        @if (session('success'))
            <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
        @endif

        <!-- Header Profil -->
        <div class="card card-custom p-4 mb-4 bg-primary text-white"
            style="background: linear-gradient(135deg, #0f1f38, #1b365d);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold m-0">Halo, {{ auth()->user()->name }}! 👋</h3>
                    <p class="m-0 opacity-75 small">Asal Sekolah/Instansi: {{ auth()->user()->school_origin }}</p>
                </div>
                <a href="{{ route('exam.index') }}" class="btn btn-info text-white fw-bold rounded-pill px-4">Beli Paket
                    Baru</a>
            </div>
        </div>

        <!-- Daftar Ujian Diberikan / Dikerjakan -->
        <h5 class="fw-bold mb-3"><i class="fa-solid fa-box-archive text-primary me-2"></i>Paket Tryout Saya</h5>

        <div class="row g-3">
            @forelse($purchasedExams as $item)
                @php
                    $userExam = $item->userExams->where('user_id', auth()->id())->first();
                    $isFinished = $userExam && $userExam->status === 'FINISHED';
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card card-custom p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <span class="badge {{ $isFinished ? 'bg-success' : 'bg-warning text-dark' }} mb-2">
                                {{ $isFinished ? 'Selesai Dikerjakan' : 'Belum Selesai' }}
                            </span>
                            <h5 class="fw-bold text-dark mb-1">{{ $item->title }}</h5>
                            <p class="text-muted small mb-3">Durasi: {{ $item->duration_minutes }} Menit</p>
                        </div>

                        <div>
                            @if ($isFinished)
                                <!-- Dibatasi: Hanya Boleh Lihat Hasil -->
                                <a href="{{ route('exam.result', $userExam->id) }}"
                                    class="btn btn-outline-primary w-100 rounded-pill fw-bold">
                                    <i class="fa-solid fa-chart-bar me-1"></i> Lihat Hasil & Pembahasan
                                </a>
                            @else
                                <a href="{{ route('exam.show', $item->id) }}"
                                    class="btn btn-primary w-100 rounded-pill fw-bold">
                                    <i class="fa-solid fa-play me-1"></i> Kerjakan Ujian
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Anda belum memiliki paket ujian. Silakan beli paket gratis/berbayar.</p>
                    <a href="{{ route('exam.index') }}" class="btn btn-primary rounded-pill">Lihat Katalog Ujian</a>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Modal Lapor Kendala -->
    <div class="modal fade" id="modalKendala" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('ticket.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Laporkan Kendala Sistem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subjek Laporan</label>
                        <input type="text" name="subject" class="form-control"
                            placeholder="Misal: Kendala Pembayaran / Error Soal No 5" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Detail Kendala</label>
                        <textarea name="message" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Kirim Laporan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
