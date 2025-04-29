<?php
$page = "Dashboard";
session_start();

if(!isset($_SESSION["username"])){
    echo "
    <script type='text/javascript'>
    alert('Silahkan login terlebih dahulu');
    window.location ='../auth/login/';
    </script>
    ";
}

// Koneksi database
require '../koneksi.php';

// Query jumlah maskapai dari tabel maskapai
$result_maskapai = mysqli_query($conn, "SELECT COUNT(*) as total FROM maskapai");
$data_maskapai = mysqli_fetch_assoc($result_maskapai);
$jumlah_maskapai = $data_maskapai['total'];

// Query jumlah pengguna dari tabel user dengan role = 'penumpang'
$result_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM user WHERE roles = 'penumpang'");
$data_user = mysqli_fetch_assoc($result_user);
$jumlah_user = $data_user['total'];

// Query jumlah kota dari tabel kota
$result_kota = mysqli_query($conn, "SELECT COUNT(*) as total FROM kota");
$data_kota = mysqli_fetch_assoc($result_kota);
$jumlah_kota = $data_kota['total'];
?>

<?php require '../layouts/sidebar.php'; ?>

<div class="flex-1 mt-16 p-6">
<div class="relative mb-8">
    <!-- Welcome Text Overlay (Visible only on larger screens) -->
    <h2 class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-4xl font-bold text-white shadow-lg z-10 hidden lg:block">Selamat Datang di <span class="bg-blue-900 px-3 py-2 rounded-xl ml-2">TIKET<span class="text-yellow-500">!NG</span></span></h2>

    <!-- TIKET!NG text overlay (Visible on all screen sizes) -->
    <h2 class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-4xl text-white font-bold shadow-lg z-10 bg-blue-900 px-3 py-2 rounded-xl lg:hidden">TIKET<span class="text-yellow-500">!NG</span></h2>

    <!-- Header Image -->
    <img src="https://wallpapercave.com/wp/wp10448214.jpg" alt="Bandara" class=" rounded-3xl w-full h-72 object-cover">
</div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kartu Jumlah Maskapai -->
        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-blue-500">
            <h2 class="text-gray-500 text-sm uppercase font-semibold mb-2">Jumlah Maskapai</h2>
            <p class="text-3xl font-bold text-blue-600"><?= $jumlah_maskapai ?></p>
        </div>

        <!-- Kartu Jumlah Pengguna -->
        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-green-500">
            <h2 class="text-gray-500 text-sm uppercase font-semibold mb-2">Jumlah User</h2>
            <p class="text-3xl font-bold text-green-600"><?= $jumlah_user ?></p>
        </div>

        <!-- Kartu Jumlah Kota -->
        <div class="bg-white shadow-md rounded-xl p-6 border-l-4 border-yellow-500">
            <h2 class="text-gray-500 text-sm uppercase font-semibold mb-2">Jumlah Kota</h2>
            <p class="text-3xl font-bold text-yellow-600"><?= $jumlah_kota ?></p>
        </div>
    </div>


