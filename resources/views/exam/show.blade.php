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
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .exam-header {
            background-color: #1b365d;
            color: white;
        }

        .question-box {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            min-height: 420px;
        }

        .btn-number {
            width: 45px;
            height: 45px;
            margin: 3px;
            font-weight: 600;
            border-radius: 6px;
        }

        .btn-answered {
            background-color: #198754 !important;
            color: white !important;
            border-color: #198754 !important;
        }

        .btn-doubtful {
            background-color: #ffc107 !important;
            color: #212529 !important;
            border-color: #ffc107 !important;
        }

        .btn-unanswered {
            background-color: #e9ecef;
            color: #495057;
            border-color: #ced4da;
        }

        .btn-active {
            border: 2px solid #0d6efd !important;
            font-weight: bold;
        }

        /* Style Dasar Opsi Jawaban */
        .option-label {
            cursor: pointer;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 10px;
            transition: all 0.2s;
            display: block;
            background-color: #ffffff;
        }

        .option-label:hover {
            background-color: #f1f5f9;
        }

        /* 1. Opsi Terpilih Standar (Hijau Muda) */
        .form-check-input:checked+.option-label {
            background-color: #d1e7dd !important;
            border-color: #198754 !important;
            color: #0f5132 !important;
            font-weight: 600;
        }

        /* 2. Opsi Terpilih Saat Ragu-ragu Dicentang (Kuning Muda) */
        .is-doubtful-active .form-check-input:checked+.option-label {
            background-color: #fff3cd !important;
            border-color: #ffc107 !important;
            color: #664d03 !important;
            font-weight: 600;
        }
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
                            <input class="form-check-input" type="checkbox" id="check-doubtful"
                                onchange="toggleDoubtful()">
                            <label class="form-check-label fw-semibold text-warning"
                                for="check-doubtful">Ragu-ragu</label>
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

    <!-- Core Engine Script -->
    <script>
        let examId = {{ $userExam->id }};
        let currentIdx = 0;
        let questions = @json($questions);

        let dbAnswers = @json($existingAnswers) || {};
        let localAnswers = JSON.parse(localStorage.getItem(`answers_exam_${examId}`)) || {};
        let userAnswers = Object.assign({}, dbAnswers, localAnswers);

        let remainingSeconds = parseInt({{ $remainingSeconds }});

        document.addEventListener("DOMContentLoaded", function() {
            initTimer();
            renderQuestionNumbers();
            loadQuestion(currentIdx);
        });

        function initTimer() {
            const timerElem = document.getElementById("timer");

            function updateDisplay() {
                if (remainingSeconds <= 0) {
                    localStorage.removeItem(`answers_exam_${examId}`);
                    alert("Waktu pengerjaan telah habis!");
                    submitExam();
                    return;
                }

                let hours = Math.floor(remainingSeconds / 3600);
                let minutes = Math.floor((remainingSeconds % 3600) / 60);
                let seconds = Math.floor(remainingSeconds % 60);

                timerElem.innerText =
                    `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                remainingSeconds--;
            }

            updateDisplay();
            setInterval(updateDisplay, 1000);
        }

        function renderQuestionNumbers() {
            const container = document.getElementById("numbers-container");
            container.innerHTML = "";

            questions.forEach((q, idx) => {
                let btn = document.createElement("button");
                btn.className = "btn btn-number";
                btn.id = `num-btn-${idx}`;
                btn.innerText = idx + 1;
                btn.onclick = () => {
                    currentIdx = idx;
                    loadQuestion(currentIdx);
                };
                container.appendChild(btn);

                let saved = userAnswers[q.id];
                if (saved && (saved.answer || saved.doubtful)) {
                    updateNumberStatus(idx, saved.answer, saved.doubtful);
                } else {
                    btn.classList.add("btn-unanswered");
                }
            });
        }

        function loadQuestion(index) {
            const q = questions[index];
            document.getElementById("current-question-num").innerText = index + 1;
            document.getElementById("question-category").innerText = q.category;
            document.getElementById("question-text").innerHTML = q.question_text;

            const optionsContainer = document.getElementById("options-container");
            optionsContainer.innerHTML = "";

            let saved = userAnswers[q.id];

            // Set class container ragu-ragu SEBELUM opsi di-render
            if (saved && saved.doubtful) {
                optionsContainer.classList.add("is-doubtful-active");
            } else {
                optionsContainer.classList.remove("is-doubtful-active");
            }

            ['a', 'b', 'c', 'd', 'e'].forEach(opt => {
                let optKey = `option_${opt}`;
                if (q[optKey]) {
                    let isChecked = (saved && saved.answer === opt.toUpperCase()) ? 'checked' : '';
                    optionsContainer.innerHTML += `
                <div class="position-relative">
                    <input type="radio" class="btn-check" name="answer_option" id="opt_${opt}" value="${opt.toUpperCase()}" ${isChecked} onchange="selectAndNext('${opt.toUpperCase()}')">
                    <label class="option-label" for="opt_${opt}">
                        <strong>${opt.toUpperCase()}.</strong> ${q[optKey]}
                    </label>
                </div>
            `;
                }
            });

            document.getElementById("check-doubtful").checked = !!(saved && saved.doubtful);
            document.getElementById("btn-prev").disabled = (index === 0);
            document.getElementById("btn-next").innerText = (index === questions.length - 1) ? "Selesai" : "Selanjutnya »";

            highlightActiveNumber(index);
        }

        function navigateQuestion(direction) {
            if (currentIdx + direction >= 0 && currentIdx + direction < questions.length) {
                currentIdx += direction;
                loadQuestion(currentIdx);
            }
        }

        // Fungsi Pilihan Opsi & Otomatis Lompat ke Soal Berikutnya (Auto-Next)
        function selectAndNext(selectedOpt) {
            saveAnswer(selectedOpt);

            // Berikan delay halus 300ms agar user melihat animasi highlight pilihan sebelum pindah
            setTimeout(() => {
                if (currentIdx < questions.length - 1) {
                    currentIdx++;
                    loadQuestion(currentIdx);
                }
            }, 300);
        }

        function saveAnswer(selectedOpt) {
            const qId = questions[currentIdx].id;
            const isDoubt = document.getElementById("check-doubtful").checked;

            let currentAnswer = selectedOpt || (userAnswers[qId] ? userAnswers[qId].answer : null);

            userAnswers[qId] = {
                answer: currentAnswer,
                doubtful: isDoubt
            };
            localStorage.setItem(`answers_exam_${examId}`, JSON.stringify(userAnswers));

            updateNumberStatus(currentIdx, currentAnswer, isDoubt);

            if (currentAnswer) {
                fetch("/api/exam/save-answer", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        user_exam_id: examId,
                        question_id: qId,
                        selected_option: currentAnswer,
                        is_doubtful: isDoubt
                    })
                }).catch(err => console.error("AJAX Error:", err));
            }
        }

        function toggleDoubtful() {
            const qId = questions[currentIdx].id;
            let currentAnswer = userAnswers[qId] ? userAnswers[qId].answer : null;

            const isDoubt = document.getElementById("check-doubtful").checked;
            const optionsContainer = document.getElementById("options-container");

            // Langsung perbarui class container agar warna opsi berubah instan
            if (isDoubt) {
                optionsContainer.classList.add("is-doubtful-active");
            } else {
                optionsContainer.classList.remove("is-doubtful-active");
            }

            saveAnswer(currentAnswer);
        }

        function updateNumberStatus(index, answer, isDoubtful) {
            const btn = document.getElementById(`num-btn-${index}`);
            if (!btn) return;

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
            const activeBtn = document.getElementById(`num-btn-${index}`);
            if (activeBtn) activeBtn.classList.add("btn-active");
        }

        async function confirmFinishExam() {
            if (confirm("Apakah Anda yakin ingin mengakhiri tes ini? Pastikan seluruh soal telah diperiksa.")) {
                const qId = questions[currentIdx].id;
                const isDoubt = document.getElementById("check-doubtful").checked;
                let currentAnswer = userAnswers[qId] ? userAnswers[qId].answer : null;

                if (currentAnswer) {
                    await fetch("/api/exam/save-answer", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            user_exam_id: examId,
                            question_id: qId,
                            selected_option: currentAnswer,
                            is_doubtful: isDoubt
                        })
                    });
                }

                localStorage.removeItem(`answers_exam_${examId}`);
                window.location.href = `/exam/${examId}/finish`;
            }
        }

        function submitExam() {
            window.location.href = `/exam/${examId}/finish`;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/bootstrap.bundle.min.js"></script>
</body>

</html>
