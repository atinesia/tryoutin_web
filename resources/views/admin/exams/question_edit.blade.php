@extends('layouts.admin')

@section('title', 'Edit Soal Ujian Lengkap')
@section('page_title', 'Edit Soal & Bobot Nilai')

@push('styles')
    <!-- Summernote WYSIWYG CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor {
            border-radius: 12px;
            overflow: hidden;
            border-color: #dee2e6;
        }

        .note-editor.note-frame .note-editing-area .note-editable {
            min-height: 80px;
        }
    </style>
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card card-custom p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div>
                        <h5 class="fw-bold m-0">Edit Detail Soal, Opsi, Bobot & Pembahasan</h5>
                        <small class="text-muted">Mendukung Rich Text Editor & Rumus Matematika MathJax di Teks Soal, Opsi,
                            dan Pembahasan</small>
                    </div>
                    <a href="{{ route('admin.exams.questions', $exam->id) }}"
                        class="btn btn-outline-secondary rounded-pill btn-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> Batal
                    </a>
                </div>

                <form action="{{ route('admin.exams.questions.update', [$exam->id, $question->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- SECTION 1: METADATA KATEGORI & KESULITAN -->
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-tags me-2"></i>Kategori & Tingkat Kesulitan
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kategori Utama</label>
                            <select name="category" class="form-select" required>
                                <option value="TWK" {{ $question->category === 'TWK' ? 'selected' : '' }}>Tes Wawasan
                                    Kebangsaan (TWK)</option>
                                <option value="TIU" {{ $question->category === 'TIU' ? 'selected' : '' }}>Tes
                                    Intelegensia Umum (TIU)</option>
                                <option value="TKP" {{ $question->category === 'TKP' ? 'selected' : '' }}>Tes
                                    Karakteristik Pribadi (TKP)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Sub-Kategori / Topik</label>
                            <input type="text" name="sub_category" class="form-control"
                                value="{{ old('sub_category', $question->sub_category) }}"
                                placeholder="Misal: Nasionalisme, Deret Angka">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Tingkat Kesulitan</label>
                            <select name="difficulty" class="form-select" required>
                                <option value="Mudah" {{ $question->difficulty === 'Mudah' ? 'selected' : '' }}>Mudah
                                </option>
                                <option value="Sedang" {{ $question->difficulty === 'Sedang' ? 'selected' : '' }}>Sedang
                                </option>
                                <option value="HOTS" {{ $question->difficulty === 'HOTS' ? 'selected' : '' }}>HOTS (High
                                    Order Thinking Skills)</option>
                            </select>
                        </div>
                    </div>

                    <!-- SECTION 2: TEKS SOAL (RICH TEXT EDITOR) -->
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-file-pen me-2"></i>Teks Soal / Pertanyaan
                    </h6>
                    <div class="mb-4">
                        <textarea name="question_text" class="summernote" required>{{ old('question_text', $question->question_text) }}</textarea>
                    </div>

                    <!-- SECTION 3: OPSI JAWABAN (RICH TEXT EDITOR PER OPSI) -->
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-list-check me-2"></i>Opsi Jawaban & Skor
                        Opsi Individual</h6>
                    <div class="row g-4 mb-4">
                        @foreach (['a', 'b', 'c', 'd', 'e'] as $opt)
                            @php
                                $optUpper = strtoupper($opt);
                                $optVal = 'option_' . $opt;
                                $scoreVal = 'score_' . $opt;
                            @endphp
                            <div class="col-12 border rounded-3 p-3 bg-light">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-10">
                                        <label class="form-label fw-bold text-dark">Teks Opsi {{ $optUpper }}</label>
                                        <textarea name="{{ $optVal }}" class="summernote-option" required>{{ old($optVal, $question->$optVal) }}</textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-bold text-primary">Skor Opsi
                                            {{ $optUpper }}</label>
                                        <input type="number" name="{{ $scoreVal }}"
                                            class="form-control text-center fw-bold fs-5"
                                            value="{{ old($scoreVal, $question->$scoreVal) }}" required>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- SECTION 4: KUNCI JAWABAN & ATURAN SKOR UMUM -->
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-award me-2"></i>Kunci Jawaban & Bobot Nilai
                        BKN</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-success">Kunci Jawaban Benar</label>
                            <select name="correct_option" class="form-select fw-bold border-success" required>
                                @foreach (['A', 'B', 'C', 'D', 'E'] as $o)
                                    <option value="{{ $o }}"
                                        {{ $question->correct_option === $o ? 'selected' : '' }}>Opsi {{ $o }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Skor Jawaban Benar</label>
                            <input type="number" name="score_right" class="form-control"
                                value="{{ old('score_right', $question->score_right ?? 5) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Skor Jawaban Salah</label>
                            <input type="number" name="score_wrong" class="form-control"
                                value="{{ old('score_wrong', $question->score_wrong ?? 0) }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Skor Tidak Dijawab</label>
                            <input type="number" name="score_unanswered" class="form-control"
                                value="{{ old('score_unanswered', $question->score_unanswered ?? 0) }}" required>
                        </div>
                    </div>

                    <!-- SECTION 5: PEMBAHASAN & TRIK CEPAT -->
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-lightbulb me-2"></i>Pembahasan & Trik Cepat
                    </h6>
                    <div class="mb-4">
                        <textarea name="explanation" class="summernote" required>{{ old('explanation', $question->discussion_text) }}</textarea>
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold py-2">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan Soal
                        </button>
                        <a href="{{ route('admin.exams.questions', $exam->id) }}"
                            class="btn btn-outline-secondary rounded-pill px-4 py-2">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>

    <script>
        $(document).ready(function() {
            // Editor Teks Soal & Pembahasan (Ukuran Sedang)
            $('.summernote').summernote({
                placeholder: 'Ketik isi teks, gambar, atau rumus matematika...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });

            // Editor Opsi Jawaban (Ukuran Compact)
            $('.summernote-option').summernote({
                placeholder: 'Ketik teks opsi atau masukkan gambar/rumus...',
                tabsize: 2,
                height: 100,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>
@endpush
