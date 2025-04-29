<?php require 'layouts/navbar.php'; ?>
<?php 
$id_user = $_SESSION["id_user"];
$orderTiket = mysqli_query($conn, "SELECT order_tiket.id_order, order_tiket.struk, order_tiket.tanggal_transaksi, order_tiket.status 
FROM order_tiket 
INNER JOIN order_detail ON order_tiket.id_order = order_detail.id_order
INNER JOIN user ON order_detail.id_user = user.id_user 
GROUP BY order_tiket.id_order, order_tiket.struk, order_tiket.tanggal_transaksi, order_tiket.status");
?>

<div class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-xl mt-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">History Pemesanan</h1>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-gray-50 shadow-sm rounded-lg">
            <thead>
                <tr class="bg-blue-700 text-white">
                    <th class="px-6 py-4 text-left">No Order</th>
                    <th class="px-6 py-4 text-left">Struk</th>
                    <th class="px-6 py-4 text-left">Tanggal</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orderTiket as $data) : ?> 
                    <tr class="border-b border-gray-300 hover:bg-gray-100 transition-all">
                        <td class="px-6 py-4 text-gray-700 font-medium"><?= $data["id_order"]; ?></td>
                        <td class="px-6 py-4 text-gray-700"><?= $data["struk"]; ?></td>
                        <td class="px-6 py-4 text-gray-700"><?= date('d M Y', strtotime($data["tanggal_transaksi"])); ?></td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $data["status"] === 'Approved' ? 'bg-green-200 text-green-700' : 'bg-yellow-200 text-yellow-700'; ?>">
                                <?= $data["status"]; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="detailPemesanan.php?id=<?= $data["id_order"]; ?>" class="text-blue-600 hover:text-blue-800 font-medium">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
