<?php 
require 'layouts/navbar.php';

// Initialize search variables
$searchTerm = '';
$filteredResults = [];

// Check if search form was submitted
if(isset($_POST['cari'])) {
    $searchTerm = $_POST['cariJadwal'];
    
    // Query with search filter
    $filteredResults = query("
        SELECT jadwal_penerbangan.*, rute.*, maskapai.*, jadwal_penerbangan.kapasitas_kursi
        FROM jadwal_penerbangan
        INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute
        INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai
        WHERE 
            maskapai.nama_maskapai LIKE '%$searchTerm%' OR
            rute.rute_asal LIKE '%$searchTerm%' OR
            rute.rute_tujuan LIKE '%$searchTerm%' OR
            rute.tanggal_pergi LIKE '%$searchTerm%'
        ORDER BY tanggal_pergi, waktu_berangkat
    ");
}

// Get all flights if no search term
$jadwalPenerbangan = $searchTerm ? $filteredResults : query("
    SELECT jadwal_penerbangan.*, rute.*, maskapai.*, jadwal_penerbangan.kapasitas_kursi
    FROM jadwal_penerbangan
    INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute
    INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai
    ORDER BY tanggal_pergi, waktu_berangkat
");
?>

<!-- Main Content Container -->
<div class="container mx-auto px-4 py-8">
    <!-- Section Title -->
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8 mt-5">
        Jadwal Penerbangan Tersedia
    </h2>
    
    <!-- Search Form -->
    <form action="" method="POST" class="max-w-3xl mx-auto flex flex-col md:flex-row gap-4 mb-16">
        <input 
            type="text" 
            name="cariJadwal" 
            placeholder="Cari berdasarkan maskapai, rute, atau tanggal..." 
            class="flex-grow px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            value="<?= htmlspecialchars($searchTerm) ?>"
        >
        <button 
            type="submit" 
            name="cari" 
            class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Cari Penerbangan
        </button>
    </form>

    <!-- Flight Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <?php if(count($jadwalPenerbangan) > 0): ?>
            <?php foreach($jadwalPenerbangan as $data): ?>
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border border-gray-100">
                <!-- Airline Logo Section -->
                <div class="bg-gradient-to-r from-blue-100 to-indigo-100 p-6 flex justify-center">
                    <img 
                        src="assets/images/<?= $data["logo_maskapai"]; ?>" 
                        alt="<?= $data["nama_maskapai"]; ?>" 
                        class="w-32 h-32 object-contain"
                        onerror="this.src='https://via.placeholder.com/150?text=No+Logo'"
                    >
                </div>
                
                <!-- Flight Details -->
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800 text-center mb-4">
                        <?= $data["nama_maskapai"]; ?>
                    </h3>
                    
                    <!-- Route -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Dari</div>
                            <div class="font-semibold text-gray-800"><?= $data["rute_asal"] ?></div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                        <div class="text-center">
                            <div class="text-sm text-gray-500">Ke</div>
                            <div class="font-semibold text-gray-800"><?= $data["rute_tujuan"]; ?></div>
                        </div>
                    </div>
                    
                    <!-- Flight Times -->
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div class="bg-gray-50 p-2 rounded-lg">
                            <div class="text-xs text-gray-500 text-center">Berangkat</div>
                            <div class="text-sm font-semibold text-center text-gray-800">
                                <?= date('H:i', strtotime($data["waktu_berangkat"])); ?>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-2 rounded-lg">
                            <div class="text-xs text-gray-500 text-center">Tiba</div>
                            <div class="text-sm font-semibold text-center text-gray-800">
                                <?= date('H:i', strtotime($data["waktu_tiba"])); ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Date and Capacity -->
                    <div class="flex justify-between text-sm text-gray-500 mb-4">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <?= date('d M Y', strtotime($data["tanggal_pergi"])); ?>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <?= $data["kapasitas_kursi"]; ?> Kursi
                        </div>
                    </div>
                </div>
                
                <!-- Price and Book Button -->
                <div class="border-t border-gray-200 px-5 py-4 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-xs text-gray-500">Mulai dari</span>
                            <div class="text-lg font-bold text-blue-600">
                                Rp <?= number_format($data["harga"], 0, ',', '.'); ?>
                            </div>
                        </div>
                        <a href="detail.php?id=<?= $data["id_jadwal"]; ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                            Pesan
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-xl font-medium text-gray-700">Tidak ada penerbangan yang ditemukan</h3>
                <p class="mt-2 text-gray-500">Coba gunakan kata kunci pencarian yang berbeda</p>
                <a href="jadwal.php" class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    Tampilkan Semua Penerbangan
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Menambahkan fitur search dengan JavaScript tanpa mengubah tampilan
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('form[method="POST"]');
    const searchInput = document.querySelector('input[name="cariJadwal"]');
    
    // Optional: Tambahkan event listener untuk real-time search
    searchInput.addEventListener('input', function() {
        // Jika ingin membuat real-time search, bisa ditambahkan di sini
        // Tapi sesuai permintaan, kita hanya mengaktifkan form submit yang sudah ada
    });
    
    // Pastikan form bekerja dengan baik
    searchForm.addEventListener('submit', function(e) {
        // Form akan tetap melakukan submit ke server seperti biasa
        // Tidak ada perubahan fungsionalitas
    });
});
</script>