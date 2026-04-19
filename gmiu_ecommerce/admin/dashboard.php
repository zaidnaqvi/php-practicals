<?php 
require_once __DIR__ . '/../config/db.php';
include __DIR__ . '/../includes/header.php'; 

// 1. Access Control (Simplified Logic)
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// 2. Data Fetching
$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
$total_products = count($products);
$total_value = array_sum(array_column($products, 'price'));
?>

<div class="max-w-7xl mx-auto px-6 py-12">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-16 gap-8">
        <div>
            <h1 class="text-5xl font-black text-slate-900 tracking-tighter italic mb-2">Inventory <span class="text-indigo-600">.</span></h1>
            <p class="text-gray-400 text-xs font-bold uppercase tracking-[0.3em]">System Control & Asset Management</p>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="hidden md:flex flex-col text-right mr-4">
                <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Server Time</span>
                <span class="text-xs font-bold text-slate-900"><?= date('H:i T') ?></span>
            </div>
            <a href="add_product.php" class="bg-slate-900 text-white px-10 py-5 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-indigo-100 flex items-center gap-3 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                New Entry
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
        <div class="md:col-span-2 bg-slate-900 p-10 rounded-[3rem] text-white relative overflow-hidden shadow-2xl">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.4em] mb-6">Total Asset Valuation</p>
                <h3 class="text-6xl font-black tracking-tighter mb-2">$<?= number_format($total_value, 2) ?></h3>
                <p class="text-slate-400 text-sm italic">Accumulated value across <?= $total_products ?> items</p>
            </div>
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm flex flex-col justify-between">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em]">Active SKUs</p>
            <h3 class="text-5xl font-black text-slate-900 tracking-tighter"><?= $total_products ?></h3>
            <div class="w-full bg-gray-50 h-1.5 rounded-full mt-4 overflow-hidden">
                <div class="bg-indigo-500 h-full w-2/3"></div>
            </div>
        </div>

        <div class="bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm flex flex-col justify-between">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em]">Node Status</p>
            <div class="flex items-center gap-3">
                <span class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></span>
                <h3 class="text-3xl font-bold text-slate-900 italic">Online</h3>
            </div>
            <p class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full self-start mt-4">Encrypted</p>
        </div>
    </div>

    <div class="bg-white rounded-[3.5rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-10 py-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em]">Product Archive</h4>
            <span class="text-[10px] font-black text-indigo-500 bg-indigo-50 px-4 py-1.5 rounded-full"><?= $total_products ?> Items Found</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left border-b border-gray-50">
                        <th class="px-10 py-6 text-[9px] font-black text-gray-400 uppercase tracking-widest">Item Specification</th>
                        <th class="px-10 py-6 text-[9px] font-black text-gray-400 uppercase tracking-widest">Market Value</th>
                        <th class="px-10 py-6 text-[9px] font-black text-gray-400 uppercase tracking-widest text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php if($total_products > 0): ?>
                        <?php foreach($products as $p): ?>
                        <tr class="group hover:bg-slate-50/50 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-300 group-hover:bg-white group-hover:shadow-lg transition-all duration-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-900 mb-1"><?= htmlspecialchars($p['name']) ?></div>
                                        <div class="text-[10px] font-medium text-gray-400 italic uppercase tracking-wider">Ref: #AURA-<?= $p['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-base font-black text-slate-900">$<?= number_format($p['price'], 2) ?></span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="edit_product.php?id=<?= $p['id'] ?>" class="p-3 bg-gray-50 text-slate-400 rounded-xl hover:bg-slate-900 hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <a href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('Archive Item?')" class="p-3 bg-rose-50 text-rose-400 rounded-xl hover:bg-rose-500 hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-10 py-32 text-center text-[10px] font-bold text-gray-300 uppercase tracking-widest italic">
                                Null Inventory. Awaiting system synchronization.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>