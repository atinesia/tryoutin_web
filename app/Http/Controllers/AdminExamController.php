<?php

// namespace App\Http\Controllers;

// use App\Models\Exam;
// use App\Models\Question;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\DB;

// class AdminExamController extends Controller
// {
//     public function create()
//     {
//         return view('admin.exams.create');
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'title'               => 'required|string|max:255',
//             'description'         => 'nullable|string',
//             'price'               => 'required|numeric|min:0',
//             'duration_minutes'    => 'required|integer|min:1',
//             'passing_grade_twk'   => 'required|integer|min:0',
//             'passing_grade_tiu'   => 'required|integer|min:0',
//             'passing_grade_tkp'   => 'required|integer|min:0',
//             'count_twk'           => 'required|integer|min:0',
//             'count_tiu'           => 'required|integer|min:0',
//             'count_tkp'           => 'required|integer|min:0',
//             'topic_context'       => 'nullable|string',
//         ]);

//         $totalQuestions = $request->count_twk + $request->count_tiu + $request->count_tkp;

//         if ($totalQuestions === 0) {
//             return back()->withErrors(['count_twk' => 'Total soal yang digenerate minimal 1 soal.'])->withInput();
//         }

//         DB::beginTransaction();
//         try {
//             // 1. Simpan Paket Ujian ke Database
//             $exam = Exam::create([
//                 'title'              => $request->title,
//                 'description'        => $request->description,
//                 'price'              => $request->price,
//                 'duration_minutes'   => $request->duration_minutes,
//                 'passing_grade_twk'  => $request->passing_grade_twk,
//                 'passing_grade_tiu'  => $request->passing_grade_tiu,
//                 'passing_grade_tkp'  => $request->passing_grade_tkp,
//                 'is_published'          => true,
//             ]);

//             // 2. Generate Soal per Kategori menggunakan Groq AI
//             $categories = [
//                 'TWK' => $request->count_twk,
//                 'TIU' => $request->count_tiu,
//                 'TKP' => $request->count_tkp,
//             ];

//             foreach ($categories as $category => $count) {
//                 if ($count > 0) {
//                     $generatedQuestions = $this->generateQuestionsViaGroq(
//                         $category,
//                         $count,
//                         $request->topic_context
//                     );

//                     foreach ($generatedQuestions as $q) {
//                         Question::create([
//                             'exam_id'         => $exam->id,
//                             'category'        => $category,
//                             'question_text'   => $q['question_text'],
//                             'option_a'        => $q['option_a'],
//                             'option_b'        => $q['option_b'],
//                             'option_c'        => $q['option_c'],
//                             'option_d'        => $q['option_d'],
//                             'option_e'        => $q['option_e'],
//                             'score_a'         => $q['score_a'],
//                             'score_b'         => $q['score_b'],
//                             'score_c'         => $q['score_c'],
//                             'score_d'         => $q['score_d'],
//                             'score_e'         => $q['score_e'],
//                             'discussion_text' => $q['discussion_text'],
//                         ]);
//                     }
//                 }
//             }

//             DB::commit();
//             return redirect()->route('exam.index')->with('success', 'Paket tryout dan soal berhasil dibuat oleh AI!');
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return back()->with('error', 'Gagal membuat soal AI: ' . $e->getMessage())->withInput();
//         }
//     }

//     /**
//      * Engine Pembuatan Soal Presisi (Anti-Halusinasi) via Groq Cloud API
//      */
//     private function generateQuestionsViaGroq($category, $count, $topicContext = null)
//     {
//         $apiKey = config('services.groq.api_key') ?? env('GROQ_API_KEY');
//         if (!$apiKey) {
//             throw new \Exception('GROQ_API_KEY belum dikonfigurasi pada file .env');
//         }

//         $url = 'https://api.groq.com/openai/v1/chat/completions';

//         $promptRules = "";
//         if ($category === 'TWK') {
//             $promptRules = "Soal TWK (Tes Wawasan Kebangsaan) berfokus pada Pancasila, UUD 1945, NKRI, Bhinneka Tunggal Ika, Nasionalisme, Integritas, Bela Negara, dan Bahasa Indonesia. Hanya ada 1 jawaban benar (opsi benar bernilai 5, opsi salah bernilai 0).";
//         } elseif ($category === 'TIU') {
//             $promptRules = "Soal TIU (Tes Inteligensia Umum) berfokus pada kemampuan verbal, numerik (berhitung/deret), dan figural/logika formal. Matematika & fakta harus 100% tepat dan logis. Hanya ada 1 jawaban benar (opsi benar bernilai 5, opsi salah bernilai 0).";
//         } elseif ($category === 'TKP') {
//             $promptRules = "Soal TKP (Tes Karakteristik Pribadi) berupa studi kasus perilaku kerja ASN (Pelayanan Publik, Jaring Kerja, Sosial Budaya, TIK, Profesionalisme, Radikalisme). SETIAP OPSI (A, B, C, D, E) HARUS MEMILIKI BOBOT SKOR BERBEDA (skala 1 sampai 5). Opsi paling profesional diberi skor 5, berikutnya 4, 3, 2, dan paling tidak tepat diberi skor 1.";
//         }

//         $systemPrompt = "Anda adalah pembuat soal profesional resmi ujian SKD CPNS Indonesia dengan standar BKN dan selalu update. Tugas Anda adalah menghasilkan soal yang valid, akurat, bebas dari kesalahan matematis atau sejarah, dan menyertakan pembahasan lugas yang mudah dipahami dan tidak halusinasi.\n\n"
//             . "Output WAJIB berupa JSON Array murni tanpa format markdown seperti ```json. Format JSON untuk tiap elemen adalah:\n"
//             . "[\n"
//             . "  {\n"
//             . "    \"question_text\": \"Teks pertanyaan...\",\n"
//             . "    \"option_a\": \"Pilihan A\",\n"
//             . "    \"option_b\": \"Pilihan B\",\n"
//             . "    \"option_c\": \"Pilihan C\",\n"
//             . "    \"option_d\": \"Pilihan D\",\n"
//             . "    \"option_e\": \"Pilihan E\",\n"
//             . "    \"score_a\": 0,\n"
//             . "    \"score_b\": 5,\n"
//             . "    \"score_c\": 0,\n"
//             . "    \"score_d\": 0,\n"
//             . "    \"score_e\": 0,\n"
//             . "    \"discussion_text\": \"Penjelasan singkat dan logis...\"\n"
//             . "  }\n"
//             . "]\n";

//         $userPrompt = "Buatkan tepat {$count} soal berkualitas untuk kategori {$category}.\n"
//             . "Aturan Khusus: {$promptRules}\n"
//             . ($topicContext ? "Konteks/Topik Tambahan: {$topicContext}\n" : "")
//             . "PENTING: Jangan membuat fakta palsu. Berikan pembahasan ringkas, jelas, dan mudah dipahami.";

//         $response = Http::withHeaders([
//             'Authorization' => 'Bearer ' . trim($apiKey),
//             'Content-Type'  => 'application/json',
//         ])->timeout(120)->post($url, [
//             'model' => 'openai/gpt-oss-120b',
//             'messages' => [
//                 ['role' => 'system', 'content' => $systemPrompt],
//                 ['role' => 'user', 'content' => $userPrompt],
//             ],
//             'temperature' => 0.3,
//         ]);

//         if (!$response->successful()) {
//             throw new \Exception('Respon dari Groq AI gagal: ' . $response->body());
//         }

//         $content = $response->json()['choices'][0]['message']['content'] ?? '';

//         // Cleanup formatting jika AI menyertakan tanda markdown ```json
//         $content = preg_replace('/^```json\s*/i', '', $content);
//         $content = preg_replace('/^```\s*/i', '', $content);
//         $content = preg_replace('/\s*```$/i', '', $content);
//         $content = trim($content);

//         $parsed = json_decode($content, true);

//         if (!is_array($parsed)) {
//             throw new \Exception("AI menghasilkan format yang tidak valid. Coba lagi.");
//         }

//         return $parsed;
//     }
// }
namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminExamController extends Controller
{
    /**
     * Halaman Utama Tutor: Menampilkan Daftar Paket Soal
     */
    public function index()
    {
        // Ambil seluruh paket ujian beserta jumlah soal di dalamnya
        $exams = Exam::withCount('questions')->latest()->get();

        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        return view('admin.exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category'         => 'required|in:TWK,TIU,TKP',
            'sub_category'     => 'required|string',
            'difficulty'       => 'required|in:Mudah,Sedang,HOTS',
            'question_count'   => 'required|integer|min:1|max:20',
            'duration_minutes' => 'required|integer|min:5',
            'price'            => 'required|numeric|min:0',
        ]);

        // 1. Buat Paket Ujian Sesuai Field Tabel Exams
        $exam = Exam::create([
            'title'            => $request->title,
            'duration_minutes' => $request->duration_minutes,
            'price'            => $request->price,
        ]);

        // 2. Tentukan Aturan Bobot Skor Default BKN berdasarkan Kategori
        $scoreRightDef = ($request->category === 'TKP') ? 5 : 5;
        $scoreWrongDef = ($request->category === 'TKP') ? 1 : 0;
        $scoreUnansweredDef = 0;

        // 3. System Prompt Senior Assessment Specialist BKN
        $systemPrompt = "Anda adalah seorang Senior Assessment Specialist dan Penyusun Soal Profesional untuk Ujian Seleksi Kompetensi Dasar (SKD) CPNS dan Sekolah Kedinasan BKN.
Tugas Anda adalah membuat bank soal latihan berbasis analisis indikator resmi PermenPAN-RB terbaru dan tren pola Field Report (FR) riil.

Output WAJIB berupa JSON MURNI (tanpa markdown ```json atau teks lainnya) berupa array of object dengan struktur field LENGKAP:
[
  {
    \"question_text\": \"Isi teks soal/studi kasus/narasi\",
    \"option_a\": \"Jawaban Opsi A\",
    \"option_b\": \"Jawaban Opsi B\",
    \"option_c\": \"Jawaban Opsi C\",
    \"option_d\": \"Jawaban Opsi D\",
    \"option_e\": \"Jawaban Opsi E\",
    \"correct_option\": \"A/B/C/D/E\",
    \"discussion_text\": \"Pembahasan mendalam, analisis opsi, dan trik cepat\",
    \"score_a\": 5,
    \"score_b\": 4,
    \"score_c\": 3,
    \"score_d\": 2,
    \"score_e\": 1
  }
]
Catatan Bobot Skor:
- Untuk TWK & TIU: Opsi yang benar bernilai 5, opsi lainnya bernilai 0.
- Untuk TKP: Semua opsi A-E memiliki gradasi skor dari 1 hingga 5 sesuai dengan indikator sikap profesionalisme.";

        $userPrompt = "Buatkan {$request->question_count} soal Ujian SKD dengan kriteria:
- Jenis Soal (Category): {$request->category}
- Sub-Tes: {$request->sub_category}
- Tingkat Kesulitan: {$request->difficulty}

Ketentuan Konten:
1. TWK: Narasi studi kasus/penalaran kontekstual kebangsaan.
2. TIU: Logika matematis/analitis/verbal lengkap dengan fast method pada pembahasan.
3. TKP: Gradasi opsi A-E merefleksikan indikator pelayanan publik, jejaring kerja, sosial budaya, TIK, profesionalisme, atau anti-radikalisme.
4. Pembahasan: Mendalam, sertakan kunci jawaban, alasan opsi lain kurang tepat, serta trik pengerjaan.";

        // 4. Request ke API Groq
        $apiKey = config('services.groq.api_key') ?? env('GROQ_API_KEY');
        if (!$apiKey) {
            throw new \Exception('GROQ_API_KEY belum dikonfigurasi pada file .env');
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'openai/gpt-oss-120b',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ],
            'temperature' => 0.5,
        ]);
        Log::info('Response from Groq API: ' . $response->body());
        if ($response->successful()) {
            $rawContent = $response->json()['choices'][0]['message']['content'];
            $cleanJson = preg_replace('/^```json\s*|\s*```$/i', '', trim($rawContent));
            $questionsData = json_decode($cleanJson, true);

            if (is_array($questionsData)) {
                foreach ($questionsData as $q) {
                    Question::create([
                        'exam_id'          => $exam->id,
                        'question_text'    => $q['question_text'],
                        'option_a'         => $q['option_a'],
                        'option_b'         => $q['option_b'],
                        'option_c'         => $q['option_c'],
                        'option_d'         => $q['option_d'],
                        'option_e'         => $q['option_e'],
                        'correct_option'   => strtoupper($q['correct_option'] ?? 'A'),
                        'discussion_text'  => $q['discussion_text'],
                        'category'         => $request->category,
                        'sub_category'     => $request->sub_category,
                        'difficulty'       => $request->difficulty,
                        'score_right'      => $scoreRightDef,
                        'score_wrong'      => $scoreWrongDef,
                        'score_unanswered' => $scoreUnansweredDef,
                        // Bobot Opsi Opsional (TKP)
                        'score_a'          => $q['score_a'] ?? ($q['correct_option'] == 'A' ? 5 : 0),
                        'score_b'          => $q['score_b'] ?? ($q['correct_option'] == 'B' ? 5 : 0),
                        'score_c'          => $q['score_c'] ?? ($q['correct_option'] == 'C' ? 5 : 0),
                        'score_d'          => $q['score_d'] ?? ($q['correct_option'] == 'D' ? 5 : 0),
                        'score_e'          => $q['score_e'] ?? ($q['correct_option'] == 'E' ? 5 : 0),
                    ]);
                }
            }
        }

        return redirect()->route('admin.dashboard')->with('success', "Paket {$exam->title} ({$request->category} - {$request->sub_category}) beserta skor bobot berhasil di-generate!");
    }

    // Menampilkan daftar soal dalam satu paket
    public function questionsIndex($examId)
    {
        $exam = Exam::with('questions')->findOrFail($examId);
        return view('admin.exams.questions', compact('exam'));
    }

    // Form Edit Soal
    public function questionEdit($examId, $questionId)
    {
        $exam = Exam::findOrFail($examId);
        $question = Question::findOrFail($questionId);
        return view('admin.exams.question_edit', compact('exam', 'question'));
    }

    // Update Soal
    public function questionUpdate(Request $request, $examId, $questionId)
    {
        $request->validate([
            'question_text'    => 'required|string',
            'category'         => 'required|in:TWK,TIU,TKP',
            'sub_category'     => 'nullable|string',
            'difficulty'       => 'required|in:Mudah,Sedang,HOTS',
            'option_a'         => 'required|string',
            'option_b'         => 'required|string',
            'option_c'         => 'required|string',
            'option_d'         => 'required|string',
            'option_e'         => 'required|string',
            'correct_option'   => 'required|in:A,B,C,D,E',
            'score_right'      => 'required|integer',
            'score_wrong'      => 'required|integer',
            'score_unanswered' => 'required|integer',
            'score_a'          => 'required|integer',
            'score_b'          => 'required|integer',
            'score_c'          => 'required|integer',
            'score_d'          => 'required|integer',
            'score_e'          => 'required|integer',
            'explanation'      => 'required|string',
        ]);

        $question = Question::findOrFail($questionId);
        $question->update($request->all());

        return redirect()->route('admin.exams.questions', $examId)->with('success', 'Soal lengkap berhasil diperbarui!');
    }
}
