@extends('layouts.admin')

@section('title', 'Daftar Paket Soal')
@section('page_title', 'Daftar Paket Ujian & Bank Soal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted small m-0">Pilih paket ujian untuk melihat dan mengelola daftar soal di dalamnya</p>
        <a href="{{ route('admin.exams.create') }}" class="btn btn-primary rounded-pill px-4 fw-bold">
            <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Generate Paket Baru (AI)
        </a>
    </div>

    <div class="row g-4">
        @forelse($exams as $exam)
            <div class="col-md-6 col-lg-4">
                <div class="card card-custom p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">
                                <i class="fa-solid fa-clock me-1"></i> {{ $exam->duration_minutes }} Menit
                            </span>
                            <span class="badge bg-info text-dark fw-bold px-3 py-2 rounded-pill">
                                {{ $exam->questions_count }} Soal
                            </span>
                        </div>

                        <h5 class="fw-bold text-dark mb-2">{{ $exam->title }}</h5>
                        <p class="text-muted small mb-3">
                            Harga Paket: <strong class="text-success">Rp
                                {{ number_format($exam->price, 0, ',', '.') }}</strong>
                        </p>
                    </div>

                    <div class="pt-3 border-top mt-3">
                        <a href="{{ route('admin.exams.questions', $exam->id) }}"
                            class="btn btn-outline-primary w-100 rounded-pill fw-bold py-2">
                            <i class="fa-solid fa-list-check me-2"></i> Lihat & Kelola Soal
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card card-custom p-5 text-center text-muted">
                    <i class="fa-solid fa-folder-open fs-1 mb-3 text-secondary"></i>
                    <h6 class="fw-bold m-0">Belum Ada Paket Ujian</h6>
                    <p class="small mb-3">Gunakan AI Question Generator untuk membuat paket soal pertama Anda.</p>
                    <div>
                        <a href="{{ route('admin.exams.create') }}" class="btn btn-sm btn-primary rounded-pill px-4">
                            Buat Paket Sekarang
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection
