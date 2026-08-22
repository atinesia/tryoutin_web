@extends('layouts.admin')

@section('title', 'Tiket Kendala')
@section('page_title', 'Laporan Kendala Sistem')

@section('content')
    <div class="card card-custom p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Pelapor</th>
                        <th>Subjek</th>
                        <th>Isi Pesan / Kendala</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $t)
                        <tr>
                            <td>
                                <strong>{{ $t->user->name }}</strong><br>
                                <small class="text-muted">{{ $t->user->email }}</small>
                            </td>
                            <td class="fw-bold text-primary">{{ $t->subject }}</td>
                            <td class="small">{{ $t->message }}</td>
                            <td>
                                <span
                                    class="badge {{ $t->status === 'OPEN' ? 'bg-danger' : ($t->status === 'IN_PROGRESS' ? 'bg-warning text-dark' : 'bg-success') }}">
                                    {{ $t->status }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.tickets.updateStatus', $t->id) }}" method="POST"
                                    class="d-flex gap-2">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm w-auto">
                                        <option value="OPEN" {{ $t->status === 'OPEN' ? 'selected' : '' }}>OPEN</option>
                                        <option value="IN_PROGRESS" {{ $t->status === 'IN_PROGRESS' ? 'selected' : '' }}>
                                            IN_PROGRESS</option>
                                        <option value="RESOLVED" {{ $t->status === 'RESOLVED' ? 'selected' : '' }}>RESOLVED
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
