<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class AdminExamController extends Controller
{
    public function create()
    {
        return view('admin.exams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string',
            'price'               => 'required|numeric|min:0',
            'duration_minutes'    => 'required|integer|min:1',
            'passing_grade_twk'   => 'required|integer|min:0',
            'passing_grade_tiu'   => 'required|integer|min:0',
            'passing_grade_tkp'   => 'required|integer|min:0',
            'count_twk'           => 'required|integer|min:0',
            'count_tiu'           => 'required|integer|min:0',
            'count_tkp'           => 'required|integer|min:0',
            'topic_context'       => 'nullable|string',
        ]);

        $totalQuestions = $request->count_twk + $request->count_tiu + $request->count_tkp;

        if ($totalQuestions === 0) {
            return back()->withErrors(['count_twk' => 'Total soal yang digenerate minimal 1 soal.'])->withInput();
        }

        DB::beginTransaction();
        try {
            // 1. Simpan Paket Ujian ke Database
            $exam = Exam::create([
                'title'              => $request->title,
                'description'        => $request->description,
                'price'              => $request->price,
                'duration_minutes'   => $request->duration_minutes,
                'passing_grade_twk'  => $request->passing_grade_twk,
                'passing_grade_tiu'  => $request->passing_grade_tiu,
                'passing_grade_tkp'  => $request->passing_grade_tkp,
                'is_published'          => true,
            ]);

            // 2. Generate Soal per Kategori menggunakan Groq AI
            $categories = [
                'TWK' => $request->count_twk,
                'TIU' => $request->count_tiu,
                'TKP' => $request->count_tkp,
            ];

            foreach ($categories as $category => $count) {
                if ($count > 0) {
                    $generatedQuestions = $this->generateQuestionsViaGroq(
                        $category,
                        $count,
                        $request->topic_context
                    );

                    foreach ($generatedQuestions as $q) {
                        Question::create([
                            'exam_id'         => $exam->id,
                            'category'        => $category,
                            'question_text'   => $q['question_text'],
                            'option_a'        => $q['option_a'],
                            'option_b'        => $q['option_b'],
                            'option_c'        => $q['option_c'],
                            'option_d'        => $q['option_d'],
                            'option_e'        => $q['option_e'],
                            'score_a'         => $q['score_a'],
                            'score_b'         => $q['score_b'],
                            'score_c'         => $q['score_c'],
                            'score_d'         => $q['score_d'],
                            'score_e'         => $q['score_e'],
                            'discussion_text' => $q['discussion_text'],
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('exam.index')->with('success', 'Paket tryout dan soal berhasil dibuat oleh AI!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat soal AI: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Engine Pembuatan Soal Presisi (Anti-Halusinasi) via Groq Cloud API
     */
    private function generateQuestionsViaGroq($category, $count, $topicContext = null)
    {
        $apiKey = config('services.groq.api_key') ?? env('GROQ_API_KEY');
        if (!$apiKey) {
            throw new \Exception('GROQ_API_KEY belum dikonfigurasi pada file .env');
        }

        $url = 'https://api.groq.com/openai/v1/chat/completions';

        $promptRules = "";
        if ($category === 'TWK') {
            $promptRules = "Soal TWK (Tes Wawasan Kebangsaan) berfokus pada Pancasila, UUD 1945, NKRI, Bhinneka Tunggal Ika, Nasionalisme, Integritas, Bela Negara, dan Bahasa Indonesia. Hanya ada 1 jawaban benar (opsi benar bernilai 5, opsi salah bernilai 0).";
        } elseif ($category === 'TIU') {
            $promptRules = "Soal TIU (Tes Inteligensia Umum) berfokus pada kemampuan verbal, numerik (berhitung/deret), dan figural/logika formal. Matematika & fakta harus 100% tepat dan logis. Hanya ada 1 jawaban benar (opsi benar bernilai 5, opsi salah bernilai 0).";
        } elseif ($category === 'TKP') {
            $promptRules = "Soal TKP (Tes Karakteristik Pribadi) berupa studi kasus perilaku kerja ASN (Pelayanan Publik, Jaring Kerja, Sosial Budaya, TIK, Profesionalisme, Radikalisme). SETIAP OPSI (A, B, C, D, E) HARUS MEMILIKI BOBOT SKOR BERBEDA (skala 1 sampai 5). Opsi paling profesional diberi skor 5, berikutnya 4, 3, 2, dan paling tidak tepat diberi skor 1.";
        }

        $systemPrompt = "Anda adalah pembuat soal profesional resmi ujian SKD CPNS Indonesia dengan standar BKN dan selalu update. Tugas Anda adalah menghasilkan soal yang valid, akurat, bebas dari kesalahan matematis atau sejarah, dan menyertakan pembahasan lugas yang mudah dipahami dan tidak halusinasi.\n\n"
            . "Output WAJIB berupa JSON Array murni tanpa format markdown seperti ```json. Format JSON untuk tiap elemen adalah:\n"
            . "[\n"
            . "  {\n"
            . "    \"question_text\": \"Teks pertanyaan...\",\n"
            . "    \"option_a\": \"Pilihan A\",\n"
            . "    \"option_b\": \"Pilihan B\",\n"
            . "    \"option_c\": \"Pilihan C\",\n"
            . "    \"option_d\": \"Pilihan D\",\n"
            . "    \"option_e\": \"Pilihan E\",\n"
            . "    \"score_a\": 0,\n"
            . "    \"score_b\": 5,\n"
            . "    \"score_c\": 0,\n"
            . "    \"score_d\": 0,\n"
            . "    \"score_e\": 0,\n"
            . "    \"discussion_text\": \"Penjelasan singkat dan logis...\"\n"
            . "  }\n"
            . "]\n";

        $userPrompt = "Buatkan tepat {$count} soal berkualitas untuk kategori {$category}.\n"
            . "Aturan Khusus: {$promptRules}\n"
            . ($topicContext ? "Konteks/Topik Tambahan: {$topicContext}\n" : "")
            . "PENTING: Jangan membuat fakta palsu. Berikan pembahasan ringkas, jelas, dan mudah dipahami.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . trim($apiKey),
            'Content-Type'  => 'application/json',
        ])->timeout(120)->post($url, [
            'model' => 'openai/gpt-oss-120b',
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ],
            'temperature' => 0.3,
        ]);

        if (!$response->successful()) {
            throw new \Exception('Respon dari Groq AI gagal: ' . $response->body());
        }

        $content = $response->json()['choices'][0]['message']['content'] ?? '';

        // Cleanup formatting jika AI menyertakan tanda markdown ```json
        $content = preg_replace('/^```json\s*/i', '', $content);
        $content = preg_replace('/^```\s*/i', '', $content);
        $content = preg_replace('/\s*```$/i', '', $content);
        $content = trim($content);

        $parsed = json_decode($content, true);

        if (!is_array($parsed)) {
            throw new \Exception("AI menghasilkan format yang tidak valid. Coba lagi.");
        }

        return $parsed;
    }
}
