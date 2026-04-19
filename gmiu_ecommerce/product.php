<?php
// 1. SESSION & DATABASE
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config/db.php';
$base_url = '/sem-4/ALA/gmiu_ecommerce/';

// 2. GET PRODUCT ID FROM URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
}

// Redirect if product doesn't exist
if (!$product) {
    header("Location: " . $base_url . "index.php");
    exit();
}

include __DIR__ . '/includes/header.php';
?>

<div class="max-w-7xl mx-auto px-6 py-12 md:py-24">
    <nav class="flex items-center gap-4 mb-12 text-[10px] font-black uppercase tracking-[0.3em] text-gray-400">
        <a href="<?= $base_url ?>index.php" class="hover:text-indigo-600 transition-colors">Collection</a>
        <span class="w-1 h-1 bg-gray-200 rounded-full"></span>
        <span class="text-slate-900"><?= htmlspecialchars($product['name']) ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-start">
        
        <div class="space-y-6 animate-in fade-in slide-in-from-left-8 duration-1000">
            <div class="aspect-[4/5] bg-gray-50 rounded-[3rem] border border-gray-100 overflow-hidden flex items-center justify-center relative group">
                <div class="absolute top-8 left-8 bg-white/90 backdrop-blur-md px-5 py-2 rounded-2xl shadow-sm z-10">
                    <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Limited Edition</span>
                </div>

                <svg class="w-32 h-32 text-gray-200 group-hover:scale-110 transition-transform duration-1000" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-50 p-6 rounded-[2rem] border border-gray-100">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Material</p>
                    <p class="text-sm font-bold text-slate-800">Grade A Composite</p>
                </div>
                <div class="bg-slate-50 p-6 rounded-[2rem] border border-gray-100">
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Origin</p>
                    <p class="text-sm font-bold text-slate-800">Designed in GMIU</p>
                </div>
            </div>
        </div>

        <div class="lg:sticky lg:top-32 animate-in fade-in slide-in-from-right-8 duration-1000">
            <div class="mb-10 pb-10 border-b border-gray-100">
                <h1 class="brand-font text-5xl md:text-7xl font-bold text-slate-900 tracking-tighter mb-6 leading-none">
                    <?= htmlspecialchars($product['name']) ?>.
                </h1>
                
                <div class="flex items-center gap-6">
                    <span class="text-4xl font-black text-indigo-600">
                        $<?= number_format($product['price'], 2) ?>
                    </span>
                    <span class="px-4 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-widest">
                        In Stock
                    </span>
                </div>
            </div>

            <div class="mb-12">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">The Narrative</h3>
                <p class="text-lg text-gray-500 leading-relaxed font-medium italic">
                    "<?= htmlspecialchars($product['description']) ?>"
                </p>
            </div>

            <ul class="space-y-4 mb-12">
                <?php $features = ['Premium Matte Finish', 'Hand-crafted detailing', 'Signature Aura Packaging']; 
                foreach($features as $f): ?>
                <li class="flex items-center gap-3 text-sm font-bold text-slate-700">
                    <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                    <?= $f ?>
                </li>
                <?php endforeach; ?>
            </ul>

            <div class="flex flex-col sm:flex-row gap-4">
                <form action="<?= $base_url ?>cart.php" method="POST" class="flex-grow">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <button type="submit" class="w-full bg-slate-900 text-white py-6 rounded-[1.5rem] font-bold text-xs uppercase tracking-[0.3em] hover:bg-indigo-600 shadow-2xl shadow-indigo-100 transition-all duration-500 active:scale-95">
                        Add to Bag
                    </button>
                </form>
                
                <button class="px-8 py-6 rounded-[1.5rem] border border-gray-200 text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </button>
            </div>

            <p class="mt-8 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center sm:text-left">
                📦 Complimentary Shipping on all Aura Essentials
            </p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>