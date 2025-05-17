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
require '../../koneksi.php';

// Query jumlah maskapai dari tabel maskapai
$result_maskapai = mysqli_query($conn, "SELECT COUNT(*) as total FROM maskapai");
$data_maskapai = mysqli_fetch_assoc($result_maskapai);
$jumlah_maskapai = $data_maskapai['total'];

// Query jumlah pengguna dari tabel user dengan role = 'penumpang'
$result_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM user WHERE roles = 'Pelanggan'");
$data_user = mysqli_fetch_assoc($result_user);
$jumlah_user = $data_user['total'];

// Query jumlah kota dari tabel kota
$result_kota = mysqli_query($conn, "SELECT COUNT(*) as total FROM kota");
$data_kota = mysqli_fetch_assoc($result_kota);
$jumlah_kota = $data_kota['total'];
?>

<?php require '../../layouts/sidebarmaskapai.php'; ?>

<div class="flex-1 mt-16 p-6">
    <!-- Header Image with overlay text -->
    <div class="relative mb-8">
        <!-- Welcome Text Overlay (Visible only on larger screens) -->
        <h2 class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-4xl font-bold text-white shadow-lg z-10 hidden lg:block">Selamat Datang di <span class="bg-blue-900 px-3 py-2 rounded-xl ml-2">TIKET<span class="text-yellow-500">!NG</span></span></h2>

        <!-- TIKET!NG text overlay (Visible on all screen sizes) -->
        <h2 class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-4xl text-white font-bold shadow-lg z-10 bg-blue-900 px-3 py-2 rounded-xl lg:hidden">TIKET<span class="text-yellow-500">!NG</span></h2>

        <!-- Header Image -->
        <img src="https://wallpapercave.com/wp/wp10448214.jpg" alt="Bandara" class="rounded-3xl w-full h-72 object-cover object-top">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Kartu Jumlah Maskapai -->
    <div class="bg-white shadow-lg rounded-xl p-6 border-l-4 border-blue-500 transition-transform transform hover:scale-105 hover:shadow-2xl flex items-center justify-between">
        <div>
            <h2 class="text-gray-500 text-sm uppercase font-semibold mb-2">Jumlah Maskapai</h2>
            <p class="text-3xl font-bold text-blue-600"><?= $jumlah_maskapai ?></p>
        </div>
        <!-- SVG Icon for Maskapai -->
        <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h18M3 12h18M3 21h18"></path>
        </svg>
    </div>

    <!-- Kartu Jumlah Pengguna -->
    <div class="bg-white shadow-lg rounded-xl p-6 border-l-4 border-green-500 transition-transform transform hover:scale-105 hover:shadow-2xl flex items-center justify-between">
        <div>
            <h2 class="text-gray-500 text-sm uppercase font-semibold mb-2">Jumlah User</h2>
            <p class="text-3xl font-bold text-green-600"><?= $jumlah_user ?></p>
        </div>
        <!-- SVG Icon for User -->
        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405a2.25 2.25 0 00-.293-.208l-1.637-.92a4.992 4.992 0 01-.929-.929l-.92-1.637a2.25 2.25 0 00-.208-.293L17 15m0 2.25V21a2.25 2.25 0 01-2.25 2.25h-6a2.25 2.25 0 01-2.25-2.25v-3.75m5.25-.75v-4.5a5.25 5.25 0 10-10.5 0v4.5"></path>
        </svg>
    </div>

    <!-- Kartu Jumlah Kota -->
    <div class="bg-white shadow-lg rounded-xl p-6 border-l-4 border-yellow-500 transition-transform transform hover:scale-105 hover:shadow-2xl flex items-center justify-between">
        <div>
            <h2 class="text-gray-500 text-sm uppercase font-semibold mb-2">Jumlah Kota</h2>
            <p class="text-3xl font-bold text-yellow-600"><?= $jumlah_kota ?></p>
        </div>
        <!-- SVG Icon for Kota -->
        <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10l4 4-4 4M7 6l4 4-4 4m7 0l4 4-4 4"></path>
        </svg>
    </div>
</div>
