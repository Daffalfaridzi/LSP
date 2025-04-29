<?php    
    $page = "dashboard";
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Petugas</title>
</head>
<body>
    <?php require '../layouts/sidebarpetugas.php'; ?>

    <div class="flex-1 p-6">
    <h1 class="text-2xl font-bold text-gray-800">Halo, <?= $_SESSION["nama_lengkap"]; ?>!</h1>
    </div>
</body>
</html>