<?php
// 1. Clear all session data
session_start();
session_unset();
session_destroy();

// 2. Clear session cookie (Best practice for security)
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@800&family=Inter:wght@500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .brand-font { font-family: 'Syne', sans-serif; }
    </style>
</head>
<body class="bg-[#FCFCFD] flex items-center justify-center min-h-screen overflow-hidden">

    <div class="text-center animate-in fade-in duration-1000">
        <div class="relative w-16 h-16 mx-auto mb-8 flex items-center justify-center">
            <div class="absolute inset-0 bg-indigo-600 rounded-2xl rotate-45 animate-spin [animation-duration:3s]"></div>
            <svg class="relative w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>

        <h2 class="brand-font text-2xl font-bold text-slate-900 uppercase tracking-tighter mb-2">
            Signing Out
        </h2>
        <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.4em] mb-8">
            Securing your Aura session...
        </p>

        <div class="w-48 h-1 bg-gray-100 rounded-full mx-auto overflow-hidden">
            <div class="h-full bg-indigo-600 w-full origin-left animate-[slide_1.5s_ease-in-out]"></div>
        </div>
    </div>

    <script>
        // Redirect after the animation finishes (1.5 seconds)
        setTimeout(() => {
            window.location.href = '/sem-4/ALA/gmiu_ecommerce/login.php';
        }, 1500);
    </script>

    <style>
        @keyframes slide {
            0% { transform: scaleX(0); }
            100% { transform: scaleX(1); }
        }
    </style>
</body>
</html>