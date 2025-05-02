<?php
$page = "Maskapai";

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
        $_SESSION['flash'] = "Data berhasil ditambah!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['flash'] = "Data gagal ditambah.";
        header("Location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Maskapai</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="flex bg-gray-100">
    <?php require '../../layouts/sidebarmaskapai.php'; ?>

    <div class="flex-1 mt-16 p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-10"><span><a href="index.php">DATA MASKAPAI</a></span> > TAMBAH MASKAPAI</h1>

        <form action="" method="POST" enctype="multipart/form-data" class="mt-6 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl mt-2 font-bold text-gray-800 mb-4 text-center">Tambah Pengguna</h1>

            <div class="mb-4">
                <label for="logo_maskapai" class="block text-gray-700 font-semibold mb-2">Logo Maskapai</label>
                <input type="file" name="logo_maskapai" id="logo_maskapai" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="nama_maskapai" class="block text-gray-700 font-semibold mb-2">Nama Maskapai</label>
                <input type="text" name="nama_maskapai" id="nama_maskapai" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" name="tambah" class="mt-5 w-20 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Tambah</button>
            </div>
        </form>
    </div>
</body>
</html>