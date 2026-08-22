<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tiket Kendala - Admin Tryoutin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-light py-4">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-2"><i
                        class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard</a>
                <h3 class="fw-bold m-0">Laporan Kendala System (Tickets)</h3>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
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
                                            <option value="OPEN" {{ $t->status === 'OPEN' ? 'selected' : '' }}>OPEN
                                            </option>
                                            <option value="IN_PROGRESS"
                                                {{ $t->status === 'IN_PROGRESS' ? 'selected' : '' }}>IN_PROGRESS
                                            </option>
                                            <option value="RESOLVED" {{ $t->status === 'RESOLVED' ? 'selected' : '' }}>
                                                RESOLVED</option>
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
    </div>

</body>

</html>
