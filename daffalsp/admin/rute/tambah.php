<?php
$page = "Rute";

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

$maskapai = query("SELECT * FROM maskapai");
$kota = query("SELECT * FROM kota");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rute</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-100">
    <?php require '../../layouts/sidebar.php'; ?>

    <div class="flex-1 mt-16 p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-10"><span><a href="index.php">DATA RUTE</a></span> > TAMBAH RUTE</h1>


        <form action="" method="POST" class="mt-6 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl mt-2 font-bold text-gray-800 mb-4 text-center">Tambah Rute</h1>
            <div class="mb-4">
                <label for="id_maskapai" class="block text-gray-700 font-semibold mb-2">Nama Maskapai</label>
                <select name="id_maskapai" id="id_maskapai" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php foreach ($maskapai as $data) : ?>
                        <option value="<?= $data["id_maskapai"]; ?>"><?= $data["nama_maskapai"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="rute_asal" class="block text-gray-700 font-semibold mb-2">Rute Asal</label>
                <select name="rute_asal" id="rute_asal" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php foreach ($kota as $data) : ?>
                        <option value="<?= $data["nama_kota"]; ?>"><?= $data["nama_kota"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="rute_tujuan" class="block text-gray-700 font-semibold mb-2">Rute Tujuan</label>
                <select name="rute_tujuan" id="rute_tujuan" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php foreach ($kota as $data) : ?>
                        <option value="<?= $data["nama_kota"]; ?>"><?= $data["nama_kota"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="tanggal_pergi" class="block text-gray-700 font-semibold mb-2">Tanggal Pergi</label>
                <input type="date" name="tanggal_pergi" id="tanggal_pergi" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>


            <div class="flex justify-end">
            <button type="submit" name="tambah" class="mt-5 w-20 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah</button>
        </div>
        </form>
    </div>
</body>
</html>