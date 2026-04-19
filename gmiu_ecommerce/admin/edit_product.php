<?php 
require_once __DIR__ . '/../config/db.php';

// 1. DATA LOGIC (Move this above everything else to avoid Header warnings)
$id = $_GET['id'] ?? null;
if(!$id) {
    header("Location: dashboard.php");
    exit();
}

// Handle Update Request
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $price = $_POST['price'];
    $desc = htmlspecialchars($_POST['description']);

    try {
        $update = $conn->prepare("UPDATE products SET name=?, price=?, description=? WHERE id=?");
        $update->execute([$name, $price, $desc, $id]);
        
        // Success redirect
        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        $error = "System Error: Unable to sync changes to the database.";
    }
}

// Fetch current data for the form
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if(!$p) {
    header("Location: dashboard.php");
    exit();
}

// 2. INCLUDE UI HEADERS
include __DIR__ . '/../includes/header.php'; 

// Protection Check
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
    echo "<script>window.location.href='../login.php';</script>"; 
    exit(); 
}
?>

<div class="max-w-3xl mx-auto py-12">
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-2">
            <span class="w-8 h-[2px] bg-indigo-500"></span>
            <p class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.4em]">Asset Management</p>
        </div>
        <h1 class="brand-font text-5xl font-bold text-slate-900 tracking-tighter italic">Modify Item.</h1>
    </div>

    <div class="bg-white p-10 md:p-16 rounded-[3rem] shadow-[0_32px_64px_-16px_rgba(0,0,0,0.06)] border border-gray-100 relative overflow-hidden">
        
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-40 -z-10"></div>

        <?php if(isset($error)): ?>
            <div class="bg-rose-50 text-rose-600 p-5 rounded-2xl text-xs font-bold mb-8 border border-rose-100 italic">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-8">
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Identity Mapping (Name)</label>
                <input type="text" name="name" value="<?= htmlspecialchars($p['name']) ?>" 
                       class="w-full p-5 bg-slate-50 border-none rounded-[1.5rem] outline-none text-slate-900 text-sm font-semibold focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all duration-300" required>
            </div>
            
            <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Valuation (USD)</label>
                <input type="number" step="0.01" name="price" value="<?= $p['price'] ?>" 
                       class="w-full p-5 bg-slate-50 border-none rounded-[1.5rem] outline-none text-slate-900 text-sm font-semibold focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all duration-300" required>
            </div>

            <div class="space-y-3">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Technical Description</label>
                <textarea name="description" rows="4" 
                          class="w-full p-5 bg-slate-50 border-none rounded-[1.5rem] outline-none text-slate-900 text-sm font-semibold focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all duration-300"><?= htmlspecialchars($p['description']) ?></textarea>
            </div>

            <div class="flex items-center gap-6 pt-6 border-t border-slate-50">
                <button type="submit" 
                        class="flex-1 bg-slate-900 text-white py-5 rounded-[1.5rem] font-bold text-xs uppercase tracking-[0.2em] hover:bg-indigo-600 shadow-2xl shadow-indigo-100 transition-all duration-500 active:scale-95">
                    Sync Changes
                </button>
                <a href="dashboard.php" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500 transition-colors">Cancel</a>
            </div>
        </form>
    </div>

    <p class="text-center text-[9px] font-bold text-slate-300 uppercase tracking-[0.3em] mt-12">
        Modifications are tracked and logged via GMIU Secure Node
    </p>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>