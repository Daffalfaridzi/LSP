<?php require 'layouts/navbar.php'; ?>
<?php 
$jadwalPenerbangan = query("
    SELECT jadwal_penerbangan.*, rute.*, maskapai.*, jadwal_penerbangan.kapasitas_kursi
    FROM jadwal_penerbangan
    INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute
    INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai
    ORDER BY tanggal_pergi, waktu_berangkat
    LIMIT 4
");
?>

<!-- Hero Section -->
<div class="relative h-96 md:h-[32rem] overflow-hidden shadow-xl mb-12">
    <!-- Background Image -->
    <img src="https://wallpapercave.com/wp/wp10448214.jpg" alt="Airport" class="w-full h-full object-cover object-top brightness-75">
    
    <!-- Overlay Content -->
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <h1 class="text-3xl md:text-5xl font-bold text-white drop-shadow-lg mb-6">
            Selamat Datang di <span class="bg-blue-900 px-3 py-2 rounded-xl ml-2">TIKET<span class="text-yellow-400">!NG</span></span>
        </h1>
        <p class="text-xl md:text-xl text-white drop-shadow-lg max-w-2xl">
            Temukan dan pesan tiket penerbangan terbaik untuk perjalanan Anda
        </p>
    </div>
</div>

<!-- Main Content Container -->
<div class="container mx-auto px-4 py-8">
    <!-- Section Title -->
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">
        Jadwal Penerbangan Tersedia
    </h2>

    <!-- Flight Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <?php foreach($jadwalPenerbangan as $data) : ?>
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
    </div>
    
    <!-- View More Button -->
    <div class="text-center">
        <form action="jadwal.php" method="">
            <button type="submit" name="cari" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-300 inline-flex items-center">
                Lihat Lebih Banyak Penerbangan
            </button>
        </form>
    </div>
</div>

<!-- Partner Airlines Section -->
<div class="bg-gradient-to-r from-blue-100 to-indigo-100 py-16 px-4 sm:px-6 lg:px-8 mt-5">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row items-center gap-10">
            <!-- Left Side - Text Content -->
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    Partner Maskapai Kami
                </h2>
                <p class="text-lg text-gray-600 mb-6">
                    Kami bangga bekerja sama dengan maskapai penerbangan terbaik di Indonesia untuk memberikan pengalaman perjalanan yang tak terlupakan.
                </p>
                <div class="text-lg font-medium text-gray-700">
                    Garuda Indonesia • Lion Air • Citilink • Air Asia • 
                    TransNusa • Wings Air • Sriwijaya Air • Batik Air
                </div>
            </div>
            
            <!-- Right Side - Image -->
            <div class="lg:w-2/2">
                <div class="p-2 rounded-2xl">
                    <img 
                        src="https://sttkd.ac.id/wp-content/uploads/2023/05/Maskapai-penerbangan-Indonesia.webp" 
                        alt="Partner Airlines" 
                        class="w-full h-auto object-cover rounded-xl"
                        onerror="this.src='https://via.placeholder.com/800x450?text=Partner+Airlines'"
                    >
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Footer Section -->
<footer class="bg-gray-800 text-white pt-12 pb-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="md:col-span-2">
                <h3 class="text-2xl font-bold mb-4 flex items-center">
                    <span class="bg-blue-600 px-2 py-1 rounded-lg mr-2">TIKET<span class="text-yellow-300">!NG</span></span>
                </h3>
                <p class="text-gray-400 mb-4">
                    Platform pemesanan tiket pesawat terbaik di Indonesia dengan pelayanan 24/7 untuk kenyamanan perjalanan Anda.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Tautan Cepat</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="../daffalsp/jadwal.php" class="text-gray-400 hover:text-white transition-colors">Jadwal Penerbangan</a></li>
                    <li><a href="../daffalsp/cart.php" class="text-gray-400 hover:text-white transition-colors">Pesanan</a></li>
                    <li><a href="../daffalsp/history.php" class="text-gray-400 hover:text-white transition-colors">Riwayat</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Hubungi Kami</h3>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        +62 123 4567 8910
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        info@tiketng.com
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Jl. Penerbangan No. 123, Jakarta
                    </li>
                </ul>
            </div>


        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-500 text-sm">
            <p>&copy; <?= date('Y'); ?> TIKET!NG. All rights reserved.</p>
        </div>
    </div>
</footer>