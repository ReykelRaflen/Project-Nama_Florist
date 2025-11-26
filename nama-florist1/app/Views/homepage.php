<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Papan Bunga Premium
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- =================================================================
    HERO SECTION
    ================================================================== -->
    <div class="w-full px-4 sm:px-6 md:px-8 lg:px-10">
      <div class="flex min-h-[calc(100vh-80px)] md:min-h-[600px] flex-col gap-6 bg-cover bg-center bg-no-repeat items-center justify-center text-center px-4 py-10 rounded-lg"
        style='background-image: linear-gradient(rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.6) 100%), url("https://source.unsplash.com/random/1600x900/?wedding,flowers,celebration");'>
        <div class="flex flex-col gap-4 text-center items-center max-w-3xl px-4">
          <h1 class="font-display text-white text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black leading-tight tracking-tight">
            Rayakan Momen Spesial dengan Papan Bunga Premium
          </h1>
          <h2 class="text-white/90 text-sm sm:text-base md:text-lg font-normal leading-normal max-w-xl">
            Jelajahi koleksi eksklusif kami untuk pernikahan, acara kelulusan, dan setiap momen berharga lainnya.
          </h2>
        </div>
        <a href="<?= site_url('katalog') ?>"
          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-8 bg-primary text-white font-bold leading-normal tracking-wide hover:bg-primary/90 transition-transform transform hover:scale-105">
          <span class="truncate">Jelajahi Koleksi</span>
        </a>
      </div>
    </div>

    <!-- =================================================================
    FEATURED PRODUCTS SECTION
    ================================================================== -->
    <section class="w-full py-16 px-4 sm:px-6 md:px-8 lg:px-10 bg-primary/5 dark:bg-primary/10">
      <div class="max-w-6xl mx-auto">
        <h2 class="font-display text-3xl md:text-4xl font-bold leading-tight tracking-tight text-center pb-8 text-primary">
          Pilihan Utama
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            
            <?php if (!empty($featuredProducts)): ?>
                <?php foreach($featuredProducts as $product): ?>
                    <div class="bg-background-light dark:bg-background-dark rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300 group">
                        <div class="relative overflow-hidden">
                            <a href="<?= site_url('product/' . $product['id']) ?>">
                                <img class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110"
                                    src="<?= base_url('uploads/images/' . $product['gambar']) ?>" alt="<?= esc($product['nama']) ?>" />
                            </a>
                        </div>
                        <div class="p-6">
                            <h3 class="font-display text-xl font-bold text-primary truncate"><?= esc($product['nama']) ?></h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Mulai dari Rp <?= number_format($product['harga'], 0, ',', '.') ?></p>
                            <a href="<?= site_url('product/' . $product['id']) ?>" class="mt-4 w-full flex items-center justify-center gap-2 rounded-lg h-11 px-5 bg-primary text-white text-sm font-bold leading-normal tracking-wide hover:bg-primary/90 transition-colors">
                                Lihat Detail
                                <span class="material-symbols-outlined text-base">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-10">
                    <p>Produk pilihan akan segera ditampilkan.</p>
                </div>
            <?php endif; ?>

        </div>
      </div>
    </section>
    
    <!-- =================================================================
    "WHY US" SECTION (BAGIAN YANG HILANG SEBELUMNYA)
    ================================================================== -->
    <section class="w-full py-16 px-4 sm:px-6 md:px-8 lg:px-10">
        <div class="max-w-6xl mx-auto">
            <h2 class="font-display text-3xl md:text-4xl font-bold leading-tight tracking-tight text-center pb-8 text-primary">
            Mengapa Memilih Kami?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 text-center">
            <div class="flex flex-col items-center gap-3">
                <div class="flex items-center justify-center size-16 rounded-full bg-accent/20 text-accent">
                <span class="material-symbols-outlined text-3xl">design_services</span>
                </div>
                <h3 class="font-bold text-lg text-primary">Desain Eksklusif</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Setiap papan bunga dirancang secara unik oleh florist berpengalaman.</p>
            </div>
            <div class="flex flex-col items-center gap-3">
                <div class="flex items-center justify-center size-16 rounded-full bg-accent/20 text-accent">
                <span class="material-symbols-outlined text-3xl">local_florist</span>
                </div>
                <h3 class="font-bold text-lg text-primary">Bunga Segar Berkualitas</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Kami hanya menggunakan bunga segar pilihan untuk setiap rangkaian.</p>
            </div>
            <div class="flex flex-col items-center gap-3">
                <div class="flex items-center justify-center size-16 rounded-full bg-accent/20 text-accent">
                <span class="material-symbols-outlined text-3xl">local_shipping</span>
                </div>
                <h3 class="font-bold text-lg text-primary">Pengiriman Tepat Waktu</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Layanan pengiriman kami menjamin pesanan tiba sesuai jadwal.</p>
            </div>
            <div class="flex flex-col items-center gap-3">
                <div class="flex items-center justify-center size-16 rounded-full bg-accent/20 text-accent">
                <span class="material-symbols-outlined text-3xl">support_agent</span>
                </div>
                <h3 class="font-bold text-lg text-primary">Layanan Profesional</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Tim kami siap membantu Anda dari proses pemesanan hingga pengiriman.</p>
            </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>