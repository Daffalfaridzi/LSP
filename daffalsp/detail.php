<?php require 'layouts/navbar.php'; ?>
<?php 
$id = $_GET["id"];
$jadwalPenerbangan = query("SELECT * FROM jadwal_penerbangan 
INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai WHERE id_jadwal = '$id'")[0];
?>

<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                Detail Penerbangan
            </h1>
            <p class="mt-3 text-xl text-gray-500">
                Detail lengkap penerbangan Anda
            </p>
        </div>

        <!-- Flight Detail Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="md:flex">
                <!-- Airline Logo Section -->
                <div class="md:w-1/3 bg-gradient-to-br from-blue-50 to-indigo-100 p-8 flex items-center justify-center">
                    <img 
                        src="assets/images/<?= $jadwalPenerbangan["logo_maskapai"]; ?>" 
                        alt="<?= $jadwalPenerbangan["nama_maskapai"]; ?>"
                        class="w-64 h-64 object-contain"
                        onerror="this.src='https://via.placeholder.com/256?text=No+Logo'"
                    >
                </div>

                <!-- Flight Details Section -->
                <div class="md:w-2/3 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">
                        <?= $jadwalPenerbangan["nama_maskapai"]; ?>
                    </h2>

                    <!-- Flight Route -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="text-center">
                            <div class="text-sm font-medium text-gray-500">Keberangkatan</div>
                            <div class="text-xl font-semibold text-gray-800 mt-1"><?= $jadwalPenerbangan["rute_asal"]; ?></div>
                        </div>
                        <div class="px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                        <div class="text-center">
                            <div class="text-sm font-medium text-gray-500">Tujuan</div>
                            <div class="text-xl font-semibold text-gray-800 mt-1"><?= $jadwalPenerbangan["rute_tujuan"]; ?></div>
                        </div>
                    </div>

                    <!-- Flight Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-gray-500">Tanggal Pergi</div>
                            <div class="text-lg font-semibold text-gray-800 mt-1">
                                <?= date('l, d F Y', strtotime($jadwalPenerbangan["tanggal_pergi"])); ?>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-gray-500">Waktu</div>
                            <div class="text-lg font-semibold text-gray-800 mt-1">
                                <?= date('H:i', strtotime($jadwalPenerbangan["waktu_berangkat"])); ?> - <?= date('H:i', strtotime($jadwalPenerbangan["waktu_tiba"])); ?>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-gray-500">Durasi</div>
                            <div class="text-lg font-semibold text-gray-800 mt-1">
                                <?php
                                $berangkat = new DateTime($jadwalPenerbangan["waktu_berangkat"]);
                                $tiba = new DateTime($jadwalPenerbangan["waktu_tiba"]);
                                $durasi = $berangkat->diff($tiba);
                                echo $durasi->format('%h jam %i menit');
                                ?>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-gray-500">Kursi Tersedia</div>
                            <div class="text-lg font-semibold text-gray-800 mt-1">
                                <?= $jadwalPenerbangan["kapasitas_kursi"]; ?> kursi
                            </div>
                        </div>
                    </div>

                    <!-- Price and Booking Form -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="mb-4 md:mb-0">
                                <div class="text-sm font-medium text-gray-500">Harga per tiket</div>
                                <div class="text-2xl font-bold text-blue-600">
                                    Rp <?= number_format($jadwalPenerbangan["harga"], 0, ',', '.'); ?>
                                </div>
                            </div>

                            <form action="" method="POST" class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">
                                <div class="flex items-center">
                                    <label for="qty" class="mr-3 text-sm font-medium text-gray-700">Jumlah Tiket:</label>
                                    <input 
                                        type="number" 
                                        name="qty" 
                                        value="1" 
                                        min="1" 
                                        max="<?= $jadwalPenerbangan["kapasitas_kursi"]; ?>" 
                                        class="w-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-700"
                                    >
                                </div>
                                <button 
                                    type="submit" 
                                    name="pesan" 
                                    class="w-full sm:w-auto px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_POST["pesan"])){
    if($_POST["qty"] > $jadwalPenerbangan["kapasitas_kursi"]){
        echo "
            <script type='text/javascript'>
                alert('Mohon maaf kuantitas yang kamu pesan melebihi kuantitas yang tersedia!');
                window.location = 'index.php';
            </script>
        ";
    }else if($_POST["qty"] <= 0){
        echo "
            <script type='text/javascript'>
                alert('Beli setidaknya 1 tiket, ya!');
                window.location = 'index.php';
            </script>
        ";
    }else{
        $qty = $_POST["qty"];
        $_SESSION["cart"][$id] = $qty;
        echo "
            <script type='text/javascript'>
                window.location = 'cart.php';
            </script>
        ";    
    }
}
?>
