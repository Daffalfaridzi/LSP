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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->
    <title>Dashboard Admin</title>
</head>
<body class="flex bg-gray-100">

    
  <!-- Fixed Top Navbar -->
  <header class="fixed top-0 left-0 right-0 bg-white shadow-md px-6 py-4 flex items-center justify-end z-50">
    <div class="flex space-x-4">
      <button class="md:hidden block text-gray-700">☰</button>
      <span class="font-semibold text-md mt-1">Hallo, <?= $_SESSION["nama_lengkap"]; ?>👋</span>
      <img src="../../assets/images/user.png" class="w-8 h-8 rounded-full" alt="">
    </div>
  </header>

    <!-- Sidebar -->
    <div class="bg-blue-600 shadow-md fixed top-0 left-0 h-screen w-64 p-4 text-white z-50 flex flex-col justify-between">
        <div>
            <div class="text-3xl mt-4 font-bold mb-10 text-center">TIKET<span class="text-yellow-400">!NG</span></div>
            <nav class="font-semibold space-y-2">
                <a href="/daffalsp/admin/index.php" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == "Dashboard") echo "bg-blue-700 text-white" ?>">Dashboard</a>
                <a href="/daffalsp/admin/pengguna/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == "Pengguna") echo "bg-blue-700 text-white" ?>">Data Pengguna</a>
                <a href="/daffalsp/admin/maskapai/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == "Maskapai") echo "bg-blue-700 text-white" ?>">Data Maskapai</a>
                <a href="/daffalsp/admin/kota/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == "Kota") echo "bg-blue-700 text-white" ?>">Data Kota</a>
                <a href="/daffalsp/admin/rute/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == "Rute") echo "bg-blue-700 text-white" ?>">Data Rute</a>
                <a href="/daffalsp/admin/jadwal/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == "Jadwal") echo "bg-blue-700 text-white" ?>">Data Jadwal Penerbangan</a>
                <a href="/daffalsp/admin/order/" class="block py-2 px-4 rounded-xl hover:bg-blue-500 hover:text-white <?php if($page == "Tiket") echo "bg-blue-700 text-white" ?>">Pemesanan Tiket</a>
            </nav>
        </div>
        <div>
            <a href="/daffalsp/logout.php" class="block bg-blue-500 text-center py-2 px-4 rounded-xl hover:bg-red-500 hover:text-white font-semibold" onClick="return confirm('Apakah anda yakin ingin logout?')">Logout</a>
        </div>
    </div>

    <!-- Content Area -->
    <div class="ml-52 p-6">
        <!-- Konten Anda di sini -->
    </div>
</body>
</html>
