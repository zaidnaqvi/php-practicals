<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Upload</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-lg">

    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">
        Upload Image
    </h2>

    <?php if(isset($_SESSION['message'])): ?>
        <div class="mb-4 p-3 rounded-lg text-white 
            <?= strpos($_SESSION['message'], 'successfully') !== false ? 'bg-green-500' : 'bg-red-500'; ?>">
            <?= $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <form action="upload.php" method="POST" enctype="multipart/form-data" class="space-y-4">

        <label class="block">
            <span class="sr-only">Choose File</span>
            <input type="file" name="image" id="imageInput"
                class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-lg file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100" required>
        </label>

        <!-- Image Preview -->
        <div id="previewContainer" class="hidden">
            <p class="text-sm text-gray-600 mb-2">Preview:</p>
            <img id="previewImage" class="rounded-lg shadow-md max-h-64 mx-auto">
        </div>

        <button type="submit" name="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-300">
            Upload Image
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="gallery.php" class="text-blue-600 hover:underline">
            View Gallery →
        </a>
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
 