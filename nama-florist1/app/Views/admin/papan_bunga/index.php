<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Manajemen Papan Bunga
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex items-center justify-between gap-4 mb-6">
    <h1 class="font-display text-2xl md:text-3xl font-bold text-primary">Manajemen Papan Bunga</h1>
    <!-- Tombol ini masih mengarah ke halaman /new seperti sebelumnya -->
    <a href="<?= site_url('admin/papanbunga/new') ?>"
        class="inline-flex items-center gap-2 rounded-lg h-11 px-5 bg-primary text-white text-sm font-bold hover:bg-primary/90">
        <span class="material-symbols-outlined">add</span>
        Tambah Produk
    </a>
</div>

<!-- Flash Messages (jika ada) -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<section
    class="rounded-xl border border-gray-200 dark:border-gray-800 p-4 mb-6 bg-background-light dark:bg-background-dark/50">
    <!-- PENTING: Bungkus dengan form GET -->
    <form action="<?= site_url('admin/papanbunga') ?>" method="get">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <label class="flex flex-col">
                <span class="text-sm mb-1">Cari Nama Produk</span>
                <!-- PENTING: Tambahkan name="search" dan value dinamis -->
                <input name="search" class="form-input rounded-lg" placeholder="Nama produk..."
                    value="<?= esc($searchQuery ?? '') ?>" />
            </label>
            <label class="flex flex-col">
                <span class="text-sm mb-1">Status</span>
                <!-- PENTING: Tambahkan name="status" dan logika selected -->
                <select name="status" class="form-select rounded-lg">
                    <option value="">Semua Status</option>
                    <option value="tersedia" <?= ($statusFilter ?? '') == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="tidak_tersedia" <?= ($statusFilter ?? '') == 'tidak_tersedia' ? 'selected' : '' ?>>Tidak
                        Tersedia</option>
                </select>
            </label>
            <!-- Tombol untuk submit form -->
            <div class="flex items-center gap-2">
                <button type="submit"
                    class="w-full md:w-auto h-11 px-5 rounded-lg bg-primary text-white font-bold hover:bg-primary/90">
                    Terapkan Filter
                </button>
                <a href="<?= site_url('admin/papanbunga') ?>"
                    class="w-full md:w-auto h-11 px-5 rounded-lg border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-center">
                    Reset
                </a>
            </div>
        </div>
    </form>
</section>

<!-- Tabel Produk -->
<section
    class="rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden bg-background-light dark:bg-background-dark/50">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-primary/10">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Gambar</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama</th>
                    <!-- [START] Kolom Baru Ditambahkan -->
                    <th class="px-4 py-3 text-left font-semibold">Ukuran</th>
                    <th class="px-4 py-3 text-left font-semibold">Bahan</th>
                    <!-- [END] Kolom Baru Ditambahkan -->
                    <th class="px-4 py-3 text-left font-semibold">Harga</th>
                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                    <th class="px-4 py-3 text-left font-semibold">Stok</th>
                    <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td class="px-4 py-3">
                                <img src="<?= base_url('uploads/images/' . $product['gambar']) ?>"
                                    alt="<?= esc($product['nama']) ?>"
                                    class="w-16 h-12 object-cover rounded-lg border border-gray-200 dark:border-gray-700" />
                            </td>
                            <td class="px-4 py-3 font-semibold"><?= esc($product['nama']) ?></td>
                            <!-- [START] Data Kolom Baru Ditambahkan -->
                            <td class="px-4 py-3"><?= esc($product['ukuran'] ?: '-') ?></td>
                            <td class="px-4 py-3"><?= esc($product['bahan'] ?: '-') ?></td>
                            <!-- [END] Data Kolom Baru Ditambahkan -->
                            <td class="px-4 py-3"><?= "Rp " . number_format($product['harga'], 0, ',', '.') ?></td>
                            <td class="px-4 py-3">
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-semibold <?= $product['status'] == 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' ?>">
                                    <?= ucfirst(str_replace('_', ' ', $product['status'])) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3"><?= $product['stok'] ?></td>
                            <td class="px-4 py-3 text-right">
                                <a href="<?= site_url('admin/papanbunga/' . $product['id'] . '/edit') ?>"
                                    class="text-primary hover:underline mr-3">Ubah</a>
                                <form action="<?= site_url('admin/papanbunga/' . $product['id']) ?>" method="post"
                                    class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <!-- PENTING: Sesuaikan colspan menjadi 9 -->
                        <td colspan="9" class="text-center p-4">Belum ada produk.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-800 text-sm">
        <?= $pager->links('products', 'tailwind_pagination') ?>
    </div>
</section>
<?= $this->endSection() ?>