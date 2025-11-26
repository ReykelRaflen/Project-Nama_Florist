<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Manajemen Pembayaran
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="flex items-center justify-between gap-4 mb-6">
    <h1 class="font-display text-2xl md:text-3xl font-bold text-primary">Manajemen Pembayaran</h1>
    <a href="<?= site_url('admin/pembayaran/new') ?>"
        class="inline-flex items-center gap-2 rounded-lg h-11 px-5 bg-primary text-white text-sm font-bold hover:bg-primary/90">
        <span class="material-symbols-outlined">add</span>
        Tambah Pembayaran
    </a>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- KPI Cards -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
    <div class="p-5 rounded-xl border">
        <p class="text-sm">Pendapatan Bulan Ini</p>
        <p class="mt-2 text-2xl font-extrabold"><?= number_to_currency($kpi['revenue'], 'IDR', 'id_ID', 0) ?></p>
    </div>
    <div class="p-5 rounded-xl border">
        <p class="text-sm">Pending</p>
        <p class="mt-2 text-2xl font-extrabold"><?= $kpi['pending'] ?></p>
    </div>
    <div class="p-5 rounded-xl border">
        <p class="text-sm">Paid</p>
        <p class="mt-2 text-2xl font-extrabold"><?= $kpi['paid'] ?></p>
    </div>
    <div class="p-5 rounded-xl border">
        <p class="text-sm">Failed/Refund</p>
        <p class="mt-2 text-2xl font-extrabold"><?= $kpi['failed'] ?></p>
    </div>
</section>

<!-- Filters -->
<section class="rounded-xl border p-4 mb-6 bg-background-light">
    <form action="<?= site_url('admin/pembayaran') ?>" method="get">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <label class="flex flex-col"><span class="text-sm mb-1">Cari</span><input name="search"
                    class="form-input rounded-lg" placeholder="ID Pesanan / Pelanggan"
                    value="<?= esc($search ?? '') ?>" /></label>
            <label class="flex flex-col"><span class="text-sm mb-1">Status</span>
                <select name="status" class="form-select rounded-lg">
                    <option value="">Semua</option>
                    <option value="menunggu" <?= ($status ?? '') == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="lunas" <?= ($status ?? '') == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                    <option value="gagal" <?= ($status ?? '') == 'gagal' ? 'selected' : '' ?>>Gagal</option>
                    <option value="dikembalikan" <?= ($status ?? '') == 'dikembalikan' ? 'selected' : '' ?>>Dikembalikan
                    </option>
                </select>
            </label>
            <label class="flex flex-col"><span class="text-sm mb-1">Metode</span>
                <select name="method" class="form-select rounded-lg">
                    <option value="">Semua</option>
                    <option value="transfer_bank" <?= ($method ?? '') == 'transfer_bank' ? 'selected' : '' ?>>Transfer Bank
                    </option>
                    <option value="tunai" <?= ($method ?? '') == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                </select>
            </label>
            <div class="flex gap-2 col-span-1 md:col-span-2">
                <button type="submit"
                    class="w-full h-11 px-5 rounded-lg bg-primary text-white font-bold hover:bg-primary/90">Filter</button>
                <a href="<?= site_url('admin/pembayaran') ?>"
                    class="w-full h-11 px-5 rounded-lg border flex items-center justify-center">Reset</a>
            </div>
        </div>
    </form>
</section>

<!-- Table -->
<section class="rounded-xl border overflow-hidden bg-background-light">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-primary/10">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">ID Pesanan</th>
                    <th class="px-4 py-3 text-left font-semibold">Pelanggan</th>
                    <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-4 py-3 text-left font-semibold">Nominal</th>
                    <th class="px-4 py-3 text-left font-semibold">Metode</th>
                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                    <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php if (!empty($payments)): ?>
                    <?php foreach ($payments as $p): ?>
                        <tr>
                            <td class="px-4 py-3 font-mono">#<?= $p['invoice_id'] ?></td>
                            <td class="px-4 py-3 font-semibold"><?= esc($p['nama_pelanggan']) ?></td>
                            <td class="px-4 py-3"><?= date('d M Y, H:i', strtotime($p['dibuat_pada'])) ?></td>
                            <td class="px-4 py-3"><?= number_to_currency($p['jumlah'], 'IDR', 'id_ID', 0) ?></td>
                            <td class="px-4 py-3"><?= ucfirst(str_replace('_', ' ', $p['metode'])) ?></td>
                            <td class="px-4 py-3">...</td>
                            <td class="px-4 py-3 text-right">
                                <a href="<?= site_url('admin/pembayaran/' . $p['id'] . '/edit') ?>"
                                    class="text-primary hover:underline mr-3">Ubah</a>
                                <form action="<?= site_url('admin/pembayaran/' . $p['id']) ?>" method="post" class="inline"
                                    onsubmit="return confirm('Anda yakin ingin menghapus data pembayaran ini?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center p-4">Tidak ada data pembayaran ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t text-sm">
        <?= $pager->links('payments', 'tailwind_pagination') ?>
    </div>
</section>
<?= $this->endSection() ?>