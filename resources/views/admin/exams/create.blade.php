@extends('layouts.admin')

@section('title', 'AI Question Generator Specialist')
@section('page_title', 'AI Question Generator (Assessment Specialist BKN)')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-custom p-4 p-md-5">
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                        <i class="fa-solid fa-robot fs-3"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold m-0">Senior Assessment Specialist Generator</h5>
                        <small class="text-muted">Generate bank soal SKD CPNS & Kedinasan otomatis beserta kunci dan bobot
                            skor resmi BKN</small>
                    </div>
                </div>

                <form action="{{ route('admin.exams.store') }}" method="POST">
                    @csrf

                    <!-- Detail Paket Exam -->
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-file-signature me-2"></i>Pengaturan Paket
                        Ujian (Exam)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold">Judul Paket Ujian</label>
                            <input type="text" name="title" class="form-control"
                                placeholder="Contoh: Tryout Spesialis SKD CPNS 2026 - Paket 1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Harga Paket (Rp)</label>
                            <input type="number" name="price" class="form-control" value="50000" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Durasi (Menit)</label>
                            <input type="number" name="duration_minutes" class="form-control" value="100" required>
                        </div>
                    </div>

                    <!-- Detail Parameter Soal (Question) -->
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-list-check me-2"></i>Parameter Bank Soal
                        (Questions)</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jenis Soal (Category)</label>
                            <select name="category" id="categorySelect" class="form-select" required>
                                <option value="TWK">Tes Wawasan Kebangsaan (TWK)</option>
                                <option value="TIU">Tes Intelegensia Umum (TIU)</option>
                                <option value="TKP">Tes Karakteristik Pribadi (TKP)</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Sub-Tes (Otomatis Sesuai Kategori)</label>
                            <select name="sub_category" id="subCategorySelect" class="form-select" required>
                                <!-- Otomatis Diisi via JS -->
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tingkat Kesulitan (Difficulty)</label>
                            <select name="difficulty" class="form-select" required>
                                <option value="Sedang">Sedang (Standard BKN)</option>
                                <option value="HOTS" selected>HOTS (High Order Thinking Skills)</option>
                                <option value="Mudah">Mudah</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Jumlah Soal Di-generate</label>
                            <input type="number" name="question_count" class="form-control" value="5" min="1"
                                max="20" required>
                            <small class="text-muted fs-7">*Rekomendasi 5-10 soal per sekali batch request AI</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow-sm">
                        <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Generate Soal, Pembahasan & Bobot Skor
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const categorySelect = document.getElementById('categorySelect');
                const subCategorySelect = document.getElementById('subCategorySelect');

                const subCategories = {
                    'TWK': ['Nasionalisme', 'Integritas', 'Bela Negara', 'Pilar Negara', 'Bahasa Indonesia'],
                    'TIU': ['Verbal (Analogi/Silogisme)', 'Numerik (Deret/Berhitung Cepat)', 'Penalaran Analitis',
                        'Figural'
                    ],
                    'TKP': ['Pelayanan Publik', 'Jejaring Kerja', 'Sosial Budaya', 'TIK', 'Profesionalisme',
                        'Anti-Radikalisme'
                    ]
                };

                function updateSubCategories() {
                    const selectedCategory = categorySelect.value;
                    const options = subCategories[selectedCategory] || [];

                    subCategorySelect.innerHTML = '';
                    options.forEach(sub => {
                        const opt = document.createElement('option');
                        opt.value = sub;
                        opt.textContent = sub;
                        subCategorySelect.appendChild(opt);
                    });
                }

                categorySelect.addEventListener('change', updateSubCategories);
                updateSubCategories();
            });
        </script>
    @endpush
@endsection
