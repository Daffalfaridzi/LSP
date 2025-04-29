<?php
$page = "Jadwal";

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

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$keyword = $_GET['keyword'] ?? '';

if ($keyword) {
    $jadwal = query("SELECT * FROM jadwal_penerbangan 
        INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
        INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
        WHERE 
            nama_maskapai LIKE '%$keyword%' OR 
            rute_asal LIKE '%$keyword%' OR 
            rute_tujuan LIKE '%$keyword%' 
        ORDER BY tanggal_pergi, waktu_berangkat");
} else {
    $jadwal = query("SELECT * FROM jadwal_penerbangan 
        INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
        INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
        ORDER BY tanggal_pergi, waktu_berangkat");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Data Jadwal Penerbangan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="flex bg-gray-100">
    <?php require '../../layouts/sidebar.php'; ?>

    <div class="flex-1 mt-16 p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-10">DATA JADWAL PENERBANGAN</h1>

        <div class="flex justify-between items-center mt-4">
            <a href="tambah.php" class="bg-blue-600 font-semibold text-white px-4 py-2 rounded-lg hover:bg-blue-700">Tambah</a>

            <form action="" method="GET" class="flex items-center space-x-2">
                <input type="search" name="keyword" placeholder="Cari jadwal..." value="<?= htmlspecialchars($keyword); ?>"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 font-semibold rounded-lg">Cari</button>
            </form>
        </div>
        <div class="overflow-x-auto mt-6 text-center">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="py-2 px-4 border">No</th>
                        <th class="py-2 px-4 border">Nama Maskapai</th>
                        <th class="py-2 px-4 border">Kapasitas</th>
                        <th class="py-2 px-4 border">Rute Asal</th>
                        <th class="py-2 px-4 border">Rute Tujuan</th>
                        <th class="py-2 px-4 border">Tanggal Pergi</th>
                        <th class="py-2 px-4 border">Waktu Berangkat</th>
                        <th class="py-2 px-4 border">Waktu Tiba</th>
                        <th class="py-2 px-4 border">Harga</th>
                        <th class="py-2 px-4 border min-w-[120px]">Aksi</th> <!-- Adjusted to allow space for buttons -->
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($jadwal as $data) : ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border"><?= $no; ?></td>
                        <td class="py-2 px-4 border"><?= $data["nama_maskapai"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["kapasitas_kursi"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["rute_asal"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["rute_tujuan"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["tanggal_pergi"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["waktu_berangkat"]; ?></td>
                        <td class="py-2 px-4 border"><?= $data["waktu_tiba"]; ?></td>
                        <td class="py-2 px-4 border">Rp <?= number_format($data["harga"]); ?></td>
                        <td class="py-2 px-4 border flex justify-center space-x-1"> <!-- Flexbox for spacing -->
                        <a href="edit.php?id=<?= $data["id_jadwal"]; ?>" class="text-white hover:underline mr-3 bg-blue-500 px-3 py-1 rounded-lg">Edit</a>
                        <button onclick="konfirmasiHapus(<?= $data['id_jadwal']; ?>)" class="text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                    <?php $no++; ?>
                    <?php endforeach; ?>
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
    <!-- SweetAlert confirmation -->
    <script>
        <?php if ($flash): ?>
        Swal.fire({
            icon: '<?= $flash['status']; ?>',
            title: '<?= $flash['status'] === 'success' ? 'Berhasil!' : 'Gagal!'; ?>',
            text: '<?= $flash['pesan']; ?>',
            showConfirmButton: false,
            timer: 2000
        });
        <?php endif; ?>
    </script>

</body>
</html>

