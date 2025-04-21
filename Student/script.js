document.addEventListener('DOMContentLoaded', () => {
    // Fetch t_min value from t_min.txt
    fetch('t_min.txt')
        .then(response => response.text())
        .then(t_min => {
            const timeLimit = parseInt(t_min) * 60; // Convert minutes to seconds
            let timeRemaining = timeLimit;
            const timerDisplay = document.getElementById('time');

            const interval = setInterval(() => {
                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;
                timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                if (timeRemaining <= 0) {
                    clearInterval(interval);
                    submitExam();
                } else {
                    timeRemaining--;
                }
            }, 1000);

            // Exam functionality
            const examData = window.examData;
            const totalQuestions = examData.length;
            let currentQuestionIndex = 0;
            let score = 0;

            const questionContainer = document.getElementById('question-container');
            const optionsContainer = document.getElementById('options-container');
            const totalQuestionsElem = document.getElementById('total-questions');
            const attemptedQuestionsElem = document.getElementById('attempted-questions');
            const remainingQuestionsElem = document.getElementById('remaining-questions');

            function displayQuestion() {
                if (currentQuestionIndex < totalQuestions) {
                    const currentQuestion = examData[currentQuestionIndex];
                    questionContainer.textContent = currentQuestion.question;
                    optionsContainer.innerHTML = '';

                    currentQuestion.options.forEach(option => {
                        const label = document.createElement('label');
                        label.innerHTML = `<input type="radio" name="option" value="${option}"> ${option}`;
                        optionsContainer.appendChild(label);
                        optionsContainer.appendChild(document.createElement('br'));
                    });

                    updateCounters();
                } else {
                    document.getElementById('submit-button').style.display = 'block';
                    document.getElementById('next-button').style.display = 'none';
                }
            }

            function updateCounters() {
                totalQuestionsElem.textContent = totalQuestions;
                attemptedQuestionsElem.textContent = currentQuestionIndex;
                remainingQuestionsElem.textContent = totalQuestions - currentQuestionIndex;
            }

            document.getElementById('next-button').addEventListener('click', () => {
                const selectedOption = document.querySelector('input[name="option"]:checked');
                if (selectedOption) {
                    const selectedAnswer = selectedOption.value;
                    if (selectedAnswer === examData[currentQuestionIndex].answer) {
                        score++;
                    }
                    currentQuestionIndex++;
                    displayQuestion();
                } else {
                    alert('Please select an option');
                }
            });

            document.getElementById('submit-button').addEventListener('click', submitExam);

            function submitExam() {
                document.getElementById('score').value = score;
                document.getElementById('exam-form').submit();
            }

            displayQuestion();
        })
        .catch(error => console.error('Error fetching t_min:', error));
});
