<?php require 'layouts/navbar.php'; ?>
<?php 

$jadwalPenerbangan = query("SELECT jadwal_penerbangan.*, rute.*, maskapai.*, jadwal_penerbangan.kapasitas_kursi 
FROM jadwal_penerbangan 
INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
ORDER BY tanggal_pergi, waktu_berangkat");
?>

<div class="list-tiket-pesawat py-12 px-4 bg-gray-50">
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Jadwal Penerbangan - E Ticketing</h1>
    
    <!-- Form Pencarian -->
    <form action="" method="POST" class="mb-8 text-center">
        <input type="text" name="cariJadwal" placeholder="Cari jadwal penerbangan" class="p-3 border border-gray-300 rounded-md text-gray-700 w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" name="cari" class="ml-2 px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300">Search</button>
    </form>

    <!-- Grid Jadwal Penerbangan -->
    <div class="wrapper-tiket-pesawat grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php foreach($jadwalPenerbangan as $data) : ?>
        <div class="card-tiket-pesawat bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
            <a href="detail.php?id=<?= $data["id_jadwal"]; ?>" class="block text-decoration-none">
                <!-- Logo Maskapai -->
                <div class="image p-4">
                    <img src="assets/images/<?= $data["logo_maskapai"]; ?>" class="mx-auto w-32 h-32 object-contain" alt="Logo Maskapai">
                </div>

                
                <!-- Nama Maskapai -->
                <div class="nama-maskapai text-xl font-semibold text-center text-gray-800 py-2"><?= $data["nama_maskapai"]; ?></div>
                
                <!-- Waktu Berangkat & Tiba -->
                <div class="waktu-berangkat text-sm text-center text-gray-600 py-1">Berangkat: <span class="font-semibold"><?= date('H:i', strtotime($data["waktu_berangkat"])); ?></span></div>
                <div class="waktu-tiba text-sm text-center text-gray-600 py-1">Tiba: <span class="font-semibold"><?= date('H:i', strtotime($data["waktu_tiba"])); ?></span></div>
                
                <!-- Rute Penerbangan -->
                <div class="rute-penerbangan text-sm text-center text-gray-600 py-1">Rute: <span class="font-semibold"><?= $data["rute_asal"] ?> → <?= $data["rute_tujuan"]; ?></span></div>
                
                <!-- Kapasitas Kursi -->
                <div class="kapasitas_kursi text-sm text-center text-gray-600 py-1">Kapasitas: <span class="font-semibold"><?= $data["kapasitas_kursi"]; ?> Kursi</span></div>
                
                <!-- Tanggal Berangkat -->
                <div class="tanggal-berangkat text-sm text-center text-gray-600 py-1">Tanggal: <span class="font-semibold"><?= date('d M Y', strtotime($data["tanggal_pergi"])); ?></span></div>
                
                <!-- Harga -->
                <div class="text-harga text-lg font-semibold text-center text-blue-600 py-2">Rp <span class="font-bold"><?= number_format($data["harga"], 0, ',', '.'); ?></span></div>
            </a>
        </div>
    <?php endforeach; ?>
    </div>
</div>
