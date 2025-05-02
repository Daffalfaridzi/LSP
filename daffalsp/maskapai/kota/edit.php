<?php
$page = "Kota";
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
$kota = query("SELECT * FROM kota WHERE id_kota = '$id'")[0];

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
    <title>Edit Kota</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-100">
    <?php require '../../layouts/sidebarmaskapai.php'; ?>

    <div class="flex-1 mt-16 p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-10"><span><a href="index.php">DATA KOTA</a></span> > EDIT KOTA</h1>


        <form action="" method="POST" class="mt-6 bg-white p-6 rounded-lg shadow-md">
            <input type="hidden" name="id_kota" value="<?= $kota["id_kota"]; ?>">
            
            <div class="mb-4">
                <label for="nama_kota" class="block text-gray-700 font-semibold mb-2">Nama Kota</label>
                <input type="text" name="nama_kota" id="nama_kota" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $kota["nama_kota"]; ?>" required>
            </div>

            <div class="flex justify-end">
            <button type="submit" name="edit" class="mt-5 w-20 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Edit</button>
        </div>
        </form>
    </div>
</body>
</html>