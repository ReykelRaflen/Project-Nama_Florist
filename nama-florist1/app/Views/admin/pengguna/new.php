<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Tambah Pengguna Baru
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="font-display text-2xl md:text-3xl font-bold text-primary">Tambah Pengguna Baru</h1>
    <a href="<?= site_url('admin/pengguna') ?>" class="px-4 py-2 h-10 rounded-lg bg-primary/10 text-primary font-semibold flex items-center gap-2 hover:bg-primary/20">
        <span class="material-symbols-outlined">arrow_back</span>
        <span>Kembali</span>
    </a>
</div>

<!-- Menampilkan Error Validasi -->
<?php if(session()->has('errors')): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
        <strong class="font-bold">Gagal! Terjadi kesalahan:</strong>
        <ul class="mt-2 list-disc list-inside">
        <?php foreach (session('errors') as $error) : ?>
            <li><?= esc($error) ?></li>
        <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<div class="rounded-xl border p-6 bg-background-light">
    <form action="<?= site_url('admin/pengguna') ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?= csrf_field() ?>
        
        <label class="flex flex-col"><span class="text-sm mb-1">Nama Lengkap</span><input name="nama" value="<?= old('nama') ?>" class="form-input rounded-lg" placeholder="Nama Lengkap" required /></label>
        <label class="flex flex-col"><span class="text-sm mb-1">Email</span><input name="email" type="email" value="<?= old('email') ?>" class="form-input rounded-lg" placeholder="email@example.com" required /></label>
        <label class="flex flex-col"><span class="text-sm mb-1">Telepon</span><input name="telepon" value="<?= old('telepon') ?>" class="form-input rounded-lg" placeholder="08xxxxxxxxxx" /></label>
        <label class="flex flex-col"><span class="text-sm mb-1">Role</span><select name="peran" class="form-select rounded-lg" required><option value="penyewa" <?= old('peran') == 'penyewa' ? 'selected' : '' ?>>Penyewa</option><option value="admin" <?= old('peran') == 'admin' ? 'selected' : '' ?>>Admin</option></select></label>
        <label class="flex flex-col md:col-span-2"><span class="text-sm mb-1">Password</span><input name="password" type="password" class="form-input rounded-lg" placeholder="Min. 6 karakter" required /></label>
        
        <div class="md:col-span-2 flex items-center justify-end gap-3 mt-2">
            <a href="<?= site_url('admin/pengguna') ?>" class="px-4 h-11 rounded-lg border hover:bg-primary/5">Batal</a>
            <button type="submit" class="px-5 h-11 rounded-lg bg-primary text-white font-bold hover:bg-primary/90">Simpan Pengguna</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>