<?php 
require 'layouts/navbar.php'; 

// Pastikan user sudah login
if (!isset($_SESSION["username"])) {
    echo "<script>
        alert('Silahkan login terlebih dahulu!');
        window.location = '../auth/login/index.php';
    </script>";
    exit;
}

// Koneksi ke database
$conn = mysqli_connect('localhost', 'root', '', 'daffatiket');
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Tangkap ID order dari URL dan lakukan sanitasi
$id = mysqli_real_escape_string($conn, $_GET["id"]);
$id_user = $_SESSION["id_user"];

// Pastikan kolom yang digunakan benar (ubah jika id_jadwal tidak ada)
$query = "SELECT 
    order_detail.id_order_detail, 
    order_detail.id_user, 
    order_detail.id_penerbangan, 
    order_tiket.id_order, 
    order_tiket.tanggal_transaksi, 
    order_detail.jumlah_tiket, 
    order_detail.total_harga, 
    order_tiket.status 
FROM order_detail 
INNER JOIN order_tiket ON order_tiket.id_order = order_detail.id_order 
WHERE order_tiket.id_order = '$id'";

// Jalankan query dan tangani error jika ada
$detailTiket = mysqli_query($conn, $query);
if (!$detailTiket) {
    die("Query Error: " . mysqli_error($conn)); // Menampilkan error jika query salah
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Detail Pemesanan - E Ticketing</title>
</head>
<body class="bg-gray-100 flex justify-center min-h-screen p-6">

    <div class="bg-white shadow-xl rounded-lg p-8 w-full mx-auto mt-20 max-w-7xl">
        <h1 class="text-3xl font-bold text-center text-gray-900 mb-6">Detail Pemesanan - E Ticketing</h1>
        <h4 class="text-xl text-gray-700 mb-6">Nomor Order: <span class="font-bold text-blue-600"><?= $id; ?></span></h4>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300 text-center rounded-lg shadow-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="border border-gray-300 px-6 py-3">No</th>
                        <th class="border border-gray-300 px-6 py-3">ID Order</th>
                        <th class="border border-gray-300 px-6 py-3">ID User</th>
                        <th class="border border-gray-300 px-6 py-3">Tanggal Transaksi</th>
                        <th class="border border-gray-300 px-6 py-3">Jumlah Tiket</th>
                        <th class="border border-gray-300 px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50 text-gray-800">
                    <?php 
                    $no = 1;
                    while($data = mysqli_fetch_assoc($detailTiket)) : ?>
                    <tr class="hover:bg-gray-100 transition">
                        <td class="border border-gray-300 px-6 py-3 text-center"><?= $no++; ?></td>
                        <td class="border border-gray-300 px-6 py-3"><?= $data["id_order"]; ?></td>
                        <td class="border border-gray-300 px-6 py-3"><?= $data["id_user"]; ?></td>
                        <td class="border border-gray-300 px-6 py-3"><?= $data["tanggal_transaksi"]; ?></td>
                        <td class="border border-gray-300 px-6 py-3 text-center"><?= $data["jumlah_tiket"]; ?></td>
                        <td class="border border-gray-300 px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $data["status"] === 'Approved' ? 'bg-green-200 text-green-700' : 'bg-yellow-200 text-yellow-700'; ?>">
                                <?= $data["status"]; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-center">
            <a href="history.php" class="inline-block bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow hover:bg-blue-700 transition">Kembali ke History</a>
        </div>
    </div>

</body>
</html>
