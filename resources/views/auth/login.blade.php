<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simulasi CAT BKN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1b365d;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-login {
            width: 100%;
            max-width: 420px;
            border-radius: 12px;
        }
    </style>
</head>

<body>

    <div class="card card-login shadow-lg border-0 p-4">
        <div class="card-body">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary">Simulasi CAT CPNS</h3>
                <p class="text-muted small">Masuk untuk memulai ujian simulasi</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2 fs-7">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="lukman@test.com" required
                        placeholder="nama@email.com">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" value="password123" required
                        placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Masuk Ujian</button>
            </form>

            <div class="text-center mt-4">
                <small class="text-muted">Belum punya akun? <a href="{{ route('register') }}"
                        class="text-decoration-none">Daftar Sekarang</a></small>
            </div>
        </div>
    </div>

</body>

</html>
