<?php
session_start();
if(!isset($_SESSION['uploads'])) {
    $_SESSION['uploads'] = [];
}
?>

<!DOCTYPE html>
<html lang="en"
      x-data="{ dark: localStorage.getItem('dark') === 'true' }"
      x-init="$watch('dark', val => localStorage.setItem('dark', val))"
      :class="{ 'dark': dark }">

<head>
    <meta charset="UTF-8">
    <title>Image Upload</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen transition">

<div class="max-w-4xl mx-auto px-6 py-12">

    <!-- Header -->
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
            📸 Image Upload App
        </h1>

        <button @click="dark = !dark"
            class="px-4 py-2 rounded-lg bg-gray-800 dark:bg-yellow-400 
                   text-white dark:text-black shadow">
            Toggle Mode
        </button>
    </div>

    <!-- Upload Card -->
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">

        <?php if(isset($_SESSION['message'])): ?>
            <div class="mb-4 p-3 rounded-lg text-white
                <?= strpos($_SESSION['message'], 'success') !== false ? 'bg-green-500' : 'bg-red-500'; ?>">
                <?= $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <form action="upload.php" method="POST" enctype="multipart/form-data" class="space-y-6">

            <label class="flex flex-col items-center justify-center 
                           border-2 border-dashed border-gray-300 
                           dark:border-gray-600 rounded-xl p-10 
                           cursor-pointer hover:border-blue-500 transition">

                <span class="text-gray-600 dark:text-gray-300 mb-2">
                    Click to Upload or Drag & Drop
                </span>

                <input type="file" name="image" id="imageInput" class="hidden" required>
            </label>

            <div id="previewContainer" class="hidden">
                <img id="previewImage" class="rounded-xl shadow-lg max-h-72 mx-auto">
            </div>

            <button type="submit" name="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white 
                       py-3 rounded-xl shadow-lg transition">
                Upload Image
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="gallery.php" class="text-blue-500 hover:underline">
                View Gallery →
            </a>
        </div>

    </div>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const file = event.target.files[0];

    if (file) {
        previewContainer.classList.remove('hidden');
        previewImage.src = URL.createObjectURL(file);
    }
});
</script>

</body>
</html>
