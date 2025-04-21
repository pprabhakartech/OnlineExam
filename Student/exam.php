<?php
// Check if the exam is active
$statusFile = 'exam_status.txt';
if (file_exists($statusFile)) {
    $status = trim(file_get_contents($statusFile));
    if ($status !== 'active') {
        echo "<div id='modal'>
                <div id='modal-content'>
                    <p>The exam is currently inactive.</p>
                    <button id='close-modal'>OK</button>
                </div>
              </div>
              <script>
                document.getElementById('close-modal').addEventListener('click', function() {
                    window.location.href = 'index.php';
                });
              </script>
              <style>
                #modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 1000;
                }
                #modal-content {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }
                #modal-content p {
                    font-size: 18px;
                    margin-bottom: 20px;
                }
                #close-modal {
                    padding: 10px 20px;
                    font-size: 16px;
                    background-color: #007bff;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
                #close-modal:hover {
                    background-color: #0056b3;
                }
              </style>";
        exit();
    }
} else {
    echo "Exam status not found. Please contact the administrator.";
    exit();
}

//-------------------------------------------------------------

if (!isset($_GET['name']) || !isset($_GET['course'])) {
    header('Location: index.html');
    exit();
}

$name = htmlspecialchars($_GET['name']);
$course = htmlspecialchars($_GET['course']);
$questions = file('questions.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Read t_min from t_min.txt
$filePath = 't_min.txt';
if (file_exists($filePath)) {
    $t_min = intval(file_get_contents($filePath));
} else {
    // Default to 1 minute if t_min.txt is not found
    $t_min = 1;
}

$exam_data = [];
for ($i = 0; $i < count($questions); $i += 6) {
    $exam_data[] = [
        'question' => $questions[$i],
        'options' => array_slice($questions, $i + 1, 4),
        'answer' => $questions[$i + 5]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam</title>
    <link rel="stylesheet" href="styles.css">
    <style type="text/css">

        /* Add this new style for the fullscreen prompt */
        #fullscreen-prompt {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.9);
            display: none; /* Changed from flex to none - will be shown when needed */
            justify-content: center;
            align-items: center;
            z-index: 9999;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        
        #fullscreen-content {
            max-width: 500px;
            padding: 20px;
        }
        
        #start-exam-btn {
            padding: 12px 24px;
            font-size: 18px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        
        #start-exam-btn:hover {
            background-color: #2980b9;
        }

        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        #exam-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        /*
        
        h1, h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        */
        #exam-container h1 {
        margin: 5px 0 5px 0;
        padding: 0;
        color: #2c3e50;
        font-size: 28px;
        }
        
        #exam-container h2 {
            margin: 0 0 5px 0;
            padding: 0;
            color: #3498db;
            font-size: 22px;
            font-weight: bold;
        }
            
        #timer {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #e74c3c;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        
        .question-panel {
            border: 2px solid #3498db;
            border-radius: 8px;
            padding: 20px;
            background-color: #f8fafc;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            white-space: pre-wrap;
            font-family: 'Courier New', monospace;
            line-height: 1.8;
            font-size: 18px;
            font-weight: bold;
        }
        
        #options-container {
            margin-top: 20px;
        }
        
        #options-container label {
            display: block;
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 6px;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            border-left: 4px solid #3498db;
            line-height: 1.6;
            font-size: 15px;
        }
        
        #options-container label:hover {
            background-color: #e9f7fe;
            transform: translateX(5px);
        }
        
        #options-container input[type="radio"] {
            margin-right: 12px;
            transform: scale(1.3);
            vertical-align: middle;
        }
        
        #counters {
            display: flex;
            justify-content: space-between;
            margin: 25px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        #counters p {
            margin: 0;
            font-weight: bold;
            color: #2c3e50;
        }
        
        #next-button, #submit-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 10px;
        }
        
        #next-button:hover, #submit-button:hover {
            background-color: #2980b9;
        }
        
        #footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            font-size: 12px;
            text-align: center;
            padding: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ecf0f1;
            background-color: #f8f9fa;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
        }
        
        #footer p {
            margin: 0 15px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #exam-container {
                padding: 15px;
            }
            
            #counters {
                flex-direction: column;
                gap: 10px;
            }
            
            .question-panel {
                padding: 15px;
            }
        }
    </style>
    <script>
        const examData = <?php echo json_encode($exam_data); ?>;
        const totalQuestions = examData.length;
        let currentQuestionIndex = 0;
        let score = 0;

        function startTimer(duration, display) {
            let timer = duration, minutes, seconds;
            const countdown = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(countdown);
                    submitExam();
                }
            }, 1000);
        }

        function displayQuestion() {
            const questionContainer = document.getElementById('question-container');
            const optionsContainer = document.getElementById('options-container');

            if (currentQuestionIndex < totalQuestions) {
                const currentQuestion = examData[currentQuestionIndex];
                // Preserve line breaks and multiple spaces in questions
                const formattedQuestion = currentQuestion.question
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/\n/g, '<br>')
                    .replace(/  /g, ' &nbsp;');
                
                questionContainer.innerHTML = `<div class="question-panel">${formattedQuestion}</div>`;

                optionsContainer.innerHTML = '';

                currentQuestion.options.forEach((option, index) => {
                    const label = document.createElement('label');
                    // Preserve formatting in options
                    const formattedOption = option
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;')
                        .replace(/\n/g, '<br>')
                        .replace(/  /g, ' &nbsp;');
                    
                    label.innerHTML = `
                        <input type="radio" name="option" value="${option.replace(/"/g, '&quot;')}"> ${formattedOption}
                    `;
                    optionsContainer.appendChild(label);
                });

                updateCounters();
            } else {
                document.getElementById('question-container').style.display = 'none';
                document.getElementById('options-container').style.display = 'none';
                document.getElementById('submit-button').style.display = 'block';
                document.getElementById('next-button').style.display = 'none';
                updateCounters();
            }
        }

        function updateCounters() {
            document.getElementById('total-questions').textContent = totalQuestions;
            document.getElementById('attempted-questions').textContent = currentQuestionIndex;
            document.getElementById('remaining-questions').textContent = Math.max(totalQuestions - currentQuestionIndex, 0);
        }

        function nextQuestion() {
            const selectedOption = document.querySelector('input[name="option"]:checked');
            if (selectedOption) {
                const selectedAnswer = selectedOption.value;
                const currentQuestion = examData[currentQuestionIndex]; // Get current question data
                
                // Check if the selected answer matches the correct answer
                if (selectedAnswer.trim().toLowerCase() === currentQuestion.answer.trim().toLowerCase()) {
                        score++;
                    }
                                    
                currentQuestionIndex++; // Move to next question only after checking
                displayQuestion();
            } else {
                alert('Please select an option before proceeding');
            }
        }

        function submitExam() {
            document.getElementById('score').value = score;
            document.getElementById('exam-form').submit();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const t_min = <?php echo $t_min; ?>;
            const timeinMinutes = 60 * t_min;
            const display = document.querySelector('#time');
            startTimer(timeinMinutes, display);

            displayQuestion();

            document.getElementById('next-button').addEventListener('click', nextQuestion);
            document.getElementById('submit-button').addEventListener('click', submitExam);
            
            // Auto-submit when time reaches 00:00
            setTimeout(() => {
                if (document.querySelector('#time').textContent === '00:00') {
                    submitExam();
                }
            }, (timeinMinutes * 1000) + 1000);
        });
    </script>
</head>
<body>
<!-- Replace your current fullscreen prompt with this: -->
<div id="fullscreen-prompt">
        <div id="fullscreen-content">
            <h2>📝 Exam Instructions</h2>
            <p>This exam must be taken in <strong>fullscreen mode</strong>.</p>
            <p>Please return to fullscreen mode to continue your exam.</p>
            <button id="start-exam-btn">
                ▶ Continue Exam in Fullscreen Mode
            </button>
        </div>
    </div>

    <div id="exam-container">
        <h1>Exam Name: <?php echo $course; ?></h1>
        <h2>Student Name: <?php echo $name; ?></h2>
        <div id="timer">Time Remaining: <span id="time"></span></div>
        
        <div id="question-container"></div>
        
        <div id="options-container"></div>
        
        <div id="counters">
            <p>Total Questions: <span id="total-questions">0</span></p>
            <p>Attempted Questions: <span id="attempted-questions">0</span></p>
            <p>Remaining Questions: <span id="remaining-questions">0</span></p>
        </div>
        
        <form id="exam-form" action="submit.php" method="POST">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="course" value="<?php echo $course; ?>">
            <input type="hidden" name="score" id="score" value="0">
            <button type="button" id="next-button">Next Question</button>
            <button type="button" id="submit-button" style="display: none;">Submit Exam</button>
        </form>
    </div>
    
    <div id="footer">
        <p style="float: left;">Copyright © 2020-21 Vidya Institute of Professional Studies. All rights reserved.</p>
        <p style="float: right;">Created by Prabhakar Pathak</p>
    </div>

    <script type="text/javascript">

// ===== FULLSCREEN FUNCTIONS ===== //
 document.addEventListener('DOMContentLoaded', () => {
            const t_min = <?php echo $t_min; ?>;
            const timeinMinutes = 60 * t_min;
            const display = document.querySelector('#time');
            
            // Check if we're already in fullscreen (in case of page refresh)
            if (!isFullscreen()) {
                showFullscreenPrompt();
            } else {
                // If already in fullscreen, start the exam immediately
                startTimer(timeinMinutes, display);
                displayQuestion();
            }

            document.getElementById('next-button').addEventListener('click', nextQuestion);
            document.getElementById('submit-button').addEventListener('click', submitExam);
            
            // Auto-submit when time reaches 00:00
            setTimeout(() => {
                if (document.querySelector('#time').textContent === '00:00') {
                    submitExam();
                }
            }, (timeinMinutes * 1000) + 1000);
        });
        
        // ===== FULLSCREEN FUNCTIONS ===== //
        function isFullscreen() {
            return document.fullscreenElement || 
                   document.webkitFullscreenElement || 
                   document.mozFullScreenElement || 
                   document.msFullscreenElement;
        }
        
        function enterFullscreen() {
            const element = document.documentElement;
            
            if (element.requestFullscreen) {
                return element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
                return element.mozRequestFullScreen();
            } else if (element.webkitRequestFullscreen) {
                return element.webkitRequestFullscreen();
            } else if (element.msRequestFullscreen) {
                return element.msRequestFullscreen();
            }
            return Promise.reject(new Error("Fullscreen not supported"));
        }
        
        function showFullscreenPrompt() {
            const prompt = document.getElementById('fullscreen-prompt');
            prompt.style.display = 'flex';
            
            // Hide the exam container while in prompt
            document.getElementById('exam-container').style.display = 'none';
        }
        
        function hideFullscreenPrompt() {
            const prompt = document.getElementById('fullscreen-prompt');
            prompt.style.display = 'none';
            
            // Show the exam container
            document.getElementById('exam-container').style.display = 'block';
        }
        
        // ===== START EXAM ON BUTTON CLICK ===== //
        document.getElementById("start-exam-btn").addEventListener("click", async function() {
            try {
                await enterFullscreen();
                hideFullscreenPrompt();
                
                // Start the exam timer & display first question
                const t_min = <?php echo $t_min; ?>;
                const timeInSeconds = 60 * t_min;
                const display = document.getElementById("time");
                startTimer(timeInSeconds, display);
                displayQuestion();
                
            } catch (error) {
                alert("Failed to enter fullscreen. Please allow fullscreen mode and try again.\nError: " + error.message);
            }
        });
        
        // ===== DETECT FULLSCREEN CHANGES ===== //
        document.addEventListener("fullscreenchange", handleFullscreenChange);
        document.addEventListener("webkitfullscreenchange", handleFullscreenChange);
        document.addEventListener("mozfullscreenchange", handleFullscreenChange);
        document.addEventListener("msfullscreenchange", handleFullscreenChange);
        
        function handleFullscreenChange() {
            if (!isFullscreen()) {
                // User exited fullscreen - show prompt and pause exam
                showFullscreenPrompt();
                
                // You might want to pause the timer here if needed
                // For simplicity, we're not pausing the timer in this example
            } else {
                // User entered fullscreen - hide prompt and continue exam
                hideFullscreenPrompt();
            }
        }
    </script>

</body>
</html>