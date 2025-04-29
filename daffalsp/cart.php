<?php
session_start(); // WAJIB di paling atas, sebelum apapun
require 'koneksi.php';

// Handle Delete (pakai GET dari tombol konfirmasi)
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_jadwal'])) {
    $id_jadwal = $_GET['id_jadwal'];
    unset($_SESSION['cart'][$id_jadwal]);
    // Flash session agar SweetAlert muncul setelah redirect
    $_SESSION['flash'] = [
        'status' => 'success',
        'pesan' => 'Tiket berhasil dihapus dari keranjang.'
    ];
    header('Location: cart.php');
    exit;
}

// Handle Edit
if (isset($_POST['edit'])) {
    $id_jadwal = $_POST['id_jadwal'];
    $kuantitas = $_POST['kuantitas'];
    $_SESSION['cart'][$id_jadwal] = $kuantitas;
    header('Location: cart.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-semibold">

<?php require 'layouts/navbar.php'; ?>

<div class="container mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">List Pemesanan Tiket</h1>

    <?php if (empty($_SESSION["cart"])): ?>
        <h1 class="text-xl text-center text-gray-600">Belum ada tiket yang kamu pesan!</h1>
    <?php else: ?>
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-2 border-b">No</th>
                        <th class="px-4 py-2 border-b">Nama Maskapai</th>
                        <th class="px-4 py-2 border-b">Rute</th>
                        <th class="px-4 py-2 border-b">Tanggal Berangkat</th>
                        <th class="px-4 py-2 border-b">Waktu Keberangkatan</th>
                        <th class="px-4 py-2 border-b">Harga</th>
                        <th class="px-4 py-2 border-b">Kuantitas</th>
                        <th class="px-4 py-2 border-b">Total Harga</th>
                        <th class="px-4 py-2 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; $grandTotal = 0; ?>
                    <?php foreach ($_SESSION["cart"] as $id_jadwal => $kuantitas): ?>
                        <?php
                        $jadwalPenerbangan = query("SELECT * FROM jadwal_penerbangan 
                            INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                            INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                            WHERE id_jadwal = '$id_jadwal'")[0];

                        $totalHarga = $jadwalPenerbangan["harga"] * $kuantitas;
                        $grandTotal += $totalHarga;
                        ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2"><?= $no++; ?></td>
                            <td class="px-4 py-2"><?= $jadwalPenerbangan["nama_maskapai"]; ?></td>
                            <td class="px-4 py-2"><?= $jadwalPenerbangan["rute_asal"]; ?> - <?= $jadwalPenerbangan["rute_tujuan"]; ?></td>
                            <td class="px-4 py-2"><?= date('d M Y', strtotime($jadwalPenerbangan["tanggal_pergi"])); ?></td>
                            <td class="px-4 py-2"><?= date('H:i', strtotime($jadwalPenerbangan["waktu_berangkat"])); ?> - <?= date('H:i', strtotime($jadwalPenerbangan["waktu_tiba"])); ?></td>
                            <td class="px-4 py-2">Rp <?= number_format($jadwalPenerbangan["harga"]); ?></td>
                            <td class="px-4 py-2">
                                <form action="cart.php" method="POST" class="flex justify-center">
                                    <input type="number" name="kuantitas" value="<?= $kuantitas; ?>" min="1" class="w-20 text-center border p-2 rounded-md" required>
                                    <input type="hidden" name="id_jadwal" value="<?= $id_jadwal; ?>">
                                    <button type="submit" name="edit" class="text-blue-500 hover:underline ml-2">Update</button>
                                </form>
                            </td>
                            <td class="px-4 py-2">Rp <?= number_format($totalHarga); ?></td>
                            <td class="px-4 py-2 text-center">
                                <button onclick="konfirmasiHapus(<?= $id_jadwal; ?>)" class="text-red-500 hover:underline">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="bg-gray-100 font-semibold">
                        <td colspan="8" class="px-4 py-2 text-right">Grand Total</td>
                        <td class="px-4 py-2">Rp <?= number_format($grandTotal); ?></td>
                    </tr>
                    <tr>
                        <td colspan="9" class="px-4 py-2 text-center">
                            <a href="checkout.php" class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">Checkout</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- SweetAlert Hapus -->
<script>
function konfirmasiHapus(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus tiket ini?',
        text: "Tindakan ini tidak bisa dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `cart.php?action=delete&id_jadwal=${id}`;
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
