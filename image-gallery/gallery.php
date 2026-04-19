<?php
session_start();
if(!isset($_SESSION['uploads'])) {
    $_SESSION['uploads'] = [];
}
?>

<!DOCTYPE html>
<html lang="en"
      x-data="{ dark: localStorage.getItem('dark') === 'true', modal: false, modalImg: '' }"
      x-init="$watch('dark', val => localStorage.setItem('dark', val))"
      :class="{ 'dark': dark }">

<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 min-h-screen transition">

<div class="max-w-6xl mx-auto px-6 py-12">

    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
            Gallery (<?= count($_SESSION['uploads']) ?> Images)
        </h1>

        <button @click="dark = !dark"
            class="px-4 py-2 rounded-lg bg-gray-800 dark:bg-yellow-400 
                   text-white dark:text-black shadow">
            Toggle Mode
        </button>
    </div>

    <?php if(count($_SESSION['uploads']) > 0): ?>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            <?php foreach($_SESSION['uploads'] as $index => $image): ?>

                <div class="relative group bg-white dark:bg-gray-800 
                            rounded-xl overflow-hidden shadow-lg">

                    <img src="<?= $image['path'] ?>"
                         @click="modal = true; modalImg = '<?= $image['path'] ?>'"
                         class="w-full h-60 object-cover cursor-pointer">

                    <div class="absolute inset-0 bg-black bg-opacity-40 
                                opacity-0 group-hover:opacity-100 
                                flex flex-col justify-end p-4 transition">

                        <p class="text-white text-sm">
                            <?= $image['date'] ?>
                        </p>

                        <a href="delete.php?id=<?= $index ?>"
                           class="mt-2 bg-red-500 hover:bg-red-600 text-white 
                                  text-sm px-3 py-1 rounded">
                            Delete
                        </a>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="text-center py-20">
            <p class="text-gray-500 dark:text-gray-400 text-lg">
                No images uploaded yet.
            </p>
        </div>

    <?php endif; ?>

    <div class="text-center mt-10">
        <a href="index.php"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            ← Upload More
        </a>
    </div>

</div>

<!-- Modal -->
<div x-show="modal"
     class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center"
     @click.away="modal = false">
    <img :src="modalImg" class="max-h-[90vh] rounded-xl shadow-2xl">
</div>

</body>
</html>
