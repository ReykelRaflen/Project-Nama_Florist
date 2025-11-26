<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Katalog Papan Bunga
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<div class="@container">
    <div class="relative min-h-[380px] md:min-h-[480px] flex flex-col items-center justify-center p-4 bg-cover bg-center"
        style='background-image: linear-gradient(rgba(30, 70, 32, 0.5) 0%, rgba(30, 70, 32, 0.8) 100%), url("https://source.unsplash.com/random/1600x900/?flowers,pastel");'>
        <div class="flex flex-col gap-4 text-center">
            <h1 class="font-display text-4xl font-bold text-white md:text-6xl">Ekspresikan Perasaan Anda dengan Indah
            </h1>
            <h2 class="text-base font-light text-white/90 md:text-lg">Temukan papan bunga sempurna untuk setiap
                kesempatan.</h2>
        </div>
    </div>
</div>

<div class="px-4 md:px-10 lg:px-20 mx-auto py-12">
    <!-- Product Grid -->
    <div class="w-full">
        <div class="flex flex-col gap-6 mb-12">
            <div>
                <p class="text-4xl md:text-5xl font-black leading-tight tracking-[-0.033em] font-display text-primary">
                    Koleksi Papan Bunga Kami</p>
                <p class="text-lg text-text-light/70 dark:text-text-dark/70 mt-3">Pilih dari berbagai desain eksklusif
                    untuk setiap momen spesial Anda</p>
            </div>
        </div>

        <?php if (!empty($products)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                <!-- Product Card Loop -->
                <?php foreach ($products as $product): ?>
                    <div
                        class="group flex flex-col rounded-xl overflow-hidden bg-white dark:bg-background-dark shadow-md hover:shadow-xl transition-shadow duration-300 border border-primary/10 dark:border-accent/10">
                        <div class="overflow-hidden">
                            <a href="<?= site_url('product/' . $product['id']) ?>">
                                <img class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-500"
                                    src="<?= base_url('uploads/images/' . $product['gambar']) ?>"
                                    alt="<?= esc($product['nama']) ?>" />
                            </a>
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <h4 class="text-lg font-bold font-display text-primary dark:text-accent">
                                <?= esc($product['nama']) ?>
                            </h4>
                            <div class="mt-4 flex-1 flex items-end justify-between">
                                <p class="text-lg font-bold text-primary dark:text-accent">Rp
                                    <?= number_format($product['harga'], 0, ',', '.') ?></p>
                                <a href="<?= site_url('product/' . $product['id']) ?>"
                                    class="text-sm font-bold text-accent dark:text-white hover:underline">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-12">
                <!-- Pager dari CodeIgniter akan dirender di sini -->
                <?= $pager->links('products', 'tailwind_pagination') ?>
            </div>

        <?php else: ?>
            <div class="text-center py-16 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl">
                <span class="material-symbols-outlined text-6xl text-gray-400">inventory_2</span>
                <h3 class="mt-4 text-2xl font-semibold">Belum Ada Produk</h3>
                <p class="text-gray-500 mt-2">Koleksi papan bunga kami akan segera ditampilkan di sini.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>