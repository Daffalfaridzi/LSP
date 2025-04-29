<?php
$page = "Jadwal";

session_start();
require 'functions.php';

if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../../auth/login/index.php';
    </script>
    ";
}

$jadwal = query("SELECT * FROM jadwal_penerbangan 
INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai ORDER BY tanggal_pergi, waktu_berangkat");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Data Jadwal Penerbangan</title>
</head>
<body class="flex">
    <?php require '../../layouts/sidebarpetugas.php'; ?>

    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold text-gray-800">Halo, <?= $_SESSION["nama_lengkap"]; ?>!</h1>
        <h2 class="text-xl font-semibold text-gray-700 mt-4">Halaman Data Jadwal Penerbangan</h2>

        <a href="tambah.php" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah</a>

        <div class="overflow-x-auto mt-6 text-center">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="py-2 px-4 border">No</th>
                        <th class="py-2 px-4 border">Nama Maskapai</th>
                        <th class="py-2 px-4 border">Kapasitas</th>
                        <th class="py-2 px-4 border">Rute Asal</th>
                        <th class="py-2 px-4 border">Rute Tujuan</th>
                        <th class="py-2 px-4 border">Tanggal Pergi</th>
                        <th class="py-2 px-4 border">Waktu Berangkat</th>
                        <th class="py-2 px-4 border">Waktu Tiba</th>
                        <th class="py-2 px-4 border">Harga</th>
                        <th class="py-2 px-4 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($jadwal as $data) : ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border"><?= $no; ?></td>
                        <td class="py-2 px-4 border"><?= $data["nama_maskapai"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["kapasitas_kursi"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["rute_asal"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["rute_tujuan"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["tanggal_pergi"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["waktu_berangkat"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["waktu_tiba"]; ?></td>
                        <td class="py-2 px-4 border">Rp <?= number_format($data["harga"]); ?></td>
                        <td class="py-2 px-4 border">
                            <a href="edit.php?id=<?= $data["id_jadwal"]; ?>" class="text-blue-600 hover:underline">Edit</a>
                            <a href="hapus.php?id=<?= $data["id_jadwal"]; ?>" class="text-red-600 hover:underline" onClick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php $no++; ?>
                    <?php endforeach; ?>
 </tbody>
            </table>
        </div>
    </div>

    <script src="/e-ticketing-xiirpl/assets/sweet-alert/js/jquery-2.1.4.min.js"></script>
    <script src="/e-ticketing-xiirpl/assets/sweet-alert/js/sweetalert.min.js"></script>
</body>
</html>