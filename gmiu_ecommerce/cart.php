<?php
/**
 * 1. MANDATORY SESSION START
 * This must happen before any other code to ensure 
 * items added on index.php are remembered here.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. DATABASE & CONFIG
require_once __DIR__ . '/config/db.php';

// Define Base Path for consistent routing
$base_url = '/sem-4/ALA/gmiu_ecommerce/';

/**
 * 3. ADD TO CART LOGIC
 * Handled before any HTML output to allow header() redirects.
 */
if (isset($_POST['product_id'])) {
    $p_id = $_POST['product_id'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Add the product ID to the session array
    $_SESSION['cart'][] = $p_id;
    
    // Redirect back to cart to prevent form re-submission
    header("Location: " . $base_url . "cart.php");
    exit();
}

/**
 * 4. REMOVE FROM CART LOGIC
 */
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        // Re-index array to avoid gaps in numeric keys
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header("Location: " . $base_url . "cart.php");
    exit();
}

/**
 * 5. DATA PREPARATION
 */
$cart_items = [];
$total = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Sanitize IDs for SQL
    $unique_ids = array_unique(array_map('intval', $_SESSION['cart']));
    $ids_string = implode(',', $unique_ids);
    
    try {
        $stmt = $conn->query("SELECT * FROM products WHERE id IN ($ids_string)");
        $products_lookup = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Map the flat DB results back to the session items (to support duplicates)
        foreach ($_SESSION['cart'] as $session_id) {
            foreach ($products_lookup as $product) {
                if ($product['id'] == $session_id) {
                    $cart_items[] = $product;
                    $total += $product['price'];
                }
            }
        }
    } catch (PDOException $e) {
        // Silently handle if table is empty or query fails
        $cart_items = [];
    }
}

// 6. INCLUDE HEADER (Output starts here)
include __DIR__ . '/includes/header.php';
?>

<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="flex items-end justify-between mb-12 border-b border-gray-100 pb-8">
        <div>
            <h1 class="brand-font text-5xl font-bold text-slate-900 tracking-tight">Your Bag</h1>
            <p class="text-gray-400 mt-2 uppercase tracking-[0.2em] text-[10px] font-black">Aura & Co. Selection</p>
        </div>
        <div class="text-right hidden sm:block">
            <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Total Items</p>
            <p class="text-2xl font-black text-indigo-600"><?= count($cart_items) ?></p>
        </div>
    </div>

    <?php if (empty($cart_items)): ?>
        <div class="py-24 text-center bg-white rounded-[3rem] border border-dashed border-gray-200 shadow-sm animate-in fade-in duration-700">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900 mb-2">The bag is empty</h2>
            <p class="text-gray-500 mb-10 max-w-xs mx-auto text-sm leading-relaxed">Looks like you haven't added any Aura pieces to your collection yet.</p>
            <a href="<?= $base_url ?>index.php" class="inline-block bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-100 active:scale-95">
                Explore Collection
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
            
            <div class="lg:col-span-2 space-y-6">
                <?php foreach ($cart_items as $index => $item): ?>
                <div class="group bg-white p-6 rounded-[2.5rem] border border-gray-100 flex items-center gap-6 hover:shadow-xl hover:shadow-indigo-50/50 transition-all duration-500">
                    <div class="w-24 h-24 bg-gray-50 rounded-3xl flex-shrink-0 flex items-center justify-center group-hover:bg-indigo-50 transition-colors">
                        <svg class="w-8 h-8 text-gray-200 group-hover:text-indigo-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    
                    <div class="flex-grow">
                        <h3 class="text-lg font-bold text-slate-900 mb-1"><?= htmlspecialchars($item['name'] ?? 'Aura Item') ?></h3>
                        <p class="text-indigo-600 font-black text-sm">$<?= number_format($item['price'], 2) ?></p>
                    </div>

                    <a href="<?= $base_url ?>cart.php?remove=<?= $index ?>" class="p-4 text-gray-300 hover:text-rose-500 bg-gray-50 rounded-2xl hover:bg-rose-50 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-slate-900 text-white p-10 rounded-[3rem] shadow-2xl shadow-indigo-200 sticky top-32">
                    <h3 class="brand-font text-2xl font-bold mb-8">Summary</h3>
                    
                    <div class="space-y-4 mb-10">
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Subtotal</span>
                            <span class="text-white font-bold">$<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="flex justify-between text-slate-400 text-sm">
                            <span>Shipping</span>
                            <span class="text-emerald-400 font-bold uppercase tracking-widest text-[10px]">Complimentary</span>
                        </div>
                        <div class="pt-4 border-t border-slate-800 flex justify-between items-center">
                            <span class="text-lg font-bold">Total</span>
                            <span class="text-3xl font-black text-indigo-400">$<?= number_format($total, 2) ?></span>
                        </div>
                    </div>

                    <button class="w-full bg-indigo-600 text-white py-5 rounded-2xl font-bold text-xs uppercase tracking-[0.2em] hover:bg-white hover:text-slate-900 transition-all duration-500 shadow-lg active:scale-95">
                        Checkout Now
                    </button>
                    
                    <p class="text-center text-[10px] text-slate-500 mt-6 uppercase tracking-widest font-bold">
                        Secure SSL Encryption
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>