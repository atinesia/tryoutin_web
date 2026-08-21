<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\Question;
use App\Models\UserExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ExamController extends Controller
{
    // public function show($userExamId)
    // {
    //     $userExam = UserExam::where('id', $userExamId)
    //         ->where('user_id', Auth::id())
    //         ->where('status', 'ON_PROGRESS')
    //         ->firstOrFail();

    //     $exam = Exam::findOrFail($userExam->exam_id);
    //     $questions = Question::where('exam_id', $exam->id)->get();

    //     // 1. Kalkulasi Sisa Waktu berdasarkan Jam Server Nyata
    //     // Karena started_at sudah di-cast ke Carbon, diffInSeconds langsung akurat
    //     $elapsedSeconds = now()->diffInSeconds($userExam->started_at);
    //     $totalSeconds = $exam->duration_minutes * 60;
    //     $remainingSeconds = max(0, $totalSeconds - $elapsedSeconds);

    //     if ($remainingSeconds <= 0) {
    //         return $this->finish($userExamId);
    //     }

    //     // 2. Ambil Jawaban Tersimpan & Konversi ke Map/Key-Value
    //     $answersFromDb = ExamAnswer::where('user_exam_id', $userExam->id)->get();
    //     $existingAnswers = [];

    //     foreach ($answersFromDb as $ans) {
    //         $existingAnswers[(string)$ans->question_id] = [
    //             'answer' => $ans->selected_option,
    //             'doubtful' => (bool) $ans->is_doubtful,
    //         ];
    //     }

    //     return view('exam.show', compact('userExam', 'exam', 'questions', 'remainingSeconds', 'existingAnswers'));
    // }
    /**
     * Halaman Katalog Pilih Paket Tryout
     */
    public function index()
    {
        // Ambil semua paket ujian yang aktif dari database
        $exams = Exam::all();

        // Ambil daftar ID ujian yang sudah dibeli/dikerjakan oleh user yang sedang login
        $userExamIds = [];
        if (Auth::check()) {
            $userExamIds = UserExam::where('user_id', Auth::id())
                ->pluck('exam_id')
                ->toArray();
        }

        return view('exam.index', compact('exams', 'userExamIds'));
    }

    public function show($userExamId)
    {
        //dd($userExamId);
        $userExam = UserExam::where('exam_id', $userExamId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        // Jika ujian sudah selesai, arahkan kembali ke halaman hasil, bukan 404
        if ($userExam->status === 'FINISHED') {
            return redirect()->route('exam.result', $userExam->id);
        }

        $exam = Exam::findOrFail($userExam->exam_id);
        $questions = Question::where('exam_id', $exam->id)->get();

        $startTimeUnix = \Carbon\Carbon::parse($userExam->started_at)->timestamp;
        $nowUnix = now()->timestamp;
        $elapsedSeconds = max(0, $nowUnix - $startTimeUnix);
        $totalSeconds = $exam->duration_minutes * 60;
        $remainingSeconds = max(0, $totalSeconds - $elapsedSeconds);

        if ($remainingSeconds <= 0) {
            return $this->finish($userExamId);
        }

        $answersFromDb = ExamAnswer::where('user_exam_id', $userExam->id)->get();
        $existingAnswers = [];

        foreach ($answersFromDb as $ans) {
            $existingAnswers[(string)$ans->question_id] = [
                'answer' => $ans->selected_option,
                'doubtful' => (bool) $ans->is_doubtful,
            ];
        }

        return view('exam.show', compact('userExam', 'exam', 'questions', 'remainingSeconds', 'existingAnswers'));
    }
    /**
     * 2. API Auto-Save Jawaban via AJAX (Fetch API)
     */
    public function saveAnswer(Request $request)
    {
        $request->validate([
            'user_exam_id' => 'required|exists:user_exams,id',
            'question_id' => 'required|exists:questions,id',
            'selected_option' => 'required|in:A,B,C,D,E',
            'is_doubtful' => 'boolean',
        ]);

        $userExam = UserExam::where('id', $request->user_exam_id)
            ->where('user_id', Auth::id())
            ->where('status', 'ON_PROGRESS')
            ->first();

        if (!$userExam) {
            return response()->json(['message' => 'Sesi ujian telah berakhir.'], 403);
        }

        $question = Question::findOrFail($request->question_id);

        // Ambil skor opsi A-E dari DB
        $optionField = 'score_' . strtolower($request->selected_option);
        $scoreObtained = (int) ($question->$optionField ?? 0);

        // Simpan/Update Jawaban
        $answer = ExamAnswer::updateOrCreate(
            [
                'user_exam_id' => $userExam->id,
                'question_id'  => $question->id,
            ],
            [
                'selected_option' => $request->selected_option,
                'score_obtained'  => $scoreObtained,
                'is_doubtful'     => $request->is_doubtful ?? false,
            ]
        );

        return response()->json(['status' => 'success', 'score' => $scoreObtained]);
    }

    /**
     * Selesaikan Ujian, Hitung Skor, Panggil Groq AI 1x, Lalu Simpan ke DB
     */
    public function finish($userExamId)
    {
        $userExam = UserExam::where('id', $userExamId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // 1. Ambil semua jawaban yang sudah disimpan oleh peserta
        $answers = ExamAnswer::where('user_exam_id', $userExam->id)->get();

        $scoreTwk = 0;
        $scoreTiu = 0;
        $scoreTkp = 0;

        foreach ($answers as $ans) {
            $question = Question::find($ans->question_id);
            if ($question) {
                if ($question->category === 'TWK') {
                    $scoreTwk += (int) $ans->score_obtained;
                } elseif ($question->category === 'TIU') {
                    $scoreTiu += (int) $ans->score_obtained;
                } elseif ($question->category === 'TKP') {
                    $scoreTkp += (int) $ans->score_obtained;
                }
            }
        }

        $totalScore = $scoreTwk + $scoreTiu + $scoreTkp;
        $exam = Exam::findOrFail($userExam->exam_id);

        $isPassed = (
            $scoreTwk >= $exam->passing_grade_twk &&
            $scoreTiu >= $exam->passing_grade_tiu &&
            $scoreTkp >= $exam->passing_grade_tkp
        );

        // 2. Evaluasi Kekuatan & Kelemahan
        $strengths = [];
        $weaknesses = [];

        if ($scoreTwk >= $exam->passing_grade_twk) {
            $strengths[] = "Wawasan Kebangsaan (TWK)";
        } else {
            $weaknesses[] = "Wawasan Kebangsaan (TWK)";
        }

        if ($scoreTiu >= $exam->passing_grade_tiu) {
            $strengths[] = "Logika & Numerik (TIU)";
        } else {
            $weaknesses[] = "Logika & Numerik (TIU)";
        }

        if ($scoreTkp >= $exam->passing_grade_tkp) {
            $strengths[] = "Karakteristik Pribadi (TKP)";
        } else {
            $weaknesses[] = "Karakteristik Pribadi (TKP)";
        }

        // 3. Panggil Groq AI HANYA jika kolom ai_analysis masih kosong (Mencegah pemanggilan ulang jika finish diakses kembali)
        $aiAnalysis = $userExam->ai_analysis;
        if (empty($aiAnalysis)) {
            $aiAnalysis = $this->generateAiAnalysis(
                $userExam->user->name,
                $scoreTwk,
                $scoreTiu,
                $scoreTkp,
                $totalScore,
                $strengths,
                $weaknesses
            );
        }

        // 4. Update dan simpan permanen ke Database
        $userExam->score_twk   = $scoreTwk;
        $userExam->score_tiu   = $scoreTiu;
        $userExam->score_tkp   = $scoreTkp;
        $userExam->total_score = $totalScore;
        $userExam->is_passed   = $isPassed;
        $userExam->ai_analysis = $aiAnalysis;
        $userExam->status      = 'FINISHED';
        $userExam->finished_at = $userExam->finished_at ?? now();
        $userExam->save();

        return redirect()->route('exam.result', $userExam->id);
    }

    /**
     * Halaman Hasil (Hanya membaca data tersimpan dari DB - 0 Token Groq)
     */
    public function result($userExamId)
    {
        $userExam = UserExam::with('exam')->where('id', $userExamId)->firstOrFail();

        $answers = ExamAnswer::with('question')
            ->where('user_exam_id', $userExam->id)
            ->get()
            ->keyBy('question_id');

        $questions = Question::where('exam_id', $userExam->exam_id)->get();

        $stats = [
            'TWK' => ['correct' => 0, 'wrong' => 0, 'empty' => 0, 'score' => $userExam->score_twk],
            'TIU' => ['correct' => 0, 'wrong' => 0, 'empty' => 0, 'score' => $userExam->score_tiu],
            'TKP' => ['correct' => 0, 'wrong' => 0, 'empty' => 0, 'score' => $userExam->score_tkp],
        ];

        foreach ($questions as $q) {
            $userAns = $answers[$q->id] ?? null;
            $category = $q->category;

            if (!$userAns || !$userAns->selected_option) {
                $stats[$category]['empty']++;
            } else {
                if ($userAns->score_obtained > 0) {
                    $stats[$category]['correct']++;
                } else {
                    $stats[$category]['wrong']++;
                }
            }
        }

        $strengths = [];
        $weaknesses = [];

        if ($userExam->score_twk >= $userExam->exam->passing_grade_twk) {
            $strengths[] = "Wawasan Kebangsaan (TWK)";
        } else {
            $weaknesses[] = "Wawasan Kebangsaan (TWK)";
        }

        if ($userExam->score_tiu >= $userExam->exam->passing_grade_tiu) {
            $strengths[] = "Logika & Numerik (TIU)";
        } else {
            $weaknesses[] = "Logika & Numerik (TIU)";
        }

        if ($userExam->score_tkp >= $userExam->exam->passing_grade_tkp) {
            $strengths[] = "Karakteristik Pribadi (TKP)";
        } else {
            $weaknesses[] = "Karakteristik Pribadi (TKP)";
        }

        // Ambil hasil AI langsung dari DB (Tanpa request API tambahan)
        $aiAnalysis = $userExam->ai_analysis ?? "Saran AI: Fokus tingkatkan latihan pada materi yang belum mencapai passing grade.";

        $leaderboard = UserExam::with('user')
            ->where('exam_id', $userExam->exam_id)
            ->where('status', 'FINISHED')
            ->orderBy('total_score', 'desc')
            ->orderBy('finished_at', 'asc')
            ->take(10)
            ->get();

        $userRank = UserExam::where('exam_id', $userExam->exam_id)
            ->where('status', 'FINISHED')
            ->where('total_score', '>', $userExam->total_score)
            ->count() + 1;

        return view('exam.result', compact(
            'userExam',
            'questions',
            'answers',
            'stats',
            'strengths',
            'weaknesses',
            'aiAnalysis',
            'leaderboard',
            'userRank'
        ));
    }

    /**
     * Pemanggilan Groq API (Hanya 1x saat finish ujian)
     */
    private function generateAiAnalysis($userName, $scoreTwk, $scoreTiu, $scoreTkp, $totalScore, $strengths, $weaknesses)
    {
        $apiKey = env('GROQ_API_KEY');
        if (!$apiKey) {
            return "Saran AI: Fokus tingkatkan latihan pada materi yang belum mencapai passing grade secara konsisten setiap hari.";
        }

        $prompt = "Sebagai pakar mentor CPNS, berikan evaluasi singkat dan motivasi (maksimal 3 paragraf) untuk peserta bernama {$userName}. "
            . "Skor SKD: TWK={$scoreTwk}, TIU={$scoreTiu}, TKP={$scoreTkp}. Total Skor={$totalScore}. "
            . "Kekuatan: " . implode(', ', $strengths) . ". Kelemahan: " . implode(', ', $weaknesses) . ". "
            . "Berikan trik konkret untuk memperbaiki kelemahannya.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'openai/gpt-oss-120b',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Anda adalah mentor bimbingan belajar CPNS profesional yang memberikan saran konstruktif, motivatif, dan lugas.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 500
            ]);

            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'] ?? 'Tetap semangat belajar!';
            }
        } catch (\Exception $e) {
            // Fallback jika API terkendala
        }

        return "Saran AI: Pertahankan area kekuatan Anda dan alokasikan 70% waktu belajar harian untuk mengulas materi pada area kelemahan.";
    }
}
