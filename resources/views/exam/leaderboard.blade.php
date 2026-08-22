<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Leaderboard Nasional - {{ $exam->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background: #f4f7fa;
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>

<body class="py-4">

    <div class="container" style="max-width: 900px;">
        <div class="text-center mb-4">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-2"><i class="fa-solid fa-trophy me-1"></i>
                RANKING NASIONAL</span>
            <h3 class="fw-bold text-dark">{{ $exam->title }}</h3>
            <p class="text-muted small">Peringkat resmi peserta berdasarkan Total Nilai SKD</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Peringkat</th>
                            <th>Nama Peserta</th>
                            <th>Asal Sekolah</th>
                            <th class="text-center">TWK</th>
                            <th class="text-center">TIU</th>
                            <th class="text-center">TKP</th>
                            <th class="text-center">Total Skor</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rankings as $index => $r)
                            <tr>
                                <td class="text-center fw-bold">
                                    @if ($index === 0)
                                        <span class="badge bg-warning text-dark fs-6 rounded-circle">🥇 1</span>
                                    @elseif($index === 1)
                                        <span class="badge bg-secondary fs-6 rounded-circle">🥈 2</span>
                                    @elseif($index === 2)
                                        <span class="badge bg-danger fs-6 rounded-circle">🥉 3</span>
                                    @else
                                        #{{ $index + 1 }}
                                    @endif
                                </td>
                                <td class="fw-bold text-dark">{{ $r->user->name }}</td>
                                <td class="small text-muted">{{ $r->user->school_origin ?? '-' }}</td>
                                <td class="text-center">{{ $r->score_twk }}</td>
                                <td class="text-center">{{ $r->score_tiu }}</td>
                                <td class="text-center">{{ $r->score_tkp }}</td>
                                <td class="text-center fw-bold text-primary fs-5">{{ $r->total_score }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $r->is_passed ? 'bg-success' : 'bg-danger' }}">
                                        {{ $r->is_passed ? 'LULUS' : 'TIDAK LULUS' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada peserta yang
                                    menyelesaikan ujian ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
