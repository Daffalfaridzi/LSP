<?php 
require 'layouts/navbar.php'; 

// Pastikan user sudah login
if (!isset($_SESSION["username"])) {
    echo "<script>
        Swal.fire({
            icon: 'warning',
            title: 'Login Required',
            text: 'Silahkan login terlebih dahulu!',
            confirmButtonColor: '#3b82f6',
        }).then(() => {
            window.location = '../auth/login/index.php';
        });
    </script>";
    exit;
}

// Koneksi ke database
require 'koneksi.php'; // Better to use your existing connection file

// Tangkap ID order dari URL dan lakukan sanitasi
$id = mysqli_real_escape_string($conn, $_GET["id"]);
$id_user = $_SESSION["id_user"];

// Query untuk mendapatkan detail pesanan
$query = "SELECT 
    order_detail.id_order_detail, 
    order_detail.id_user, 
    order_detail.id_penerbangan, 
    order_tiket.id_order, 
    order_tiket.tanggal_transaksi, 
    order_detail.jumlah_tiket, 
    order_detail.total_harga, 
    order_tiket.status,
    rute.tanggal_pergi,
    jadwal_penerbangan.waktu_berangkat,
    jadwal_penerbangan.waktu_tiba,
    rute.rute_asal,
    rute.rute_tujuan,
    maskapai.nama_maskapai,
    maskapai.logo_maskapai
FROM order_detail 
INNER JOIN order_tiket ON order_tiket.id_order = order_detail.id_order 
INNER JOIN jadwal_penerbangan ON order_detail.id_penerbangan = jadwal_penerbangan.id_jadwal
INNER JOIN rute ON jadwal_penerbangan.id_rute = rute.id_rute
INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai
WHERE order_tiket.id_order = '$id'";

$detailTiket = mysqli_query($conn, $query);
if (!$detailTiket) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Pemesanan Tiket</h1>
                <div class="w-20 h-1 bg-blue-600 mx-auto mt-4"></div>
            </div>

            <!-- Order Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <!-- Order Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <div class="flex flex-col sm:flex-row justify-between items-center">
                        <div class="mb-4 sm:mb-0">
                            <h2 class="text-xl font-bold text-white">Nomor Order</h2>
                            <p class="text-blue-100 font-mono"><?= $id; ?></p>
                        </div>
                        <?php 
                        $firstRow = mysqli_fetch_assoc($detailTiket);
                        mysqli_data_seek($detailTiket, 0); // Reset pointer
                        ?>
                        <div class="text-right">
                            <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold <?= 
                                $firstRow['status'] === 'Approved' ? 'bg-green-100 text-green-800' : 
                                ($firstRow['status'] === 'Proses' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-red-100 text-red-800') ?>">
                                <?= $firstRow['status']; ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Content -->
                <div class="p-6">
                    <!-- Flight Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <i class="fas fa-plane-departure text-blue-500 mr-2"></i>
                            Detail Penerbangan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php while($data = mysqli_fetch_assoc($detailTiket)): ?>
                            <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow">
                                <div class="flex items-start mb-4">
                                    <img src="assets/images/<?= $data['logo_maskapai']; ?>" 
                                         alt="<?= $data['nama_maskapai']; ?>"
                                         class="w-16 h-16 object-contain rounded-lg border border-gray-200 p-1 mr-4"
                                         onerror="this.src='https://via.placeholder.com/80?text=No+Logo'">
                                    <div>
                                        <h4 class="font-bold text-gray-800"><?= $data['nama_maskapai']; ?></h4>
                                        <p class="text-gray-600 text-sm"><?= $data['rute_asal']; ?> → <?= $data['rute_tujuan']; ?></p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">Tanggal</p>
                                        <p class="font-medium"><?= date('d M Y', strtotime($data['tanggal_pergi'])); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">Waktu</p>
                                        <p class="font-medium"><?= date('H:i', strtotime($data['waktu_berangkat'])); ?> - <?= date('H:i', strtotime($data['waktu_tiba'])); ?></p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">Jumlah Tiket</p>
                                        <p class="font-medium"><?= $data['jumlah_tiket']; ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total Harga</p>
                                        <p class="font-medium text-blue-600">Rp <?= number_format($data['total_harga']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <i class="fas fa-receipt text-blue-500 mr-2"></i>
                            Ringkasan Pesanan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Informasi Pemesan</h4>
                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                    <p class="text-gray-600"><span class="font-medium">ID User:</span> <?= $id_user; ?></p>
                                    <p class="text-gray-600"><span class="font-medium">Tanggal Transaksi:</span> <?= $firstRow['tanggal_transaksi']; ?></p>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Total Pembayaran</h4>
                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                    <?php 
                                    mysqli_data_seek($detailTiket, 0);
                                    $total = 0;
                                    while($data = mysqli_fetch_assoc($detailTiket)) {
                                        $total += $data['total_harga'];
                                    }
                                    ?>
                                    <p class="text-2xl font-bold text-blue-600">Rp <?= number_format($total); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
                <a href="history.php" class="flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke History
                </a>
                <button onclick="window.print()" class="flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                    <i class="fas fa-print mr-2"></i> Cetak Invoice
                </button>
            </div>
        </div>
    </div>
</body>
</html