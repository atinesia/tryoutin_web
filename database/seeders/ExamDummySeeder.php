<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Exam;
use App\Models\Question;
use App\Models\UserExam;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ExamDummySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Utama untuk Login Testing
        $mainUser = User::create([
            'name' => 'Lukman (Peserta Testing)',
            'email' => 'lukman@test.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Buat Master Paket Ujian (Exam)
        $exam = Exam::create([
            'title' => 'Tryout Akbar SKD CPNS 2026 - Paket Premium 1',
            'description' => 'Simulasi ujian SKD CPNS standar BKN meliputi Tes Wawasan Kebangsaan (TWK), Tes Inteligensia Umum (TIU), dan Tes Karakteristik Pribadi (TKP).',
            'duration_minutes' => 100,
            'price' => 49000,
            'passing_grade_twk' => 65,
            'passing_grade_tiu' => 80,
            'passing_grade_tkp' => 166,
            'is_published' => true,
        ]);

        // 3. Buat Bank Soal Dummy (TWK, TIU, TKP)
        $questionsData = [
            // --- SOAL TWK ---
            [
                'exam_id' => $exam->id,
                'category' => 'TWK',
                'question_text' => 'Pancasila sebagai dasar negara Indonesia dipergunakan untuk...',
                'option_a' => 'Mengatur kehidupan bermasyarakat di wilayah Indonesia',
                'option_b' => 'Membatasi hubungan kerja sama dengan negara asing',
                'option_c' => 'Mengatur penyelenggaraan ketatanegaraan negara',
                'option_d' => 'Menyusun undang-undang dasar tanpa keterlibatan rakyat',
                'option_e' => 'Menjadi pegangan hidup kelompok tertentu saja',
                'score_a' => 0,
                'score_b' => 0,
                'score_c' => 5,
                'score_d' => 0,
                'score_e' => 0,
                'discussion_text' => 'Pancasila sebagai dasar negara berfungsi sebagai landasan dan asas dalam mengatur penyelenggaraan pemerintahan serta ketatanegaraan Indonesia.'
            ],
            [
                'exam_id' => $exam->id,
                'category' => 'TWK',
                'question_text' => 'Prinsip Bhinneka Tunggal Ika dalam kehidupan berbangsa mengartikan bahwa...',
                'option_a' => 'Semua perbedaan harus diseragamkan menjadi satu budaya',
                'option_b' => 'Keberagaman adalah kekayaan bangsa yang harus dijunjung tinggi dalam persatuan',
                'option_c' => 'Suku mayoritas berhak menentukan kebijakan publik secara sepihak',
                'option_d' => 'Bahasa daerah dihapuskan dan diganti bahasa tunggal',
                'option_e' => 'Setiap daerah dibebaskan membuat hukum dasar sendiri',
                'score_a' => 0,
                'score_b' => 5,
                'score_c' => 0,
                'score_d' => 0,
                'score_e' => 0,
                'discussion_text' => 'Bhinneka Tunggal Ika mengajarkan bahwa meskipun Indonesia memiliki beragam suku, agama, dan budaya, persatuan bangsa tetap menjadi hal yang paling utama.'
            ],

            // --- SOAL TIU ---
            [
                'exam_id' => $exam->id,
                'category' => 'TIU',
                'question_text' => 'Jika x = 4 dan y = 5, maka nilai dari 2x² + 3y adalah...',
                'option_a' => '32',
                'option_b' => '47',
                'option_c' => '51',
                'option_d' => '41',
                'option_e' => '39',
                'score_a' => 0,
                'score_b' => 5,
                'score_c' => 0,
                'score_d' => 0,
                'score_e' => 0,
                'discussion_text' => 'Substitusi nilai: 2(4)² + 3(5) = 2(16) + 15 = 32 + 15 = 47.'
            ],
            [
                'exam_id' => $exam->id,
                'category' => 'TIU',
                'question_text' => 'ANALOGI KATA: Mobil : Bensin = Manusia : ...',
                'option_a' => 'Air',
                'option_b' => 'Makanan',
                'option_c' => 'Oksigen',
                'option_d' => 'Pakaian',
                'option_e' => 'Rumah',
                'score_a' => 0,
                'score_b' => 5,
                'score_c' => 0,
                'score_d' => 0,
                'score_e' => 0,
                'discussion_text' => 'Hubungan fungsi energi: Mobil membutuhkan bensin untuk bergerak/beroperasi, sebagaimana manusia membutuhkan makanan sebagai sumber energi utama.'
            ],
            [
                'exam_id' => $exam->id,
                'category' => 'TIU',
                'question_text' => 'Deret Angka: 2, 4, 8, 16, 32, ... Berapakah angka selanjutnya?',
                'option_a' => '48',
                'option_b' => '60',
                'option_c' => '64',
                'option_d' => '128',
                'option_e' => '96',
                'score_a' => 0,
                'score_b' => 0,
                'score_c' => 5,
                'score_d' => 0,
                'score_e' => 0,
                'discussion_text' => 'Pola deret angka ini dikali 2 untuk setiap suku berikutnya (2x2=4, 4x2=8, dst). Maka 32 x 2 = 64.'
            ],

            // --- SOAL TKP (Skor Bertingkat 1 - 5) ---
            [
                'exam_id' => $exam->id,
                'category' => 'TKP',
                'question_text' => 'Ketika Anda ditugaskan menyelesaikan pekerjaan penting dalam waktu singkat, tiba-tiba komputer Anda mengalami crash/kerusakan. Sikap Anda adalah...',
                'option_a' => 'Langsung melapor ke atasan dan meminta perpanjangan tenggat waktu.',
                'option_b' => 'Panik dan mencoba memperbaiki komputer sendiri sampai selesai.',
                'option_c' => 'Segera meminjam laptop rekan kerja atau menggunakan komputer cadangan untuk menyelesaikan tugas.',
                'option_d' => 'Menunggu staf IT datang membetulkan komputer Anda.',
                'option_e' => 'Menyerahkan pekerjaan tersebut kepada rekan kerja lain.',
                'score_a' => 3,
                'score_b' => 2,
                'score_c' => 5,
                'score_d' => 4,
                'score_e' => 1,
                'discussion_text' => 'Opsi C berbobot nilai 5 karena menunjukkan inisiatif tinggi, orientasi pada solusi, serta tanggung jawab terhadap penyelesaian tugas tanpa membuang waktu.'
            ],
            [
                'exam_id' => $exam->id,
                'category' => 'TKP',
                'question_text' => 'Atasan Anda memberikan instruksi kerja yang kurang jelas dan tampak terburu-buru. Sikap Anda adalah...',
                'option_a' => 'Menjalankan instruksi seadanya sesuai pemahaman Anda saja.',
                'option_b' => 'Menanyakan kembali poin-poin yang kurang jelas secara sopan sebelum mulai bekerja.',
                'option_c' => 'Meminta rekan kerja lain menjelaskan maksud atasan tersebut.',
                'option_d' => 'Diam saja dan menunggu sampai atasan memberikan penjelasan ulang.',
                'option_e' => 'Mengkritik atasan karena tidak memberikan petunjuk yang jelas.',
                'score_a' => 2,
                'score_b' => 5,
                'score_c' => 4,
                'score_d' => 3,
                'score_e' => 1,
                'discussion_text' => 'Opsi B bernilai 5 karena mencerminkan komunikasi aktif, profesionalisme, serta kehati-hatian agar tidak terjadi kesalahan kerja.'
            ],
        ];

        foreach ($questionsData as $q) {
            Question::create($q);
        }

        // 4. Buat Sesi Ujian Aktif untuk User Utama (Agar bisa langsung diuji di UI)
        $userExam = UserExam::create([
            'user_id' => $mainUser->id,
            'exam_id' => $exam->id,
            'started_at' => now(),
            'status' => 'ON_PROGRESS',
        ]);

        // 5. Buat 5 User Dummy Lain untuk Mengisi Leaderboard (Peringkat)
        $dummyUsers = [
            ['name' => 'Budi Santoso', 'twk' => 85, 'tiu' => 110, 'tkp' => 175],
            ['name' => 'Siti Rahma', 'twk' => 90, 'tiu' => 125, 'tkp' => 180],
            ['name' => 'Andi Wijaya', 'twk' => 70, 'tiu' => 95, 'tkp' => 168],
            ['name' => 'Dewi Lestari', 'twk' => 60, 'tiu' => 75, 'tkp' => 150], // Tidak Lulus
            ['name' => 'Eko Prasetyo', 'twk' => 100, 'tiu' => 130, 'tkp' => 190], // Juara 1
        ];

        foreach ($dummyUsers as $data) {
            $u = User::create([
                'name' => $data['name'],
                'email' => strtolower(str_replace(' ', '', $data['name'])) . '@example.com',
                'password' => Hash::make('password123'),
            ]);

            $total = $data['twk'] + $data['tiu'] + $data['tkp'];
            $isPassed = ($data['twk'] >= 65 && $data['tiu'] >= 80 && $data['tkp'] >= 166);

            UserExam::create([
                'user_id' => $u->id,
                'exam_id' => $exam->id,
                'started_at' => now()->subHours(2),
                'finished_at' => now()->subHours(1),
                'score_twk' => $data['twk'],
                'score_tiu' => $data['tiu'],
                'score_tkp' => $data['tkp'],
                'total_score' => $total,
                'is_passed' => $isPassed,
                'status' => 'FINISHED',
            ]);
        }
    }
}
