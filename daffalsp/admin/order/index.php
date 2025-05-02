<?php
$page = "Tiket";

session_start();
require 'functions.php';
require '../../koneksi.php'; // Pastikan file koneksi ada

// Cek apakah sudah login
if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../auth/login/index.php';
    </script>
    ";
}

// Ambil keyword dari input pencarian
$keyword = $_GET['keyword'] ?? '';

// Ambil data order tiket dari database dengan filter jika keyword ada
if ($keyword) {
    $orderTiket = query("SELECT * FROM order_tiket WHERE 
        id_order LIKE '%$keyword%' OR 
        struk LIKE '%$keyword%' OR 
        status LIKE '%$keyword%' 
        ORDER BY id_order DESC");
} else {
    $orderTiket = query("SELECT * FROM order_tiket ORDER BY id_order DESC");
}
?>


<?php require '../../layouts/sidebar.php'; ?>

<div class="flex-1 mt-16 p-6">
<h1 class="text-2xl font-bold text-gray-800 mb-10">DATA ORDER</h1>


    <div class="flex justify-end items-center mt-4">
            <form action="" method="GET" class="flex items-center space-x-2">
                <input type="search" name="keyword" placeholder="Cari tiket..." value="<?= htmlspecialchars($keyword); ?>"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 mx-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 font-semibold rounded-lg">Cari</button>
            </form>
        </div>

    <div class="overflow-x-auto mt-6">
        <table class="min-w-full bg-white border border-gray-400 text-center">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="py-2 px-4 border">Nomor Order</th>
                    <th class="py-2 px-4 border">Struk</th>
                    <th class="py-2 px-4 border">Status</th>
                    <th class="py-2 px-4 border">Opsi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (count($orderTiket) > 0): ?>
                <?php foreach ($orderTiket as $data) : ?>
                <tr class="hover:bg-gray-100">
                    <td class="py-2 px-4 border"><?= $data["id_order"]; ?></td>
                    <td class="py-2 px-4 border"><?= $data["struk"]; ?></td>
                    <td class="py-2 px-4 border">
    <!-- Status dengan warna hijau jika Approved -->
    <span class="text-sm font-bold <?= 
        $data["status"] === 'Approved' ? 'bg-green-200 px-3 py-1 rounded-full text-green-600' : 
        ($data["status"] === 'Proses' ? 'bg-yellow-200 px-3 py-1 rounded-full text-yellow-600' : 
        ($data["status"] === 'Reject' ? 'bg-red-200 px-3 py-1 rounded-full text-red-600' : 'text-gray-600')) ?>">
        <?= $data["status"]; ?>
    </span>
                    </td>
                    <td class="py-2 px-4 border">
                    <a href="verif.php?id=<?= $data["id_order"]; ?>" class="text-blue-600 hover:underline" onClick="return confirm('Apakah anda yakin ingin memverifikasi data ini?')">Verifikasi</a>
                    <a href="reject.php?id=<?= $data["id_order"]; ?>" class="text-red-600 mx-2 hover:underline" onClick="return confirm('Apakah anda yakin ingin Mereject data ini?')">Reject</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                        <tr>
                            <td colspan="3" class="py-4 text-gray-500 italic">Data tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

    <?php if (isset($_SESSION['flash'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: '<?= $_SESSION['flash']['status']; ?>',
    title: '<?= $_SESSION['flash']['status'] === 'success' ? 'Berhasil!' : 'Gagal!'; ?>',
    text: '<?= $_SESSION['flash']['pesan']; ?>',
    showConfirmButton: false,
    timer: 2000
});
</script>
<?php unset($_SESSION['flash']); ?>
<?php endif; ?>
