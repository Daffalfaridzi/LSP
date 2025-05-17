<?php
session_start();
require 'functions.php';
require '../../koneksi.php';

if (!isset($_SESSION["username"])) {
    header("Location: ../auth/login/index.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['flash'] = [
        'status' => 'error',
        'pesan' => 'ID Order tidak valid!'
    ];
    header("Location: index.php");
    exit;
}

$id_order = $_GET['id'];

// Cek status order dulu
$cek_order = mysqli_query($conn, "SELECT status FROM order_tiket WHERE id_order = '$id_order'");
if (!$cek_order || mysqli_num_rows($cek_order) === 0) {
    $_SESSION['flash'] = [
        'status' => 'error',
        'pesan' => 'Order tidak ditemukan!'
    ];
    header("Location: index.php");
    exit;
}

$order = mysqli_fetch_assoc($cek_order);

// Hindari reject ganda atau setelah approved
if ($order['status'] === 'Reject') {
    $_SESSION['flash'] = [
        'status' => 'warning',
        'pesan' => 'Order sudah direject sebelumnya.'
    ];
    header("Location: index.php");
    exit;
}
if ($order['status'] === 'Approved') {
    $_SESSION['flash'] = [
        'status' => 'warning',
        'pesan' => 'Order sudah disetujui, tidak bisa direject.'
    ];
    header("Location: index.php");
    exit;
}

// Ambil data dari order_detail
$detail_query = mysqli_query($conn, "SELECT id_penerbangan, jumlah_tiket FROM order_detail WHERE id_order = '$id_order'");
if (!$detail_query || mysqli_num_rows($detail_query) === 0) {
    $_SESSION['flash'] = [
        'status' => 'error',
        'pesan' => 'Detail order tidak ditemukan!'
    ];
    header("Location: index.php");
    exit;
}

// Kembalikan kursi ke jadwal_penerbangan
while ($row = mysqli_fetch_assoc($detail_query)) {
    $id_jadwal = $row['id_penerbangan']; // ini sebenarnya id_jadwal
    $jumlah_tiket = $row['jumlah_tiket'];

    $update_kursi = mysqli_query($conn, "UPDATE jadwal_penerbangan SET kapasitas_kursi = kapasitas_kursi + $jumlah_tiket WHERE id_jadwal = '$id_jadwal'");
    
    if (!$update_kursi) {
        $_SESSION['flash'] = [
            'status' => 'error',
            'pesan' => 'Gagal mengembalikan kapasitas kursi: ' . mysqli_error($conn)
        ];
        header("Location: index.php");
        exit;
    }
}

// Update status jadi Reject
$update_status = mysqli_query($conn, "UPDATE order_tiket SET status = 'Reject' WHERE id_order = '$id_order'");

$_SESSION['flash'] = [
    'status' => $update_status ? 'success' : 'error',
    'pesan' => $update_status ? 'Order berhasil direject dan kapasitas kursi dikembalikan.' : 'Gagal mengubah status order.'
];

header("Location: index.php");
exit;
?>
