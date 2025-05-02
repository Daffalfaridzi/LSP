<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["username"])) {
    echo "
    <script>
        window.location = '../../auth/login/index.php';
    </script>
    ";
    exit;
}

$id = $_GET["id"];

if (hapus($id) > 0) {
    $_SESSION['flash'] = [
        'status' => 'success',
        'pesan' => 'Data kota berhasil dihapus!'
    ];
} else {
    $_SESSION['flash'] = [
        'status' => 'error',
        'pesan' => 'Data kota gagal dihapus.'
    ];
}

header("Location: index.php");
exit;
?>
