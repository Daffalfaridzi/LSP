<?php require 'layouts/navbar.php'; ?>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Riwayat Pemesanan</h1>
            <p class="text-lg text-gray-600">Semua tiket yang pernah Anda pesan</p>
        </div>

        <?php 
        $id_user = $_SESSION["id_user"];
        $orderTiket = mysqli_query($conn, "SELECT order_tiket.id_order, order_tiket.struk, order_tiket.tanggal_transaksi, order_tiket.status 
        FROM order_tiket 
        INNER JOIN order_detail ON order_tiket.id_order = order_detail.id_order
        INNER JOIN user ON order_detail.id_user = user.id_user 
        WHERE user.id_user = '$id_user'
        GROUP BY order_tiket.id_order, order_tiket.struk, order_tiket.tanggal_transaksi, order_tiket.status
        ORDER BY order_tiket.tanggal_transaksi DESC");
        ?>
        
        <?php if(mysqli_num_rows($orderTiket) > 0): ?>
        <!-- Orders Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="grid grid-cols-12 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4">
                <div class="col-span-3 font-medium">No Order</div>
                <div class="col-span-3 font-medium">Kode Booking</div>
                <div class="col-span-2 font-medium">Tanggal</div>
                <div class="col-span-2 font-medium">Status</div>
                <div class="col-span-2 font-medium text-right">Aksi</div>
            </div>
            
            <!-- Orders List -->
            <div class="divide-y divide-gray-200">
                <?php foreach($orderTiket as $data): ?>
                <div class="grid grid-cols-12 items-center px-6 py-5 hover:bg-gray-50 transition-colors">
                    <div class="col-span-3">
                        <div class="font-medium text-gray-900"><?= $data["id_order"]; ?></div>
                    </div>
                    <div class="col-span-3">
                        <div class="font-mono text-gray-700 bg-gray-100 px-3 py-1 rounded-md inline-block">
                            <?= $data["struk"]; ?>
                        </div>
                    </div>
                    <div class="col-span-2 text-gray-600">
                        <?= date('d M Y', strtotime($data["tanggal_transaksi"])); ?>
                    </div>
                    <div class="col-span-2">
                        <?php 
                        $statusColors = [
                            'Approved' => 'bg-emerald-100 text-emerald-800',
                            'Reject' => 'bg-red-100 text-red-800',
                            'Proses' => 'bg-yellow-100 text-yellow-800'
                        ];
                        ?>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold <?= $statusColors[$data["status"]] ?? 'bg-gray-100 text-gray-800'; ?>">
                            <?= $data["status"]; ?>
                        </span>
                    </div>
                    <div class="col-span-2 text-right">
                        <a href="detailPemesanan.php?id=<?= $data["id_order"]; ?>" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Detail
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">10</span> dari <span class="font-medium"><?= mysqli_num_rows($orderTiket); ?></span> pesanan
                    </div>
                    <div class="flex space-x-1">
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-100 disabled:opacity-50" disabled>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md bg-blue-600 text-white">1</button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">2</button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-500 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden text-center py-16">
            <div class="mx-auto w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Belum ada riwayat pemesanan</h3>
            <p class="text-gray-500 mb-6">Anda belum melakukan pemesanan tiket apapun.</p>
            <a href="jadwal.php" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Pesan Tiket Sekarang
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>