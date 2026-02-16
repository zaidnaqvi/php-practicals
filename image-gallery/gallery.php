<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="container mx-auto px-6 py-10">

    <h2 class="text-4xl font-bold text-center text-gray-800 mb-10">
        Image Gallery
    </h2>

    <?php if(!empty($_SESSION['uploads'])): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach($_SESSION['uploads'] as $image): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                    <img src="<?= $image ?>" class="w-full h-64 object-cover">
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-500">No images uploaded yet.</p>
    <?php endif; ?>

    <div class="text-center mt-10">
        <a href="index.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            ← Upload More
        </a>
    </div>

</div>

</body>
</html>
