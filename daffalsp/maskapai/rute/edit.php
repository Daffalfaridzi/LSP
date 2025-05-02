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

$id = $_GET["id"];
$rute = query("SELECT * FROM rute INNER JOIN maskapai ON maskapai.id_maskapai = rute.id_maskapai WHERE id_rute = '$id'")[0];

$maskapai = query("SELECT * FROM maskapai");
$kota = query("SELECT * FROM kota");

if (isset($_POST["edit"])) {
    if (edit($_POST) > 0) {
        $_SESSION['flash'] = ['status' => 'success', 'pesan' => 'Data berhasil diubah!'];
    } else {
        $_SESSION['flash'] = ['status' => 'error', 'pesan' => 'Data gagal diubah!'];
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rute</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-100">
    <?php require '../../layouts/sidebarmaskapai.php'; ?>

    <div class="flex-1 mt-16 p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-10"><span><a href="index.php">DATA RUTE</a></span> > TAMBAH RUTE</h1>


        <form action="" method="POST" class="mt-6 bg-white p-6 rounded-lg shadow-md">
            <input type="hidden" name="id_rute" value="<?= $rute["id_rute"]; ?>">
            <h1 class="text-2xl mt-2 font-bold text-gray-800 mb-4 text-center">Edit Rute</h1>

            <div class="mb-4">
                <label for="id_maskapai" class="block text-gray-700 font-semibold mb-2">Nama Maskapai</label>
                <select name="id_maskapai" id="id_maskapai" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="<?= $rute["id_maskapai"]; ?>"><?= $rute["nama_maskapai"]; ?></option>
                    <?php foreach ($maskapai as $data) : ?>
                        <option value="<?= $data["id_maskapai"]; ?>"><?= $data["nama_maskapai"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="rute_asal" class="block text-gray-700 font-semibold mb-2">Rute Asal</label>
                <select name="rute_asal" id="rute_asal" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="<?= $rute["rute_asal"]; ?>"><?= $rute["rute_asal"]; ?></option>
                    <?php foreach ($kota as $data) : ?>
                        <option value="<?= $data["nama_kota"]; ?>"><?= $data["nama_kota"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="rute_tujuan" class="block text-gray-700 font-semibold mb-2">Rute Tujuan</label>
                <select name="rute_tujuan" id="rute_tujuan" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="<?= $rute["rute_tujuan"]; ?>"><?= $rute["rute_tujuan"]; ?></option>
                    <?php foreach ($kota as $data) : ?>
                        <option value="<?= $data["nama_kota"]; ?>"><?= $data["nama_kota"]; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="tanggal_pergi" class="block text-gray-700 font-semibold mb-2">Tanggal Pergi</label>
                <input type="date" name="tanggal_pergi" id="tanggal_pergi" value="<?= $rute["tanggal_pergi"]; ?>" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="flex justify-end">
            <button type="submit" name="edit" class="mt-5 w-20 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Edit</button>
        </div>
        </form>
    </div>
</body>
</html>