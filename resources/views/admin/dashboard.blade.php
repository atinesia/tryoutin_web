@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Control Center')

@section('content')
    <!-- Stats Grid -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-custom p-3">
                <small class="text-muted fw-bold">TOTAL OMSET</small>
                <h3 class="fw-bold text-success m-0 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom p-3">
                <small class="text-muted fw-bold">TOTAL USER</small>
                <h3 class="fw-bold text-primary m-0 mt-1">{{ $totalUsers }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom p-3">
                <small class="text-muted fw-bold">PAKET UJIAN</small>
                <h3 class="fw-bold text-info m-0 mt-1">{{ $totalExams }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom p-3">
                <small class="text-muted fw-bold">TIKET OPEN</small>
                <h3 class="fw-bold text-warning m-0 mt-1">{{ $pendingTickets }}</h3>
            </div>
        </div>
    </div>

    <!-- Data Tables -->
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card card-custom p-4">
                <h6 class="fw-bold mb-3"><i class="fa-solid fa-receipt text-primary me-2"></i>Transaksi Pembayaran Terbaru
                </h6>
                <table class="table align-middle small mb-0">
                    <thead>
                        <tr>
                            <th>Ref</th>
                            <th>User</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $o)
                            <tr>
                                <td><strong>{{ $o->reference }}</strong></td>
                                <td>{{ $o->user->name ?? '-' }}</td>
                                <td class="fw-bold">Rp {{ number_format($o->amount, 0, ',', '.') }}</td>
                                <td><span
                                        class="badge {{ $o->status === 'PAID' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $o->status }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card card-custom p-4">
                <h6 class="fw-bold mb-3"><i class="fa-solid fa-headset text-warning me-2"></i>Laporan Kendala Terbaru</h6>
                <div class="list-group list-group-flush small">
                    @foreach ($tickets as $t)
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $t->subject }}</strong>
                                <span
                                    class="badge {{ $t->status === 'OPEN' ? 'bg-danger' : 'bg-success' }}">{{ $t->status }}</span>
                            </div>
                            <p class="m-0 text-muted fs-7">{{ $t->user->name }} - {{ $t->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
