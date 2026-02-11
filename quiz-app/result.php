<?php
session_start();

if(!isset($_SESSION['name'])){
    header("Location: index.php");
    exit;
}

// Correct answers
$correctAnswers = [
"q1"=>"B","q2"=>"B","q3"=>"A","q4"=>"B","q5"=>"C",
"q6"=>"C","q7"=>"D","q8"=>"C","q9"=>"A","q10"=>"B",
"q11"=>"C","q12"=>"C","q13"=>"B","q14"=>"A","q15"=>"B",
"q16"=>"B","q17"=>"B","q18"=>"C","q19"=>"A","q20"=>"B"
];

$score = 0;
$total = count($correctAnswers);

foreach($correctAnswers as $question => $answer){
    if(isset($_POST[$question]) && $_POST[$question] == $answer){
        $score++;
    }
}

$percentage = ($score / $total) * 100;
$name = $_SESSION['name'];
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Quiz Result</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-900 to-indigo-900 flex items-center justify-center p-4">

<div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md text-center">

<h1 class="text-3xl font-bold mb-4 text-indigo-600">Congratulations, <?php echo $name; ?>!</h1>

<p class="text-4xl font-bold mb-2"><?php echo "$score / $total"; ?></p>
<p class="text-lg mb-4"><?php echo number_format($percentage,2); ?>%</p>

<?php if($percentage >= 80): ?>
<p class="text-green-600 font-semibold mb-4">🏆 Excellent Performance!</p>
<?php elseif($percentage >= 50): ?>
<p class="text-yellow-600 font-semibold mb-4">👍 Good Job!</p>
<?php else: ?>
<p class="text-red-600 font-semibold mb-4">📚 Keep Practicing!</p>
<?php endif; ?>

<a href="index.php" class="inline-block mt-4 bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Try Again</a>

</div>
</body>
</html>
