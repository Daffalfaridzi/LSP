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
        $_SESSION['flash'] = ['status' => 'success', 'pesan' => 'Data berhasil ditambahkan!'];
    } else {
        $_SESSION['flash'] = ['status' => 'error', 'pesan' => 'Data gagal ditambahkan!'];
    }

    header("Location: index.php");
    exit;
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
<body class="flex bg-gray-100">
    <?php require '../../layouts/sidebar.php'; ?>

    <div class="flex-1 mt-16 p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-10"><span><a href="index.php">DATA JADWAL PENERBANGAN</a></span> > TAMBAH JADWAL PENERBANGAN</h1>


        <form action="" method="POST" class="mt-6 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl mt-2 font-bold text-gray-800 mb-4 text-center">Tambah Jadwal Penerbangan</h1>
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


            <div class="flex justify-end">
            <button type="submit" name="tambah" class="mt-5 w-20 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah</button>
        </div>        </form>
    </div>
</body>
</html>