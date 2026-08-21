<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CAT BKN Simulation - {{ $exam->title }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .exam-header { background-color: #1b365d; color: white; }
        .question-box { background: #ffffff; border-radius: 8px; border: 1px solid #dee2e6; min-height: 420px; }
        .btn-number { width: 45px; height: 45px; margin: 3px; font-weight: 600; border-radius: 6px; }
        .btn-answered { background-color: #198754 !important; color: white !important; border-color: #198754 !important; }
        .btn-doubtful { background-color: #ffc107 !important; color: #212529 !important; border-color: #ffc107 !important; }
        .btn-unanswered { background-color: #e9ecef; color: #495057; border-color: #ced4da; }
        .btn-active { border: 2px solid #0d6efd !important; font-weight: bold; }
        .option-label { cursor: pointer; border: 1px solid #dee2e6; border-radius: 6px; padding: 12px 16px; margin-bottom: 10px; transition: all 0.2s; display: block; }
        .option-label:hover { background-color: #f1f5f9; }
        .form-check-input:checked + .option-label { background-color: #e7f1ff; border-color: #0d6efd; font-weight: 600; }
    </style>
</head>
<body>

<!-- Header CAT -->
<header class="exam-header py-3 px-4 shadow-sm sticky-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <h5 class="m-0 fw-bold">{{ $exam->title }}</h5>
            <small class="text-light opacity-75">Peserta: {{ auth()->user()->name }}</small>
        </div>
        <div class="text-end">
            <small class="d-block text-uppercase text-light opacity-75">Sisa Waktu</small>
            <span id="timer" class="badge bg-danger fs-5 px-3 py-2">00:00:00</span>
        </div>
    </div>
</header>

<div class="container-fluid my-4">
    <div class="row">
        <!-- Kolom Soal (Kiri) -->
        <div class="col-lg-8 mb-4">
            <div class="question-box p-4 shadow-sm position-relative d-flex flex-column justify-content-between">
                <div>
                    <!-- Header Soal -->
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                        <span class="badge bg-primary fs-6">Soal No. <span id="current-question-num">1</span></span>
                        <span class="badge bg-secondary" id="question-category">TWK</span>
                    </div>

                    <!-- Teks Soal -->
                    <div class="question-content mb-4 fs-5" id="question-text">
                        Loading soal...
                    </div>

                    <!-- Options Opsi A - E -->
                    <div class="options-group" id="options-container">
                        <!-- Render via JS -->
                    </div>
                </div>

                <!-- Footer Navigasi Tombol -->
                <div class="border-top pt-3 mt-4 d-flex justify-content-between align-items-center">
                    <button class="btn btn-secondary px-4" id="btn-prev" onclick="navigateQuestion(-1)">
                        &laquo; Sebelumnya
                    </button>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input" type="checkbox" id="check-doubtful" onchange="toggleDoubtful()">
                        <label class="form-check-label fw-semibold text-warning" for="check-doubtful">Ragu-ragu</label>
                    </div>
                    <button class="btn btn-primary px-4" id="btn-next" onclick="navigateQuestion(1)">
                        Selanjutnya &raquo;
                    </button>
                </div>
            </div>
        </div>

        <!-- Kolom Nomor Soal (Kanan) -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold py-3">
                    Navigasi Soal Ujian
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-start" id="numbers-container">
                        <!-- Tombol nomor diproduksi dinamis via JS -->
                    </div>

                    <hr>
                    <!-- Petunjuk Warna Status -->
                    <div class="row text-center fs-7 g-2">
                        <div class="col-4">
                            <span class="badge btn-answered d-block py-2">Dijawab</span>
                        </div>
                        <div class="col-4">
                            <span class="badge btn-doubtful d-block py-2">Ragu-ragu</span>
                        </div>
                        <div class="col-4">
                            <span class="badge btn-unanswered d-block py-2">Belum</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-danger w-100 py-2 fw-bold" onclick="confirmFinishExam()">
                            Selesai & Selesai Ujian
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Core Engine Script (JavaScript AJAX + Timer) -->
<script>
    let currentIdx = 0;
    let questions = @json($questions); // Menerima data JSON soal dari controller Laravel
    let userAnswers = {}; // Format: { question_id: { answer: 'A', doubtful: false } }
    let remainingSeconds = {{ $remainingSeconds }};

    document.addEventListener("DOMContentLoaded", function () {
        initTimer();
        renderQuestionNumbers();
        loadQuestion(currentIdx);
    });

    // 1. Logika Countdown Timer Real-time
    function initTimer() {
        const timerElem = document.getElementById("timer");
        const interval = setInterval(() => {
            if (remainingSeconds <= 0) {
                clearInterval(interval);
                alert("Waktu pengerjaan telah habis! Sistem akan mengumpulkan jawaban Anda secara otomatis.");
                submitExam();
                return;
            }
            remainingSeconds--;
            let hours = Math.floor(remainingSeconds / 3600);
            let minutes = Math.floor((remainingSeconds % 3600) / 60);
            let seconds = remainingSeconds % 60;

            timerElem.innerText = 
                `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }, 1000);
    }

    // 2. Render Tombol Grid Nomor Soal
    function renderQuestionNumbers() {
        const container = document.getElementById("numbers-container");
        container.innerHTML = "";

        questions.forEach((q, idx) => {
            let btn = document.createElement("button");
            btn.className = "btn btn-number btn-unanswered";
            btn.id = `num-btn-${idx}`;
            btn.innerText = idx + 1;
            btn.onclick = () => { currentIdx = idx; loadQuestion(currentIdx); };
            container.appendChild(btn);
        });
    }

    // 3. Muat Soal Aktif ke Layar
    function loadQuestion(index) {
        const q = questions[index];
        document.getElementById("current-question-num").innerText = index + 1;
        document.getElementById("question-category").innerText = q.category;
        document.getElementById("question-text").innerHTML = q.question_text;

        // Render Opsi A s/d E
        const optionsContainer = document.getElementById("options-container");
        optionsContainer.innerHTML = "";
        ['a', 'b', 'c', 'd', 'e'].forEach(opt => {
            let optKey = `option_${opt}`;
            if(q[optKey]) {
                let isChecked = userAnswers[q.id]?.answer === opt.toUpperCase() ? 'checked' : '';
                optionsContainer.innerHTML += `
                    <div class="position-relative">
                        <input type="radio" class="btn-check" name="answer_option" id="opt_${opt}" value="${opt.toUpperCase()}" ${isChecked} onchange="saveAnswer('${opt.toUpperCase()}')">
                        <label class="option-label" for="opt_${opt}">
                            <strong>${opt.toUpperCase()}.</strong> ${q[optKey]}
                        </label>
                    </div>
                `;
            }
        });

        // Set Ragu-Ragu
        document.getElementById("check-doubtful").checked = !!userAnswers[q.id]?.doubtful;

        // Update Status Tombol Aktif & Prev/Next
        document.getElementById("btn-prev").disabled = (index === 0);
        document.getElementById("btn-next").innerText = (index === questions.length - 1) ? "Selesai" : "Selanjutnya »";
        
        highlightActiveNumber(index);
    }

    // 4. Navigasi Soal
    function navigateQuestion(direction) {
        if (currentIdx + direction >= 0 && currentIdx + direction < questions.length) {
            currentIdx += direction;
            loadQuestion(currentIdx);
        }
    }

    // 5. Simpan Jawaban via AJAX (Auto-Save Real-time)
    function saveAnswer(selectedOpt) {
        const qId = questions[currentIdx].id;
        const isDoubt = document.getElementById("check-doubtful").checked;

        userAnswers[qId] = { answer: selectedOpt, doubtful: isDoubt };
        updateNumberStatus(currentIdx, selectedOpt, isDoubt);

        // Kirim asynchronous request ke Laravel Backend
        fetch("/api/exam/save-answer", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                user_exam_id: {{ $userExam->id }},
                question_id: qId,
                selected_option: selectedOpt,
                is_doubtful: isDoubt
            })
        }).catch(err => console.error("Auto-save failed:", err));
    }

    function toggleDoubtful() {
        const qId = questions[currentIdx].id;
        if(userAnswers[qId]?.answer) {
            saveAnswer(userAnswers[qId].answer);
        }
    }

    // 6. Manipulasi Warna Indikator Nomor
    function updateNumberStatus(index, answer, isDoubtful) {
        const btn = document.getElementById(`num-btn-${index}`);
        btn.classList.remove("btn-answered", "btn-doubtful", "btn-unanswered");

        if (isDoubtful) {
            btn.classList.add("btn-doubtful");
        } else if (answer) {
            btn.classList.add("btn-answered");
        } else {
            btn.classList.add("btn-unanswered");
        }
    }

    function highlightActiveNumber(index) {
        document.querySelectorAll(".btn-number").forEach(b => b.classList.remove("btn-active"));
        document.getElementById(`num-btn-${index}`).classList.add("btn-active");
    }

    function confirmFinishExam() {
        if(confirm("Apakah Anda yakin ingin mengakhiri tes ini? Pastikan seluruh soal telah diperiksa.")) {
            submitExam();
        }
    }

    function submitExam() {
        window.location.href = "/exam/{{ $userExam->id }}/finish";
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/bootstrap.bundle.min.js"></script>
</body>
</html>