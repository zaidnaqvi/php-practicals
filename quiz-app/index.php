<?php
session_start();

// If form submitted with name, save it and show quiz
if(isset($_POST['name'])){
    $_SESSION['name'] = htmlspecialchars($_POST['name']);
    header("Location: quiz.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP Pro Quiz</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center p-4">

<div class="bg-white/20 backdrop-blur-lg w-full max-w-md p-10 rounded-3xl shadow-2xl text-center">

<h1 class="text-4xl font-bold text-white mb-6">Welcome to PHP Pro Quiz</h1>

<form method="POST" class="flex flex-col gap-4">
<input type="text" name="name" placeholder="Enter your first name" required
class="px-4 py-2 rounded text-gray-800 focus:outline-none">
<button type="submit" class="bg-yellow-400 text-white px-6 py-2 rounded hover:bg-yellow-500">
Start Quiz
</button>
</form>

</div>
</body>
</html>
