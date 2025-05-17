<?php
$page = "Pengguna";
session_start();
require 'functions.php';

if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../../auth/login/index.php';
    </script>
    ";
}

$keyword = $_GET['keyword'] ?? '';
if ($keyword) {
    $pengguna = query("SELECT * FROM user WHERE (roles = 'Maskapai' OR roles = 'Pelanggan') AND (username LIKE '%$keyword%' OR nama_lengkap LIKE '%$keyword%')");
} else {
    $pengguna = query("SELECT * FROM user WHERE roles = 'Maskapai' OR roles = 'Pelanggan'");
}


$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="flex bg-gray-100">
    <?php require '../../layouts/sidebar.php'; ?>

    <div class="flex-1 mt-16 p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-10">DATA PENGGUNA</h1>

        <div class="flex justify-between items-center mt-4">
            <a href="tambah.php" class="bg-blue-600 font-semibold text-white px-4 py-2 rounded-lg hover:bg-blue-700">Tambah</a>

            <form action="" method="GET" class="flex items-center space-x-2">
                <input type="search" name="keyword" placeholder="Cari pengguna..." value="<?= htmlspecialchars($keyword); ?>"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 font-semibold rounded-lg">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full bg-white border border-gray-400 text-center">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="py-2 px-4 border">No</th>
                        <th class="py-2 px-4 border">Username</th>
                        <th class="py-2 px-4 border">Nama Lengkap</th>
                        <th class="py-2 px-4 border">Roles</th>
                        <th class="py-2 px-4 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pengguna) > 0): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($pengguna as $data) : ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border"><?= $no++; ?></td>
                            <td class="py-2 px-4 border"><?= $data["username"]; ?></td>
                            <td class="py-2 px-4 border"><?= $data["nama_lengkap"]; ?></td>
                            <td class="py-2 px-4 border"><?= $data["roles"]; ?></td>
                            <td class="py-2 px-4 border">
                                <a href="edit.php?id=<?= $data["id_user"]; ?>" class="text-white hover:underline mr-3 bg-blue-500 px-3 py-1 rounded-lg">Edit</a>
                                <button onclick="konfirmasiHapus(<?= $data['id_user']; ?>)" class="text-red-600 hover:underline">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-4 text-gray-500 italic">Data tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `hapus.php?id=${id}`;
                }
            });
        }
    </script>
    <?php if ($flash): ?>
<script>
    Swal.fire({
        icon: '<?= $flash['status']; ?>',
        title: '<?= $flash['status'] === 'success' ? 'Berhasil!' : 'Gagal!'; ?>',
        text: '<?= $flash['pesan']; ?>',
        showConfirmButton: false,
        timer: 2000
    });
</script>
<?php endif; ?>

</body>
</html>
