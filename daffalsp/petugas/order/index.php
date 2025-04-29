<?php
$page = "Tiket";

session_start();
require 'functions.php';
require '../../koneksi.php'; // Pastikan file koneksi ada

// Cek apakah sudah login
if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../auth/login/index.php';
    </script>
    ";
}

// Ambil data order tiket dari database
$orderTiket = query("SELECT * FROM order_tiket");

?>

<?php require '../../layouts/sidebarpetugas.php'; ?>

<div class="flex-1 p-6">
    <h1 class="text-2xl font-bold text-gray-800">Halo, <?= $_SESSION["nama_lengkap"]; ?>!</h1>
    <h2 class="text-xl font-semibold text-gray-700 mt-4">Halaman Order Tiket</h2>

    <div class="overflow-x-auto mt-6">
        <table class="min-w-full bg-white border border-gray-400 text-center">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-2 px-4 border">Nomor Order</th>
                    <th class="py-2 px-4 border">Struk</th>
                    <th class="py-2 px-4 border">Status</th>
                    <th class="py-2 px-4 border">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderTiket as $data) : ?>
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border"><?= $data["id_order"]; ?></td>
                    <td class="py-2 px-4 border"><?= $data["struk"]; ?></td>
                    <td class="py-2 px-4 border">
                        <!-- Status dengan warna hijau jika Approved -->
                        <span class="font-bold <?= $data["status"] === 'Approved' ? 'text-green-600' : 'text-yellow-600'; ?>">
                            <?= $data["status"]; ?>
                        </span>
                    </td>
                    <td class="py-2 px-4 border">
                        <a href="verif.php?id=<?= $data["id_order"]; ?>" class="text-blue-600 hover:underline" onClick="return confirm('Apakah anda yakin ingin memverifikasi data ini?')">Verifikasi</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
