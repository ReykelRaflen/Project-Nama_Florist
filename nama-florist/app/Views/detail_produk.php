<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
<?= esc($product['nama']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="flex-1 px-4 md:px-10 lg:px-20 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumbs -->
        <div class="flex flex-wrap gap-2 pb-8">
            <a class="text-primary/80 dark:text-primary/70 text-sm hover:text-primary" href="<?= site_url('/') ?>">Beranda</a>
            <span class="text-gray-400 text-sm">/</span>
            <a class="text-primary/80 dark:text-primary/70 text-sm hover:text-primary" href="<?= site_url('katalog') ?>">Katalog</a>
            <span class="text-gray-400 text-sm">/</span>
            <span class="text-gray-600 dark:text-gray-400 text-sm"><?= esc($product['nama']) ?></span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <!-- Left Column: Product Image -->
            <div class="flex flex-col gap-4">
                <div class="w-full bg-center bg-no-repeat aspect-[4/3] bg-cover rounded-xl shadow-lg"
                    style='background-image: url("<?= base_url('uploads/images/' . $product['gambar']) ?>");'>
                </div>
            </div>

            <!-- Right Column: Product Info & Actions -->
            <div class="flex flex-col gap-6">
                <div>
                    <h2 class="font-serif text-4xl font-bold text-gray-800 dark:text-white">
                        <?= esc($product['nama']) ?>
                    </h2>
                    <p class="text-2xl font-semibold text-accent mt-2">
                        Rp <?= number_format($product['harga'], 0, ',', '.') ?> 
                        <span class="text-base font-normal text-gray-500 dark:text-gray-400">/ sewa</span>
                    </p>
                </div>

                <p class="text-gray-600 dark:text-gray-300 font-serif leading-relaxed">
                    Papan bunga elegan dengan sentuhan klasik, cocok untuk berbagai acara. Dibuat dengan bunga segar pilihan dan material berkualitas tinggi.
                </p>

                <!-- Hapus semua sisa form lama dan ganti dengan satu tombol link ini -->
                <a href="<?= site_url('checkout/' . $product['id']) ?>"
                   class="w-full flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-accent text-primary text-base font-bold leading-normal tracking-wide shadow-lg hover:bg-yellow-400 transition-all duration-300 transform hover:scale-105 
                          <?= $product['stok'] <= 0 ? 'bg-gray-400 !text-white hover:bg-gray-400 cursor-not-allowed' : '' ?>">
                    
                    <?php if ($product['stok'] > 0): ?>
                        <span>Sewa Sekarang</span>
                        <span class="material-symbols-outlined ml-2">arrow_forward</span>
                    <?php else: ?>
                        <span>Stok Habis</span>
                    <?php endif; ?>
                </a>

            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-20">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Pelanggan Juga Menyukai</h2>
            <?php if (!empty($relatedProducts)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach($relatedProducts as $related): ?>
                <div class="flex h-full flex-col gap-4 rounded-xl bg-white dark:bg-gray-800 shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                    <a href="<?= site_url('product/' . $related['id']) ?>" class="block">
                        <div class="w-full bg-center bg-no-repeat aspect-[4/3] bg-cover" style='background-image: url("<?= base_url('uploads/images/' . $related['gambar']) ?>");'></div>
                    </a>
                    <div class="flex flex-col flex-1 justify-between p-4 pt-0 gap-3">
                        <div>
                            <h4 class="font-semibold text-gray-700 dark:text-gray-200 truncate"><?= esc($related['nama']) ?></h4>
                            <p class="text-primary font-bold">Rp <?= number_format($related['harga'], 0, ',', '.') ?></p>
                        </div>
                        <a href="<?= site_url('product/' . $related['id']) ?>" class="w-full flex items-center justify-center rounded-lg h-10 px-4 bg-primary/10 text-primary text-sm font-bold hover:bg-primary/20">
                            <span class="truncate">Lihat Detail</span>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>
<?= $this->endSection() ?>