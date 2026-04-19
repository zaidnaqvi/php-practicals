<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aura & Co. | Premium Lifestyle</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --brand-indigo: #6366f1;
        }
        body { 
            font-family: 'Inter', sans-serif; 
            -webkit-font-smoothing: antialiased;
            background-color: #fcfcfd;
        }
        .brand-font { font-family: 'Syne', sans-serif; }
        
        /* Glassmorphism Effect */
        .header-glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
        }

        /* Modern Link Hover effect */
        .nav-link {
            position: relative;
            color: #64748b; /* slate-500 */
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #1e293b; /* slate-800 */
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--brand-indigo);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>
<body class="text-slate-900">

<nav class="header-glass sticky top-0 z-[100] border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 h-24 flex items-center justify-between">
        
        <a href="/gmiu_ecommerce/index.php" class="flex items-center gap-4 group">
            <div class="relative w-11 h-11 flex items-center justify-center">
                <div class="absolute inset-0 bg-indigo-600 rounded-xl rotate-45 group-hover:rotate-90 transition-all duration-700 ease-in-out shadow-xl shadow-indigo-100"></div>
                <svg class="relative w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div class="flex flex-col">
                <span class="brand-font text-xl font-bold tracking-tighter leading-none">AURA</span>
                <span class="text-[9px] font-black tracking-[0.4em] text-indigo-500 uppercase">Est 2026</span>
            </div>
        </a>

        <div class="hidden lg:flex items-center gap-10">
            <a href="/sem-4/ALA/gmiu_ecommerce/index.php" class="nav-link text-[12px] font-bold uppercase tracking-[0.15em]">Home</a>
            <a href="/sem-4/ALA/gmiu_ecommerce/product.php" class="nav-link text-[12px] font-bold uppercase tracking-[0.15em]">Products</a>
            <a href="#" class="nav-link text-[12px] font-bold uppercase tracking-[0.15em]">About</a>
            <a href="#" class="nav-link text-[12px] font-bold uppercase tracking-[0.15em]">Contact</a>
            
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <div class="h-4 w-[1px] bg-gray-200 mx-2"></div>
                <a href="/gmiu_ecommerce/admin/dashboard.php" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 px-4 py-2 rounded-full border border-indigo-100 hover:bg-indigo-600 hover:text-white transition-all">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Admin Dashboard
                </a>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-3">
            <button class="p-2 text-slate-400 hover:text-indigo-600 transition-colors hidden sm:block">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>

            <a href="/sem-4/ALA/gmiu_ecommerce/cart.php" class="group relative p-2 mr-2">
                <svg class="w-6 h-6 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <?php 
                $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                if($cart_count > 0): 
                ?>
                    <span class="absolute top-0 right-0 bg-indigo-600 text-white text-[9px] font-black w-4 h-4 flex items-center justify-center rounded-full ring-2 ring-white">
                        <?= $cart_count ?>
                    </span>
                <?php endif; ?>
            </a>

            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="/sem-4/ALA/gmiu_ecommerce/logout.php" class="bg-rose-50 text-rose-600 px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all">
                    Logout
                </a>
            <?php else: ?>
                <a href="/sem-4/ALA/gmiu_ecommerce/login.php" class="bg-slate-900 text-white px-7 py-3 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 shadow-xl shadow-indigo-100 transition-all active:scale-95">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-6 py-16 min-h-screen">