<?php 
require_once __DIR__ . '/../config/db.php';

// --- LOGIC TO SAVE THE PRODUCT ---
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $price = $_POST['price'];
    $desc = htmlspecialchars($_POST['description']);
    $serial = htmlspecialchars($_POST['serial_no']);

    $image_name = 'default.png'; // Fallback image

    // Handle File Upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
        $file = $_FILES['product_image'];
        $upload_dir = __DIR__ . '/../uploads/'; 
        
        $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $image_name = 'item_' . uniqid() . '.' . $file_ext;
        $target_path = $upload_dir . $image_name;

        if (!move_uploaded_file($file['tmp_name'], $target_path)) {
            $image_name = 'default.png';
            $error = "Could not upload the image.";
        }
    }

    try {
        $sql = "INSERT INTO products (name, price, description, serial_no, image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $price, $desc, $serial, $image_name]);
        
        header("Location: dashboard.php");
        exit(); 
    } catch (PDOException $e) {
        $error = "Database Error: Could not save the product.";
    }
}

include __DIR__ . '/../includes/header.php'; 

// Check if Admin
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
    echo "<script>window.location.href='../login.php';</script>"; 
    exit(); 
}
?>

<div class="max-w-6xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-12 border-b pb-6">
        <div>
            <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mb-1">Store Admin</p>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight italic">Add New Product.</h1>
        </div>
        <a href="dashboard.php" class="text-sm font-bold text-gray-400 hover:text-red-500 transition-colors">
            Cancel
        </a>
    </div>

    <?php if(isset($error)): ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-bold mb-8 border border-red-100">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-10">
        
        <div class="bg-slate-50 border rounded-[2.5rem] p-8 flex flex-col items-center justify-center text-center group transition-all hover:bg-white hover:shadow-xl">
            <label for="image_upload" class="cursor-pointer w-full h-full flex flex-col items-center justify-center space-y-4">
                <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-all">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="space-y-1">
                    <p class="text-slate-900 font-bold">Select Product Image</p>
                    <p class="text-xs text-gray-400">Recommended size: 800x1000px</p>
                </div>
                <p id="file_name_display" class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full hidden"></p>
            </label>
            <input type="file" name="product_image" id="image_upload" class="hidden" accept="image/*" required>
        </div>

        <div class="bg-white p-10 rounded-[2.5rem] border shadow-sm space-y-8">
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Product Name</label>
                    <input type="text" name="name" placeholder="Enter name..." 
                           class="w-full p-4 bg-slate-50 border-none rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Price ($)</label>
                        <input type="number" step="0.01" name="price" placeholder="0.00" 
                               class="w-full p-4 bg-slate-50 border-none rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Serial Code</label>
                        <input type="text" name="serial_no" placeholder="#12345" 
                               class="w-full p-4 bg-slate-50 border-none rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Product Description</label>
                    <textarea name="description" rows="4" placeholder="Brief details about the item..." 
                              class="w-full p-4 bg-slate-50 border-none rounded-2xl outline-none focus:ring-2 focus:ring-indigo-500 transition-all"></textarea>
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg active:scale-95">
                Save Product
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('image_upload').onchange = function () {
        const display = document.getElementById('file_name_display');
        display.innerText = "Selected: " + this.files[0].name;
        display.classList.remove('hidden');
    };
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>