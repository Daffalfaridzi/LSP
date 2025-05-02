<?php
require 'koneksi.php';

// Handle Delete (pakai GET dari tombol konfirmasi)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_jadwal'])) {
    $id_jadwal = $_GET['id_jadwal'];
    unset($_SESSION['cart'][$id_jadwal]);
    // Flash session agar SweetAlert muncul setelah redirect
    $_SESSION['flash'] = [
        'status' => 'success',
        'pesan' => 'Tiket berhasil dihapus dari keranjang.'
    ];
    header('Location: cart.php');
    exit;
}

// Handle Edit
if (isset($_POST['edit'])) {
    $id_jadwal = $_POST['id_jadwal'];
    $kuantitas = $_POST['kuantitas'];
    $_SESSION['cart'][$id_jadwal] = $kuantitas;
    header('Location: cart.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100">

<?php require 'layouts/navbar.php'; ?>

<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Keranjang Pemesanan Tiket</h1>

    <?php if (empty($_SESSION["cart"])): ?>
        <div class="max-w-md mx-auto overflow-hidden p-6 text-center">
            <div class="text-blue-500 mb-4">
                <i class="fas fa-shopping-cart fa-4x"></i>
            </div>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Keranjang Kosong</h2>
            <p class="text-gray-500 mb-4">Belum ada tiket yang kamu pesan!</p>
            <a href="jadwal.php" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plane mr-2"></i>Cari Tiket
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-ticket-alt text-blue-500 mr-2"></i>
                            Tiket Anda
                        </h2>
                        
                        <?php $no = 1; $grandTotal = 0; ?>
                        <?php foreach ($_SESSION["cart"] as $id_jadwal => $kuantitas): ?>
                            <?php
                            $jadwalPenerbangan = query("SELECT * FROM jadwal_penerbangan 
                                INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                                INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                                WHERE id_jadwal = '$id_jadwal'")[0];

                            $totalHarga = $jadwalPenerbangan["harga"] * $kuantitas;
                            $grandTotal += $totalHarga;
                            ?>
                            
                            <div class="border-b border-gray-200 pb-6 mb-6 last:border-0 last:pb-0 last:mb-0">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <!-- Airline Logo -->
                                    <div class="flex-shrink-0">
                                        <img src="assets/images/<?= $jadwalPenerbangan["logo_maskapai"]; ?>" 
                                             alt="<?= $jadwalPenerbangan["nama_maskapai"]; ?>"
                                             class="w-20 h-20 object-contain rounded-lg border border-gray-200 p-2"
                                             onerror="this.src='https://via.placeholder.com/80?text=No+Logo'">
                                    </div>
                                    
                                    <!-- Flight Details -->
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-800"><?= $jadwalPenerbangan["nama_maskapai"]; ?></h3>
                                                <p class="text-gray-600"><?= $jadwalPenerbangan["rute_asal"]; ?> → <?= $jadwalPenerbangan["rute_tujuan"]; ?></p>
                                            </div>
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded"><?= $no++; ?></span>
                                        </div>
                                        
                                        <div class="mt-3 grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500">Tanggal</p>
                                                <p class="font-medium"><?= date('d M Y', strtotime($jadwalPenerbangan["tanggal_pergi"])); ?></p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Waktu</p>
                                                <p class="font-medium"><?= date('H:i', strtotime($jadwalPenerbangan["waktu_berangkat"])); ?> - <?= date('H:i', strtotime($jadwalPenerbangan["waktu_tiba"])); ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 flex flex-wrap justify-between items-center gap-4">
                                            <!-- Quantity Update -->
                                            <form action="cart.php" method="POST" class="flex items-center gap-2">
                                                <input type="number" name="kuantitas" value="<?= $kuantitas; ?>" min="1" 
                                                       class="w-16 text-center border border-gray-300 rounded-md py-1 px-2 focus:ring-blue-500 focus:border-blue-500">
                                                <input type="hidden" name="id_jadwal" value="<?= $id_jadwal; ?>">
                                                <button type="submit" name="edit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    <i class="fas fa-sync-alt mr-1"></i>Update
                                                </button>
                                            </form>
                                            
                                            <!-- Price and Delete -->
                                            <div class="flex items-center gap-4">
                                                <p class="text-lg font-bold text-blue-600">Rp <?= number_format($totalHarga); ?></p>
                                                <button onclick="konfirmasiHapus(<?= $id_jadwal; ?>)" 
                                                        class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md overflow-hidden sticky top-4">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <i class="fas fa-receipt text-blue-500 mr-2"></i>
                            Ringkasan Pesanan
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-600">Total Tiket:</span>
                            <span class="font-medium"><?= count($_SESSION["cart"]); ?></span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-600">Total Harga:</span>
                            <span class="text-lg font-bold text-blue-600">Rp <?= number_format($grandTotal); ?></span>
                        </div>
                        
                        <div class="mt-6">
                            <a href="checkout.php" class="w-full flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-3xl hover:bg-green-700 transition-colors">
                                <i class="fas fa-credit-card mr-2"></i> Checkout Sekarang
                            </a>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="jadwal.php" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                <i class="fas fa-plus-circle mr-1"></i> Tambah Tiket Lain
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- SweetAlert Hapus -->
<script>
function konfirmasiHapus(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus tiket ini?',
        text: "Tindakan ini tidak bisa dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `cart.php?action=delete&id_jadwal=${id}`;
        }
    });
}
</script>

<?php if ($flash): ?>
<script>
Swal.fire({
    icon: '<?= $flash['status']; ?>',
    title: '<?= $flash['status'] === 'success' ? 'Berhasil!' : 'Gagal!'; ?>',
    text: '<?= $flash['pesan']; ?>',
    showConfirmButton: false,
    timer: 2000
});
</script>
<?php endif; ?>

</body>
</html>