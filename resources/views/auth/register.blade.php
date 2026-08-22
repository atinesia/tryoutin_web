<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Tryoutin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f1f38 0%, #1b365d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-register {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 480px;
        }

        .btn-primary-custom {
            background: #00d2ff;
            border: none;
            color: #0f1f38;
            font-weight: 700;
            border-radius: 10px;
        }

        .btn-primary-custom:hover {
            background: #00b8e6;
            color: #0f1f38;
        }
    </style>
</head>

<body class="py-5">

    <div class="container d-flex justify-content-center">
        <div class="card card-register p-4 p-md-5 bg-white">
            <div class="text-center mb-4">
                <a href="/" class="h3 fw-bold text-decoration-none text-dark d-block mb-1">
                    <i class="fa-solid fa-graduation-cap text-info me-2"></i>Tryout<span class="text-primary">in</span>
                </a>
                <p class="text-muted small">Buat akun untuk mulai simulasi CAT SKD CPNS</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 rounded-3 small mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Referral Hidden (Jika Ada) -->
                @if (isset($ref))
                    <input type="hidden" name="referred_by" value="{{ $ref }}">
                @endif

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i
                                class="fa-regular fa-user"></i></span>
                        <input type="text" name="name" class="form-control border-start-0 bg-light"
                            placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i
                                class="fa-regular fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control border-start-0 bg-light"
                            placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Asal Sekolah / Instansi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i
                                class="fa-solid fa-school"></i></span>
                        <input type="text" name="school_origin" class="form-control border-start-0 bg-light"
                            placeholder="Contoh: SMAN 1 Jakarta / Universitas Indonesia"
                            value="{{ old('school_origin') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i
                                class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 bg-light"
                            placeholder="Minimal 8 karakter" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small text-secondary">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i
                                class="fa-solid fa-shield-halved"></i></span>
                        <input type="password" name="password_confirmation" class="form-control border-start-0 bg-light"
                            placeholder="Ulangi password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-2 mb-3">Daftar Sekarang</button>

                <div class="text-center">
                    <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}"
                            class="text-primary fw-semibold text-decoration-none">Masuk di sini</a></small>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
