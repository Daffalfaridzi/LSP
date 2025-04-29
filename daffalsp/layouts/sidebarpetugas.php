<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Dashboard Petugas</title>
</head>
<body class="flex">
    <!-- Sidebar -->
    <div class="bg-blue-600 shadow-md h-screen w-64 p-4 text-white">
        <div class="text-2xl font-bold mb-4">TIKET<span class="text-yellow-400">!NG</span></div>
        <nav class="font-semibold">
            <a href="/daffalsp/petugas/index.php" class="mb-2 block py-2 px-4 rounded hover:bg-blue-500 hover:text-white <?php if($page == "dashboard") echo "bg-blue-700 text-white" ?>">Dashboard</a>
            <a href="/daffalsp/petugas/jadwal/" class="mb-2 block py-2 px-4 rounded hover:bg-blue-500 hover:text-white <?php if($page == "Jadwal") echo "bg-blue-700 text-white" ?>">Data Jadwal Penerbangan</a>
            <a href="/daffalsp/petugas/order/" class="mb-2 block py-2 px-4 rounded hover:bg-blue-500 hover:text-white <?php if($page == "Tiket") echo "bg-blue-700 text-white" ?>">Pemesanan Tiket</a>
            <a href="/daffalsp/logout.php" class="block py-2 px-4 rounded hover:bg-red-500 hover:text-white" onClick="return confirm('Apakah anda yakin ingin logout?')">Logout</a>
        </nav>
    </div>
</body>
</html>
