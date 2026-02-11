<?php
session_start();

// If name not set, redirect back
if(!isset($_SESSION['name'])){
    header("Location: index.php");
    exit;
}

// Questions array
$questions = [
1 => ["question" => "What does PHP stand for?",
      "options" => ["A"=>"Personal Hypertext Processor","B"=>"PHP: Hypertext Preprocessor","C"=>"Private Home Page","D"=>"Public Hosting Platform"]],
2 => ["question" => "Which symbol is used to declare a PHP variable?",
      "options" => ["A"=>"#","B"=>"$","C"=>"&","D"=>"%"]],
3 => ["question" => "Which function is used to output text in PHP?",
      "options" => ["A"=>"echo","B"=>"print_r","C"=>"write","D"=>"printf_file"]],
4 => ["question" => "Which superglobal is used to collect form data (POST)?",
      "options" => ["A"=>'$_GET',"B"=>'$_POST',"C"=>'$_REQUEST',"D"=>'$_FORM']],
5 => ["question" => "Which loop is used when number of iterations is known?",
      "options" => ["A"=>"while","B"=>"foreach","C"=>"for","D"=>"do-while"]],
6 => ["question" => "Which function counts elements in an array?",
      "options" => ["A"=>"size()","B"=>"length()","C"=>"count()","D"=>"total()"]],
7 => ["question" => "Which operator is used for comparison?",
      "options" => ["A"=>"=","B"=>"==","C"=>"===","D"=>"Both B and C"]],
8 => ["question" => "Which function starts a session?",
      "options" => ["A"=>"start_session()","B"=>"session_begin()","C"=>"session_start()","D"=>"init_session()"]],
9 => ["question" => "Which array holds server information?",
      "options" => ["A"=>'$_SERVER',"B"=>'$_SESSION',"C"=>'$_COOKIE',"D"=>'$_DATA']],
10 => ["question" => "Which keyword defines a constant?",
      "options" => ["A"=>"define","B"=>"const","C"=>"static","D"=>"var"]],
11 => ["question" => "Which function includes a file?",
      "options" => ["A"=>"include()","B"=>"require()","C"=>"Both A and B","D"=>"attach()"]],
12 => ["question" => "Which symbol concatenates strings?",
      "options" => ["A"=>"+","B"=>"&","C"=>".","D"=>"||"]],
13 => ["question" => "Which method sends data through URL?",
      "options" => ["A"=>"POST","B"=>"GET","C"=>"PUT","D"=>"DELETE"]],
14 => ["question" => "Which function removes whitespace?",
      "options" => ["A"=>"trim()","B"=>"strip()","C"=>"clean()","D"=>"remove()"]],
15 => ["question" => "Which function checks if variable is set?",
      "options" => ["A"=>"check()","B"=>"isset()","C"=>"empty()","D"=>"validate()"]],
16 => ["question" => "Which function stops script execution?",
      "options" => ["A"=>"stop()","B"=>"exit()","C"=>"break()","D"=>"close()"]],
17 => ["question" => "Which function redirects user?",
      "options" => ["A"=>"redirect()","B"=>"header()","C"=>"move()","D"=>"forward()"]],
18 => ["question" => "Which loop runs at least once?",
      "options" => ["A"=>"for","B"=>"while","C"=>"do-while","D"=>"foreach"]],
19 => ["question" => "Which function gets string length?",
      "options" => ["A"=>"strlen()","B"=>"count()","C"=>"size()","D"=>"length()"]],
20 => ["question" => "Which function checks if value is empty?",
      "options" => ["A"=>"isset()","B"=>"empty()","C"=>"null()","D"=>"blank()"]],
];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP Quiz</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center p-4">

<div class="bg-white/20 backdrop-blur-lg w-full max-w-3xl p-8 rounded-3xl shadow-2xl">

<h1 class="text-3xl font-bold text-white text-center mb-4">
Welcome, <?php echo $_SESSION['name']; ?>!
</h1>

<!-- Timer -->
<div class="text-white text-right mb-4 font-semibold">
Time Remaining: <span id="timer">10:00</span>
</div>

<!-- Progress Bar -->
<div class="mb-6">
<div class="w-full bg-white/30 rounded-full h-3">
<div id="progressBar" class="bg-yellow-400 h-3 rounded-full transition-all duration-300" style="width:0%"></div>
</div>
<p class="text-right text-white text-sm mt-1" id="progressText">Question 1 of 20</p>
</div>

<form method="POST" action="result.php" id="quizForm">
<?php foreach($questions as $number => $q): ?>
<div class="question hidden" id="q<?php echo $number; ?>">
<h3 class="text-lg font-semibold mb-4 text-white">
<?php echo $number . ". " . $q['question']; ?>
</h3>
<?php foreach($q['options'] as $key => $option): ?>
<label class="block mb-3 cursor-pointer text-white">
<input type="radio" name="q<?php echo $number; ?>" value="<?php echo $key; ?>" class="mr-2">
<?php echo $key . ". " . htmlspecialchars($option); ?>
</label>
<?php endforeach; ?>
</div>
<?php endforeach; ?>

<div class="flex justify-between mt-6">
<button type="button" onclick="prevQuestion()" class="bg-gray-400 text-white px-4 py-2 rounded">Previous</button>
<button type="button" onclick="skipQuestion()" class="bg-purple-600 text-white px-4 py-2 rounded">Skip</button>
<button type="button" onclick="nextQuestion()" class="bg-indigo-600 text-white px-4 py-2 rounded">Next</button>
<button type="submit" id="submitBtn" class="bg-green-600 text-white px-4 py-2 rounded hidden">Submit</button>
</div>
</form>
</div>

<script>
let current = 1;
const total = 20;
let skipped = [];

function showQuestion(n){
document.querySelectorAll('.question').forEach(q => q.classList.add('hidden'));
document.getElementById('q'+n).classList.remove('hidden');

let percent = (n-1)/total*100;
document.getElementById('progressBar').style.width = percent + "%";
document.getElementById('progressText').innerText = "Question " + n + " of " + total;

if(n === total){
document.getElementById('submitBtn').classList.remove('hidden');
} else {
document.getElementById('submitBtn').classList.add('hidden');
}
}

function nextQuestion(){
if(current < total){
current++;
showQuestion(current);
}
}

function prevQuestion(){
if(current > 1){
current--;
showQuestion(current);
}
}

function skipQuestion(){
skipped.push(current);
nextQuestion();
}

showQuestion(current);

// Timer 10 minutes
let time = 600;
let timerInterval = setInterval(() => {
let minutes = Math.floor(time / 60);
let seconds = time % 60;
document.getElementById('timer').innerText = `${minutes}:${seconds < 10 ? '0'+seconds : seconds}`;
time--;
if(time < 0){
clearInterval(timerInterval);
document.getElementById('quizForm').submit();
}
},1000);
</script>
</body>
</html>
