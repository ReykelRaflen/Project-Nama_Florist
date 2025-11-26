<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Tambah Produk Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="font-display text-2xl md:text-3xl font-bold text-primary">Tambah Produk Baru</h1>
    <a href="<?= site_url('admin/papanbunga') ?>"
        class="px-4 py-2 h-10 rounded-full bg-primary/10 text-primary font-semibold flex items-center gap-2 hover:bg-primary/20 transition">
        <span class="material-symbols-outlined">arrow_back</span>
        <span>Kembali</span>
    </a>
</div>

<!-- Menampilkan Error Validasi -->
<?php if ($validation->getErrors()): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Oops! Terjadi kesalahan:</strong>
        <ul class="mt-2 list-disc list-inside">
            <?php foreach ($validation->getErrors() as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-background-light dark:bg-background-dark/50 p-6">
    <?= form_open_multipart('admin/papanbunga') ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kolom Kiri -->
        <div class="space-y-4">
            <div>
                <label for="nama" class="block text-sm font-medium mb-1">Nama Produk</label>
                <input type="text" name="nama" id="nama" value="<?= old('nama') ?>"
                    class="form-input w-full rounded-lg bg-primary/10 border-none focus:ring-2 focus:ring-primary/50"
                    required>
            </div>
            <div>
                <label for="ukuran" class="block text-sm font-medium mb-1">Ukuran (Opsional)</label>

                <!-- PENTING: Tambahkan placeholder dan aria-describedby -->
                <input type="text" name="ukuran" id="ukuran" value="<?= old('ukuran', $product['ukuran'] ?? '') ?>"
                    class="form-input w-full rounded-lg bg-primary/10 border-none focus:ring-2 focus:ring-primary/50"
                    placeholder="Contoh: 2m x 1.5m" aria-describedby="ukuran-help">

                <!-- PENTING: Tambahkan teks bantuan di bawah ini -->
                <p id="ukuran-help" class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Masukkan ukuran dengan format **Lebar x Tinggi** (contoh: 2m x 1.5m).
                </p>
            </div>
            <div>
                <label for="bahan" class="block text-sm font-medium mb-1">Bahan (Opsional)</label>
                <input type="text" name="bahan" id="bahan" value="<?= old('bahan') ?>"
                    class="form-input w-full rounded-lg bg-primary/10 border-none focus:ring-2 focus:ring-primary/50">
            </div>
            <div>
                <label for="harga" class="block text-sm font-medium mb-1">Harga</label>
                <input type="number" name="harga" id="harga" value="<?= old('harga') ?>"
                    class="form-input w-full rounded-lg bg-primary/10 border-none focus:ring-2 focus:ring-primary/50"
                    required>
            </div>
        </div>
        <!-- Kolom Kanan -->
        <div class="space-y-4">
            <div>
                <label for="stok" class="block text-sm font-medium mb-1">Stok</label>
                <input type="number" name="stok" id="stok" value="<?= old('stok') ?>"
                    class="form-input w-full rounded-lg bg-primary/10 border-none focus:ring-2 focus:ring-primary/50"
                    required>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium mb-1">Status</label>
                <select name="status" id="status"
                    class="form-select w-full rounded-lg bg-primary/10 border-none focus:ring-2 focus:ring-primary/50">
                    <option value="tersedia" <?= old('status') == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="tidak_tersedia" <?= old('status') == 'tidak_tersedia' ? 'selected' : '' ?>>Tidak
                        Tersedia</option>
                </select>
            </div>
            <div>
                <label for="gambar" class="block text-sm font-medium mb-1">Gambar Produk</label>
                <input type="file" name="gambar" id="gambar" class="form-input w-full" required>
                <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG. Maks 2MB.</p>
            </div>
        </div>
    </div>
    <div class="mt-6 text-right">
        <button type="submit"
            class="px-6 py-2 h-11 rounded-full bg-primary text-white font-bold hover:bg-primary/90 transition">Simpan
            Produk</button>
    </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>