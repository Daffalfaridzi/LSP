<?php
$page = "Pengguna";
session_start();
require 'functions.php';

if (!isset($_SESSION["username"])) {
    echo "
    <script>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../../auth/login/index.php';
    </script>";
    exit;
}

$id = $_GET["id"];
$pengguna = query("SELECT * FROM user WHERE id_user = $id")[0];

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
    <title>Edit Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex bg-gray-100">
    <?php require '../../layouts/sidebar.php'; ?>

    <div class="flex-1 mt-16 p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-10"><span><a href="index.php">DATA PENGGUNA</a></span> > EDIT PENGGUNA</h1>
    
    <form action="" method="POST" class="mt-6 bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl mt-2 font-bold text-gray-800 mb-4 text-center">Edit Pengguna</h1>
            <input type="hidden" name="id_user" value="<?= $pengguna["id_user"]; ?>">
            
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
                <input type="text" name="username" id="username" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $pengguna["username"]; ?>" required>
            </div>

            <div class="mb-4">
                <label for="nama_lengkap" class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $pengguna["nama_lengkap"]; ?>" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" id="password" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Leave blank to keep current password">
            </div>

            <div class="mb-4">
                <label for="roles" class="block text-gray-700 font-semibold mb-2">Roles</label>
                <select name="roles" id="roles" class="form-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="<?= $pengguna["roles"]; ?>"><?= $pengguna["roles"]; ?></option>
                    <option value="Maskapai">Maskapai</option>
                    <option value="Pelanggan">Pelanggan</option>
                </select>
            </div>

            <div class="flex justify-end">
            <button type="submit" name="edit" class="mt-5 w-20 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Edit</button>
        </div>
        </form>
    </div>
</body>
</html>