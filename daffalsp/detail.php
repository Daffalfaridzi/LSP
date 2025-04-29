<?php require 'layouts/navbar.php'; ?>
<?php 

$id = $_GET["id"];

$jadwalPenerbangan = query("SELECT * FROM jadwal_penerbangan 
INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai WHERE id_jadwal = '$id'")[0];
?>


<div class="list-tiket-pesawat py-10">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Jadwal Penerbangan - TIKET!NG</h1>
    <div class="wrapper-detail-tiket-pesawat max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <!-- Flex container to align image and text side by side -->
        <div class="flex items-center space-x-6">
            <!-- Left side: Logo Maskapai -->
            <div class="logo-maskapai w-1/3">
                <img src="assets/images/<?= $jadwalPenerbangan["logo_maskapai"]; ?>" alt="Logo Maskapai" class="w-full h-auto">
            </div>
            <!-- Right side: Flight details -->
            <div class="flex-1">
                <div class="nama-maskapai text-xl font-semibold text-gray-800 mb-2">Nama Maskapai: <span class="font-normal"><?= $jadwalPenerbangan["nama_maskapai"]; ?></span></div>
                <div class="rute-asal text-lg text-gray-700 mb-2">Rute Asal: <span class="font-normal"><?= $jadwalPenerbangan["rute_asal"]; ?></span></div>
                <div class="rute-tujuan text-lg text-gray-700 mb-2">Rute Tujuan: <span class="font-normal"><?= $jadwalPenerbangan["rute_tujuan"]; ?></span></div>
                <div class="tanggal-berangkat text-lg text-gray-700 mb-2">Tanggal Pergi: <span class="font-normal"><?= $jadwalPenerbangan["tanggal_pergi"]; ?></span></div>
                <div class="waktu-berangkat text-lg text-gray-700 mb-2">Waktu Berangkat: <span class="font-normal"><?= $jadwalPenerbangan["waktu_berangkat"]; ?></span></div>
                <div class="waktu-tiba text-lg text-gray-700 mb-2">Waktu Tiba: <span class="font-normal"><?= $jadwalPenerbangan["waktu_tiba"]; ?></span></div>
                <div class="harga-tiket text-lg font-semibold text-gray-800 mb-4">Harga: <span class="font-normal text-green-500">Rp <?= number_format($jadwalPenerbangan["harga"]); ?></span></div>
                <div class="kapasitas text-lg text-gray-700 mb-4">Kursi tersedia: <span class="font-normal"><?= $jadwalPenerbangan["kapasitas_kursi"]; ?></span></div>

                <form action="" method="POST" class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <label for="qty" class="text-lg text-gray-700">Jumlah Tiket:</label>
                        <input type="number" name="qty" value="1" min="1" max="<?= $jadwalPenerbangan["kapasitas_kursi"]; ?>" class="px-4 py-2 border border-gray-300 rounded-lg w-24 text-gray-800">
                    </div>
                    <button type="submit" name="pesan" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Pesan</button>
                </form>
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

