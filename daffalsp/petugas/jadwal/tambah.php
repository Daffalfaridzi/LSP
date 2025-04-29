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

if (isset($_POST["tambah"])) {
    if (tambah($_POST) > 0) {
        echo "
            <script type='text/javascript'>
                alert('Data jadwal penerbangan berhasil ditambahkan!')
                window.location = 'index.php'
            </script>
        ";
    } else {
        echo "
            <script type='text/javascript'>
                alert('Data jadwal penerbangan gagal ditambahkan :(')
                window.location = 'index.php'
            </script>
        ";
    }
}

$rute = query("SELECT * FROM rute INNER JOIN maskapai ON maskapai.id_maskapai = rute.id_maskapai");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Penerbangan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex">
    <?php require '../../layouts/sidebarpetugas.php'; ?>

    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold text-gray-800">Halo, <?= $_SESSION["nama_lengkap"]; ?>!</h1>
        <h2 class="text-xl font-semibold text-gray-700 mt-4">Tambah Jadwal Penerbangan</h2>

        <form action="" method="POST" class="mt-6 bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="id_rute" class="block text-gray-700 font-semibold mb-2">Pilih Rute</label>
                <select name="id_rute" id="id_rute" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php foreach ($rute as $data) : ?>
                        <option value="<?= $data["id_rute"]; ?>"><?= $data["nama_maskapai"]; ?> - <?= $data["rute_asal"]; ?> - <?= $data["rute_tujuan"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="waktu_berangkat" class="block text-gray-700 font-semibold mb-2">Waktu Berangkat</label>
                <input type="time" name="waktu_berangkat" id="waktu_berangkat" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="waktu_tiba" class="block text-gray-700 font-semibold mb-2">Waktu Tiba</label>
                <input type="time" name="waktu_tiba" id="waktu_tiba" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="harga" class="block text-gray-700 font-semibold mb-2">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                 <label for="kapasitas_kursi" class="block text-gray-700 font-semibold mb-2">Kapasitas kursi</label>
                <input type="number" name="kapasitas_kursi" id="kapasitas_kursi" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>


            <button type="submit" name="tambah" class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah</button>
        </form>
    </div>
</body>
</html>