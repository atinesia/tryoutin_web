<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola User - Tryoutin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: #f4f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .main-wrapper {
            max-width: 1200px;
            margin: 40px auto;
        }
    </style>
</head>

<body>

    <div class="container main-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-2"><i
                        class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard</a>
                <h3 class="fw-bold m-0">Manajemen Pengguna & Hak Akses</h3>
            </div>
            <button class="btn btn-primary rounded-pill px-4 fw-bold" data-bs-toggle="modal"
                data-bs-target="#modalAddUser">
                <i class="fa-solid fa-plus me-1"></i> Tambah User Baru
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Asal Sekolah</th>
                            <th>Role Saat Ini</th>
                            <th>Ubah Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)
                            <tr>
                                <td class="fw-bold">{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->school_origin ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge {{ $u->role === 'admin' ? 'bg-danger' : ($u->role === 'tutor' ? 'bg-info' : ($u->role === 'affiliate' ? 'bg-warning text-dark' : 'bg-secondary')) }}">
                                        {{ strtoupper($u->role) }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.users.updateRole', $u->id) }}" method="POST"
                                        class="d-flex gap-2">
                                        @csrf
                                        <select name="role" class="form-select form-select-sm w-auto">
                                            <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User
                                                (Siswa)</option>
                                            <option value="tutor" {{ $u->role === 'tutor' ? 'selected' : '' }}>Tutor
                                            </option>
                                            <option value="affiliate" {{ $u->role === 'affiliate' ? 'selected' : '' }}>
                                                Afiliator</option>
                                            <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="modalAddUser" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.users.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah User System Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role Access</label>
                        <select name="role" class="form-select" required>
                            <option value="tutor">Tutor (Pembuat Soal)</option>
                            <option value="affiliate">Afiliator</option>
                            <option value="admin">Super Admin</option>
                            <option value="user">User (Siswa)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Default</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan User</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
