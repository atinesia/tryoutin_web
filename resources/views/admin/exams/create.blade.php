<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Paket Tryout Baru - Admin Tryoutin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .brand-header {
            background: linear-gradient(135deg, #0f1f38 0%, #1b365d 100%);
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-custom overflow-hidden">
                    <div class="card-header brand-header p-4 border-0">
                        <h3 class="fw-bold m-0"><i class="fa-solid fa-wand-magic-sparkles text-info me-2"></i>Buat Paket
                            Tryout & AI Question Generator</h3>
                        <p class="text-light opacity-75 small m-0 mt-1">Isi rincian paket dan tentukan jumlah soal. Groq
                            AI akan secara otomatis memproduksi soal beserta kunci dan pembahasannya.</p>
                    </div>
                    <div class="card-body p-4 p-md-5">

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.exams.store') }}" method="POST" id="examForm">
                            @csrf

                            <!-- Section 1: Detail Paket -->
                            <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-box-archive me-2"></i>1.
                                Informasi & Tarif Paket</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Judul Paket Tryout</label>
                                    <input type="text" name="title" class="form-control"
                                        placeholder="Contoh: Tryout Akbar SKD CPNS 2026 - Paket Premium 1"
                                        value="{{ old('title') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Harga Paket (Rp)</label>
                                    <input type="number" name="price" class="form-control"
                                        placeholder="0 untuk GRATIS" value="{{ old('price', 0) }}" required
                                        min="0">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Deskripsi / Fasilitas Paket</label>
                                    <textarea name="description" class="form-control" rows="2"
                                        placeholder="Tuliskan fasilitas atau keterangan paket yang akan tampil di halaman catalog...">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Section 2: Durasi & Passing Grade -->
                            <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-clock me-2"></i>2. Waktu &
                                Passing Grade</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Durasi (Menit)</label>
                                    <input type="number" name="duration_minutes" class="form-control"
                                        value="{{ old('duration_minutes', 100) }}" required min="1">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Passing Grade TWK</label>
                                    <input type="number" name="passing_grade_twk" class="form-control"
                                        value="{{ old('passing_grade_twk', 65) }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Passing Grade TIU</label>
                                    <input type="number" name="passing_grade_tiu" class="form-control"
                                        value="{{ old('passing_grade_tiu', 80) }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Passing Grade TKP</label>
                                    <input type="number" name="passing_grade_tkp" class="form-control"
                                        value="{{ old('passing_grade_tkp', 166) }}" required>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Section 3: Konfigurasi Generator AI -->
                            <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-robot me-2"></i>3. Generate Soal
                                Otomatis (Groq AI)</h5>
                            <p class="text-muted small mb-3">Tentukan jumlah soal yang akan diproduksi oleh AI secara
                                presisi dan anti-halusinasi:</p>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <label class="form-label fw-bold text-dark">Jumlah Soal TWK</label>
                                        <input type="number" name="count_twk"
                                            class="form-control form-control-lg text-center fw-bold"
                                            value="{{ old('count_twk', 5) }}" min="0" required>
                                        <small class="text-muted d-block mt-1 fs-7">Nasionalisme, UUD 45,
                                            Pancasila</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <label class="form-label fw-bold text-dark">Jumlah Soal TIU</label>
                                        <input type="number" name="count_tiu"
                                            class="form-control form-control-lg text-center fw-bold"
                                            value="{{ old('count_tiu', 5) }}" min="0" required>
                                        <small class="text-muted d-block mt-1 fs-7">Verbal, Numerik, Logika</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <label class="form-label fw-bold text-dark">Jumlah Soal TKP</label>
                                        <input type="number" name="count_tkp"
                                            class="form-control form-control-lg text-center fw-bold"
                                            value="{{ old('count_tkp', 5) }}" min="0" required>
                                        <small class="text-muted d-block mt-1 fs-7">Skala Skor 1 - 5 Per Opsi</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Petunjuk Tambahan / Topik Spesifik untuk AI
                                    (Opsional)</label>
                                <input type="text" name="topic_context" class="form-control"
                                    placeholder="Contoh: Berikan penekanan pada materi Sejarah Perumusan Pancasila dan Deret Angka Kompleks"
                                    value="{{ old('topic_context') }}">
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-4">
                                <button type="submit"
                                    class="btn btn-primary btn-lg w-100 fw-bold py-3 rounded-pill shadow-sm"
                                    id="btnSubmit">
                                    <i class="fa-solid fa-gears me-2"></i> Generate Paket & Buat Soal Otomatis
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('examForm').addEventListener('submit', function() {
            let btn = document.getElementById('btnSubmit');
            btn.disabled = true;
            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Groq AI Sedang Membuat Soal (Mohon Tunggu)...';
        });
    </script>

</body>

</html>
