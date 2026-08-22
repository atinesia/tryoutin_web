@extends('layouts.admin')

@section('title', 'Daftar Soal Paket')
@section('page_title', 'Daftar Soal: ' . $exam->title)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.exams.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Paket
        </a>
        <span class="badge bg-info text-dark fs-6">Total: {{ $exam->questions->count() }} Soal</span>
    </div>

    <div class="row g-4">
        @foreach ($exam->questions as $index => $q)
            <div class="col-12">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-primary fs-6 me-2">Soal No. {{ $index + 1 }}</span>
                            <span class="badge bg-secondary">{{ $q->category }} - {{ $q->sub_category ?? 'Umum' }}</span>
                            <span class="badge bg-warning text-dark">{{ $q->difficulty }}</span>
                        </div>
                        <a href="{{ route('admin.exams.questions.edit', [$exam->id, $q->id]) }}"
                            class="btn btn-sm btn-warning rounded-pill px-3">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit Soal Lengkap
                        </a>
                    </div>

                    <!-- Teks Soal (Render HTML + MathJax) -->
                    <div class="fw-semibold text-dark mb-3 fs-5">{!! $q->question_text !!}</div>

                    <!-- Opsi Jawaban beserta Bobot Skor (Render Rich Text HTML) -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <div
                                class="p-3 border rounded-3 {{ $q->correct_option === 'A' ? 'border-success bg-success bg-opacity-10' : 'bg-white' }}">
                                <strong>A.</strong> {!! $q->option_a !!}
                                <div class="mt-2 text-muted small">Skor: <span class="fw-bold">{{ $q->score_a }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div
                                class="p-3 border rounded-3 {{ $q->correct_option === 'B' ? 'border-success bg-success bg-opacity-10' : 'bg-white' }}">
                                <strong>B.</strong> {!! $q->option_b !!}
                                <div class="mt-2 text-muted small">Skor: <span class="fw-bold">{{ $q->score_b }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div
                                class="p-3 border rounded-3 {{ $q->correct_option === 'C' ? 'border-success bg-success bg-opacity-10' : 'bg-white' }}">
                                <strong>C.</strong> {!! $q->option_c !!}
                                <div class="mt-2 text-muted small">Skor: <span class="fw-bold">{{ $q->score_c }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div
                                class="p-3 border rounded-3 {{ $q->correct_option === 'D' ? 'border-success bg-success bg-opacity-10' : 'bg-white' }}">
                                <strong>D.</strong> {!! $q->option_d !!}
                                <div class="mt-2 text-muted small">Skor: <span class="fw-bold">{{ $q->score_d }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div
                                class="p-3 border rounded-3 {{ $q->correct_option === 'E' ? 'border-success bg-success bg-opacity-10' : 'bg-white' }}">
                                <strong>E.</strong> {!! $q->option_e !!}
                                <div class="mt-2 text-muted small">Skor: <span class="fw-bold">{{ $q->score_e }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pembahasan -->
                    <div class="bg-light p-3 rounded-3 small">
                        <strong><i class="fa-solid fa-lightbulb text-warning me-1"></i> Pembahasan:</strong>
                        <div class="m-0 text-muted mt-1">{!! $q->discussion_text !!}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
@endpush
