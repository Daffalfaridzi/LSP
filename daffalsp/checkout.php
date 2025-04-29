<?php require 'layouts/navbar.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
if(!isset($_SESSION["username"])){
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = 'index.php';
    </script>
    ";
}
?> 

<div class="container mx-auto px-4 py-12">
    <?php if(empty($_SESSION["cart"])) { ?>
        <h1 class="text-center text-xl font-bold text-gray-700">Keranjang Kosong, beli tiket dulu yuk!</h1>
    <?php } else { ?>
        <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-xl p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Checkout Pemesanan Tiket</h1>

            <div class="bg-gray-100 p-6 rounded-lg">
                <form action="" method="POST">
                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold">Nama Pemesan</label>
                        <input type="hidden" name="id_user" value="<?= $_SESSION["id_user"]; ?>">
                        <input type="text" value="<?= $_SESSION["nama_lengkap"]; ?>" disabled 
                               class="w-full p-3 border border-gray-300 rounded-lg bg-gray-200 text-gray-700 font-medium">
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

                    <h2 class="text-lg font-semibold text-gray-800 mt-8 mb-4">Tiket yang Dibeli</h2>
                    
                    <div class="space-y-4">
                        <?php foreach($_SESSION["cart"] as $id_tiket => $kuantitas) : ?>
                            <?php 
                            $tiket = query("SELECT * FROM jadwal_penerbangan 
                                            INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
                                            INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
                                            WHERE id_jadwal = '$id_tiket'")[0]; 
                            $totalHarga = $tiket["harga"] * $kuantitas;
                            ?>
                            <div class="flex items-center bg-white p-4 rounded-lg shadow-md">
                                <img src="assets/images/<?= $tiket["logo_maskapai"]; ?>" width="80" class="rounded-md">
                                <div class="ml-4">
                                    <h3 class="font-bold text-gray-800"><?= $tiket["nama_maskapai"]; ?></h3>
                                    <p class="text-sm text-gray-500"><?= $tiket["rute_asal"]; ?> - <?= $tiket["rute_tujuan"]; ?></p>
                                    <p class="text-sm text-gray-500"><?= date('d M Y', strtotime($tiket["tanggal_pergi"])); ?> | <?= $tiket["waktu_berangkat"]; ?> - <?= $tiket["waktu_tiba"]; ?></p>
                                    <p class="text-gray-700 font-medium">Rp <?= number_format($tiket["harga"]); ?> x <?= $kuantitas; ?> tiket</p>
                                    <p class="text-lg font-bold text-blue-600">Rp <?= number_format($totalHarga); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <h2 class="mt-6 text-xl font-semibold text-gray-800">Grand Total</h2>
                    <p class="text-2xl font-bold text-blue-600">Rp <?= number_format($grandTotal); ?></p>

                    <button type="submit" name="checkout" 
                            class="mt-6 w-full py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        Checkout Sekarang
                    </button>
                </form>
            </div>
        </div>
    <?php } ?>
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
        echo mysqli_error($conn);
    }
}
?>

