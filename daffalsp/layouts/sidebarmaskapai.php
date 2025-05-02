<?php
if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
    alert('Silahkan login terlebih dahulu');
    window.location ='../auth/login/';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
    <title>Dashboard Admin</title>
</head>
<body class="flex bg-gray-100">

<!-- Fixed Top Navbar -->
<header class="fixed top-0 left-0 right-0 bg-white shadow-md px-6 py-4 flex items-center justify-end z-50">
    <div class="flex items-center space-x-4 mx-3">
        <!-- Hamburger Menu (Mobile) -->
        <button class="md:hidden block text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <span class="font-semibold text-gray-700 text-md mt-1">Hallo Maskapai, <?= $_SESSION["nama_lengkap"]; ?>👋</span>
    </div>
    <img src="../../assets/images/user.png" class="w-8 h-8 rounded-full" alt="User Profile">
</header>

<!-- Sidebar -->
<div class="bg-blue-600 shadow-md fixed top-0 left-0 h-screen w-64 p-4 text-white z-50 flex flex-col justify-between">
    <div>
        <div class="text-3xl mt-4 font-bold mb-10 text-center">TIKET<span class="text-yellow-400">!NG</span></div>
        <nav class="font-semibold space-y-2">
            <a href="/daffalsp/maskapai/dashboard/index.php" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == 'Dashboard') echo 'bg-blue-700 text-white' ?>">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l4 4-4 4M7 6l4 4-4 4m7 0l4 4-4 4"></path>
                </svg>
                Dashboard
            </a>
            <a href="/daffalsp/maskapai/pengguna/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == 'Pengguna') echo 'bg-blue-700 text-white' ?>">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405a2.25 2.25 0 00-.293-.208l-1.637-.92a4.992 4.992 0 01-.929-.929l-.92-1.637a2.25 2.25 0 00-.208-.293L17 15m0 2.25V21a2.25 2.25 0 01-2.25 2.25h-6a2.25 2.25 0 01-2.25-2.25v-3.75m5.25-.75v-4.5a5.25 5.25 0 10-10.5 0v4.5"></path>
                </svg>
                Data Pengguna
            </a>
            <a href="/daffalsp/maskapai/maskapai/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == 'Maskapai') echo 'bg-blue-700 text-white' ?>">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l4 4-4 4M7 6l4 4-4 4m7 0l4 4-4 4"></path>
                </svg>
                Data Maskapai
            </a>
            <a href="/daffalsp/maskapai/kota/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == 'Kota') echo 'bg-blue-700 text-white' ?>">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6l8 4 8-4"></path>
                </svg>
                Data Kota
            </a>
            <a href="/daffalsp/maskapai/rute/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == 'Rute') echo 'bg-blue-700 text-white' ?>">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                </svg>
                Data Rute
            </a>
            <a href="/daffalsp/maskapai/jadwal/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == 'Jadwal') echo 'bg-blue-700 text-white' ?>">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5 5 5-5z"></path>
                </svg>
                Data Jadwal
            </a>
            <a href="/daffalsp/maskapai/order/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == 'Tiket') echo 'bg-blue-700 text-white' ?>">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h3v3h-3z"></path>
                </svg>
                Data Transaksi
            </a>
        </nav>
    </div>
    <div>
        <!-- Logout Button with SVG Icon -->
        <button id="logoutBtn" class="block w-full bg-blue-500 text-center py-2 px-4 rounded-xl hover:bg-red-500 hover:text-white font-semibold mt-4">
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3"></path>
            </svg>
            Logout
        </button>
    </div>
</div>

<!-- Content Area -->
<div class="ml-52 p-6">
    <!-- Konten Anda di sini -->
</div>

<!-- SweetAlert2 Script -->
<script>
document.getElementById("logoutBtn").addEventListener("click", function() {
    Swal.fire({
        title: 'Apakah Anda yakin ingin logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/daffalsp/logout.php";
        }
    });
});
</script>

</body>
</html>
