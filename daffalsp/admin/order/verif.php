<?php
require '../../koneksi.php';
session_start(); // WAJIB: karena kita pakai $_SESSION

$id_order = $_GET['id'];

// Validasi ID
if ($id_order) {
    $query = "UPDATE order_tiket SET status = 'Approved' WHERE id_order = '$id_order'";
    $result = mysqli_query($conn, $query);

    // Simpan ke session untuk SweetAlert di index.php
    $_SESSION['flash'] = [
        'status' => $result ? 'success' : 'error',
        'pesan' => $result ? 'Berhasil diverifikasi!' : 'Gagal memverifikasi.'
    ];

    // Redirect ke halaman utama order
    header("Location: index.php");
    exit;
}
?>
