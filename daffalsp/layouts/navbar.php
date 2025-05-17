<?php
require 'functions.php';
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIKET!NG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white fixed w-full top-0 left-0 z-50 shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <div class="text-xl font-bold">
                    TIKET<span class="text-yellow-400">!NG</span>
                </div>

                <div class="hidden md:flex space-x-5 text-base font-medium">
                    <a href="index.php" class="<?= $current_page == 'index.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Beranda</a>
                    <a href="jadwal.php" class="<?= $current_page == 'jadwal.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Jadwal</a>
                    <a href="cart.php" class="<?= $current_page == 'cart.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Pesanan</a>
                    <a href="history.php" class="<?= $current_page == 'history.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Riwayat</a>
                </div>

                <div class="hidden md:flex space-x-4 items-center relative">
                    <?php if (isset($_SESSION["username"])) { ?>
                        <span class="font-medium">Hallo, <?= $_SESSION["nama_lengkap"]; ?></span>
                        <!-- Profile image with dropdown -->
                        <div class="relative group">
                            <img src="../../daffalsp/assets/images/profile.png" id="profileToggle" class="w-8 h-8 rounded-full cursor-pointer bg-white" alt="">

                    <!-- Dropdown -->
                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-44 bg-white text-gray-800 rounded-lg shadow-lg ring-1 ring-gray-200 transition transform scale-95 origin-top-right z-50">
                        <div class="px-4 py-2 border-b text-sm text-gray-600 text-center"><?= $_SESSION["nama_lengkap"]; ?></div>
                        <button id="logoutBtn" class="w-full text-center px-4 py-2 text-sm font-medium hover:bg-red-50 hover:text-red-600 transition duration-200">
                            🔒 Logout
                        </button>
                    </div>
                        
                    <?php } else { ?>
                        <a href="auth/login/" class="bg-blue-500 px-3 py-1.5 rounded-lg hover:bg-blue-700 transition">Login</a>
                        <a href="auth/register/" class="bg-yellow-400 px-3 py-1.5 rounded-lg text-blue-800 font-semibold hover:bg-yellow-500 transition">Register</a>
                    <?php } ?>
                </div>

                <!-- Hamburger -->
                <button id="menu-toggle" class="md:hidden focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-blue-700 text-white text-center py-4 space-y-3">
            <a href="index.php" class="block <?= $current_page == 'index.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Beranda</a>
            <a href="jadwal.php" class="block <?= $current_page == 'jadwal.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Jadwal</a>
            <a href="cart.php" class="block <?= $current_page == 'cart.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Pesanan</a>
            <a href="history.php" class="block <?= $current_page == 'history.php' ? 'text-yellow-400' : 'hover:text-blue-300 transition' ?>">Riwayat</a>
            <?php if (isset($_SESSION["username"])) { ?>
                <span class="block font-medium">Hallo, <?= $_SESSION["nama_lengkap"]; ?></span>
                <a href="logout.php" class="block bg-red-500 px-4 py-2 rounded-lg mx-auto w-1/2 hover:bg-red-600 transition">Logout</a>
            <?php } else { ?>
                <a href="auth/login/" class="block bg-blue-500 px-4 py-2 rounded-lg mx-auto w-1/2 hover:bg-blue-700 transition">Login</a>
                <a href="auth/register/" class="block bg-yellow-400 px-4 py-2 rounded-lg text-blue-800 font-semibold mx-auto w-1/2 hover:bg-yellow-500 transition">Register</a>
            <?php } ?>
        </div>
    </nav>

    <div class="pt-14">
        <!-- Konten Halaman -->
    </div>

    <!-- JS: Dropdown Toggle & Logout Confirm -->
    <script>
        // Toggle mobile menu
        document.getElementById("menu-toggle").addEventListener("click", function () {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });

        // Toggle profile dropdown
        const profileToggle = document.getElementById("profileToggle");
        const profileDropdown = document.getElementById("profileDropdown");

        profileToggle?.addEventListener("click", function () {
            profileDropdown.classList.toggle("hidden");
        });

        // Confirm logout with SweetAlert2
        const logoutBtn = document.getElementById("logoutBtn");
        logoutBtn?.addEventListener("click", function () {
            Swal.fire({
                title: 'Yakin ingin logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        });

        // Load lucide icons
        lucide.createIcons();
    </script>

</body>
</html>
