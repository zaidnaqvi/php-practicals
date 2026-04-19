<?php 
// Standardized Pathing for XAMPP
$base_url = '/sem-4/ALA/gmiu_ecommerce/';
require_once __DIR__ . '/config/db.php';
include __DIR__ . '/includes/header.php'; 

try {
    $products = $conn->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
} catch (PDOException $e) {
    $products = [];
}
?>

<style>
    /* Premium Color Palette & Typography */
    :root {
        --aura-bg: #f8f7f4; /* Soft Alabaster */
        --aura-card: #ffffff;
        --aura-accent: #6366f1;
        --aura-text: #1a1c1e;
        --aura-border: #e5e7eb;
    }

    body { background-color: var(--aura-bg); }

    .hero-title { font-size: clamp(4rem, 12vw, 10rem); line-height: 0.85; letter-spacing: -0.04em; }
    
    /* Product Card Styling */
    .product-card { 
        background-color: var(--aura-card);
        border: 1px solid var(--aura-border);
        border-radius: 2.5rem; /* Rounded Permanently */
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        display: flex;
        flex-direction: column;
        padding: 1.5rem;
    }

    .product-card:hover {
        border-color: var(--aura-accent);
        transform: translateY(-8px);
        box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.08);
    }

    .img-showcase {
        aspect-ratio: 1 / 1;
        background-color: #f3f4f6; /* Light Grey offset */
        border-radius: 1.8rem;
        overflow: hidden;
        position: relative;
    }

    .nav-pill {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .nav-pill:hover:not(.active) {
        border-color: var(--aura-accent);
        color: var(--aura-accent);
    }

    .active-pill {
        background-color: var(--aura-text);
        color: white !important;
    }
</style>

<section class="relative min-h-[90vh] flex items-center overflow-hidden mb-20 px-4">
    <div class="absolute inset-0 z-0 rounded-[3.5rem] overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent z-10"></div>
        <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&q=80&w=2070" 
             class="w-full h-full object-cover" alt="Hero">
    </div>

    <div class="container mx-auto px-10 relative z-20">
        <div class="max-w-4xl">
            <p class="text-[10px] font-black uppercase tracking-[0.6em] text-indigo-400 mb-8">
                The Aura Collection — 2026
            </p>
            <h1 class="hero-title font-black text-white mb-10">
                LUXE <br> <span class="italic font-light text-indigo-400">Atmosphere.</span>
            </h1>
            <div class="flex gap-8 items-center">
                <a href="#shop" class="bg-white text-black px-12 py-6 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all duration-500">
                    Discover Now
                </a>
                <a href="<?= $base_url ?>login.php" class="text-[10px] font-black uppercase tracking-widest text-gray-300 hover:text-white transition-colors">
                    Admin Portal &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<div id="shop" class="max-w-7xl mx-auto px-6 mb-16">
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 py-8 px-10 bg-white border border-gray-100 rounded-[2.5rem] shadow-sm">
        <h2 class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-400">Curated Series</h2>
        <div class="flex flex-wrap gap-4">
            <?php 
            $cats = ['All Series', 'Digital', 'Lifestyle', 'Archive']; 
            foreach($cats as $i => $c): ?>
                <a href="#" class="nav-pill px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest <?= $i==0 ? 'active-pill' : 'text-gray-500' ?>">
                    <?= $c ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 mb-32">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        <?php if (count($products) > 0): ?>
            <?php foreach($products as $p): ?>
            
            <div class="product-card group">
                <div class="img-showcase mb-8 flex items-center justify-center">
                    <div class="w-full h-full flex items-center justify-center grayscale group-hover:grayscale-0 transition-all duration-700 p-16">
                        <svg class="w-full h-full text-gray-300 group-hover:text-indigo-200 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>

                    <div class="absolute top-6 right-6 bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                        <span class="text-xs font-black text-slate-900">$<?= number_format($p['price'], 2); ?></span>
                    </div>

                    <div class="absolute inset-0 flex items-center justify-center bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <form action="<?= $base_url ?>cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                            <button type="submit" class="bg-indigo-600 text-white px-8 py-4 rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-2xl hover:scale-105 transition-all">
                                Add To Bag +
                            </button>
                        </form>
                    </div>
                </div>

                <div class="px-2">
                    <div class="flex flex-col mb-4">
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-indigo-500 mb-1">
                            #AURA-00<?= $p['id'] ?>
                        </p>
                        <a href="product.php?id=<?= $p['id'] ?>">
                            <h3 class="text-2xl font-bold text-slate-900 leading-tight hover:text-indigo-600 transition-colors">
                                <?= htmlspecialchars($p['name']); ?>
                            </h3>
                        </a>
                    </div>
                    
                    <p class="text-sm text-gray-500 line-clamp-2 italic mb-6">
                        "<?= htmlspecialchars($product['description'] ?? 'Designed with precision for the modern boutique experience.') ?>"
                    </p>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-100 mt-auto">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">In Stock</span>
                        <a href="product.php?id=<?= $p['id'] ?>" class="text-[10px] font-black uppercase tracking-widest text-slate-900 hover:text-indigo-600 flex items-center gap-2">
                            Explore <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full py-40 text-center bg-white rounded-[3rem] border border-dashed border-gray-200">
                <p class="text-[10px] font-black uppercase tracking-[0.5em] text-gray-300 italic">Collection Awaiting Synchronization.</p>
            </div>
        <?php endif; ?>
    </div> 
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>