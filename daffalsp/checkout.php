<?php require 'layouts/navbar.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
if(!isset($_SESSION["username"])){
    echo "
    <script type='text/javascript'>
        Swal.fire({
            icon: 'warning',
            title: 'Login Required',
            text: 'Silahkan login terlebih dahulu!',
            confirmButtonColor: '#3b82f6',
        }).then(() => {
            window.location = 'index.php';
        });
    </script>
    ";
}
?> 

<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <?php if(empty($_SESSION["cart"])) { ?>
            <div class="text-center bg-white rounded-xl shadow-md p-8">
                <div class="mx-auto h-24 w-24 text-blue-500 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Keranjang Kosong</h1>
                <p class="text-gray-600 mb-6">Belum ada tiket yang kamu pesan</p>
                <a href="jadwal.php" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Cari Tiket
                </a>
            </div>
        <?php } else { ?>
            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-blue-600 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white">Checkout Pemesanan Tiket</h1>
                </div>
                
                <form action="" method="POST" class="p-6 sm:p-8">
                    <!-- Customer Info -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Pemesan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="hidden" name="id_user" value="<?= $_SESSION["id_user"]; ?>">
                                <div class="bg-gray-100 p-3 rounded-lg text-gray-800 font-medium">
                                    <?= $_SESSION["nama_lengkap"]; ?>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">User ID</label>
                                <div class="bg-gray-100 p-3 rounded-lg text-gray-800 font-medium">
                                    <?= $_SESSION["id_user"]; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $grandTotal = 0; ?>
                    <?php foreach($_SESSION["cart"] as $id_tiket => $kuantitas) : ?>
                        <?php 
                        $tiket = query("SELECT * FROM jadwal_penerbangan 
                                        INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                                        INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                                        WHERE id_jadwal = '$id_tiket'")[0]; 
                        $totalHarga = $tiket["harga"] * $kuantitas;
                        $grandTotal += $totalHarga;
                        ?>
                        <input type="hidden" name="id_penerbangan" value="<?= $id_tiket; ?>">
                        <input type="hidden" name="jumlah_tiket" value="<?= $kuantitas; ?>">
                        <input type="hidden" name="total_harga" value="<?= $totalHarga; ?>">
                    <?php endforeach; ?>

                    <!-- Flight Tickets -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Detail Penerbangan</h2>
                        
                        <div class="space-y-4">
                            <?php foreach($_SESSION["cart"] as $id_tiket => $kuantitas) : ?>
                                <?php 
                                $tiket = query("SELECT * FROM jadwal_penerbangan 
                                                INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                                                INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                                                WHERE id_jadwal = '$id_tiket'")[0]; 
                                $totalHarga = $tiket["harga"] * $kuantitas;
                                ?>
                                <div class="border border-gray-200 rounded-lg overflow-hidden">
                                    <div class="p-4 sm:p-6">
                                        <div class="flex flex-col sm:flex-row gap-4">
                                            <div class="flex-shrink-0">
                                                <img src="assets/images/<?= $tiket["logo_maskapai"]; ?>" 
                                                     alt="<?= $tiket["nama_maskapai"]; ?>"
                                                     class="w-20 h-20 object-contain rounded-lg border border-gray-200 p-2"
                                                     onerror="this.src='https://via.placeholder.com/80?text=No+Logo'">
                                            </div>
                                            
                                            <div class="flex-grow">
                                                <div class="flex justify-between items-start">
                                                    <h3 class="text-lg font-bold text-gray-800"><?= $tiket["nama_maskapai"]; ?></h3>
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded"><?= $kuantitas; ?> Tiket</span>
                                                </div>
                                                
                                                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Rute</p>
                                                        <p class="font-medium"><?= $tiket["rute_asal"]; ?> → <?= $tiket["rute_tujuan"]; ?></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500">Tanggal</p>
                                                        <p class="font-medium"><?= date('d M Y', strtotime($tiket["tanggal_pergi"])); ?></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500">Berangkat</p>
                                                        <p class="font-medium"><?= $tiket["waktu_berangkat"]; ?></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500">Tiba</p>
                                                        <p class="font-medium"><?= $tiket["waktu_tiba"]; ?></p>
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-4 flex justify-between items-center">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Harga per Tiket</p>
                                                        <p class="font-medium">Rp <?= number_format($tiket["harga"]); ?></p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-sm text-gray-500">Subtotal</p>
                                                        <p class="text-lg font-bold text-blue-600">Rp <?= number_format($totalHarga); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pembayaran</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Tiket</span>
                                <span class="font-medium"><?= count($_SESSION["cart"]); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Harga</span>
                                <span class="font-medium">Rp <?= number_format($grandTotal); ?></span>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-3">
                                <span class="text-lg font-semibold">Total Pembayaran</span>
                                <span class="text-xl font-bold text-blue-600">Rp <?= number_format($grandTotal); ?></span>
                            </div>
                        </div>
                        
                        <button type="submit" name="checkout" 
                                class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Bayar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</div>

<?php
if (isset($_POST['checkout'])) {
    if (checkout($_POST)) {
        echo "
        <script type='text/javascript'>
            Swal.fire({
                icon: 'success',
                title: 'Pesanan Berhasil!',
                text: 'Pesanan Anda telah berhasil diproses. Anda akan diarahkan ke halaman riwayat pesanan.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location = 'history.php';
            });
        </script>";
    } else {    
        echo "
        <script type='text/javascript'>
            Swal.fire({
                icon: 'error',
                title: 'Gagal Checkout',
                text: 'Terjadi kesalahan saat memproses pesanan Anda. Silakan coba lagi.',
                confirmButtonColor: '#3b82f6',
            });
        </script>";
    }
}
?>