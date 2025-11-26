<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Manajemen Pesanan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div x-data="{ statusModalOpen: false, order: {} }">
    <div class="flex items-center justify-between gap-4 mb-6">
        <h1 class="font-display text-2xl md:text-3xl font-bold text-primary">Manajemen Pesanan</h1>
        <a href="<?= site_url('admin/pesanan/new') ?>"
            class="inline-flex items-center gap-2 rounded-lg h-11 px-5 bg-primary text-white text-sm font-bold hover:bg-primary/90">
            <span class="material-symbols-outlined">add</span>
            Tambah Pesanan
        </a>
    </div>


    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>


    <!-- Filters -->
    <section class="rounded-xl border border-gray-200 p-4 mb-6 bg-background-light">
        <form action="<?= site_url('admin/pesanan') ?>" method="get">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <label class="flex flex-col">
                    <span class="text-sm mb-1">Cari</span>
                    <input name="search" class="form-input rounded-lg" placeholder="ID / Pelanggan / Produk"
                        value="<?= esc($search ?? '') ?>" />
                </label>
                <label class="flex flex-col">
                    <span class="text-sm mb-1">Status</span>
                    <select name="status" class="form-select rounded-lg">
                        <option value="">Semua Status</option>
                        <option value="menunggu" <?= ($status ?? '') == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="dikonfirmasi" <?= ($status ?? '') == 'dikonfirmasi' ? 'selected' : '' ?>>
                            Dikonfirmasi</option>
                        <option value="dalam_penyewaan" <?= ($status ?? '') == 'dalam_penyewaan' ? 'selected' : '' ?>>Dalam
                            Penyewaan</option>
                        <option value="selesai" <?= ($status ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="dibatalkan" <?= ($status ?? '') == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan
                        </option>
                    </select>
                </label>
                <div class="flex gap-2">
                    <button type="submit"
                        class="w-full h-11 px-5 rounded-lg bg-primary text-white font-bold hover:bg-primary/90">Filter</button>
                    <a href="<?= site_url('admin/pesanan') ?>"
                        class="w-full h-11 px-5 rounded-lg border flex items-center justify-center">Reset</a>
                </div>
            </div>
        </form>
    </section>

    <!-- Table -->
    <section class="rounded-xl border border-gray-200 overflow-hidden bg-background-light">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-primary/10">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">ID</th>
                        <th class="px-4 py-3 text-left font-semibold">Pelanggan</th>
                        <th class="px-4 py-3 text-left font-semibold">Tanggal Sewa</th>
                        <th class="px-4 py-3 text-left font-semibold">Harga</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="px-4 py-3 font-mono">#<?= $order['id'] ?></td>
                                <td class="px-4 py-3 font-semibold"><?= esc($order['nama_pelanggan']) ?></td>
                                <td class="px-4 py-3"><?= date('d M Y', strtotime($order['tanggal_sewa'])) ?></td>
                                <td class="px-4 py-3"><?= number_to_currency($order['total_harga'], 'IDR', 'id_ID', 0) ?></td>
                                <td class="px-4 py-3">...</td>
                                <td class="px-4 py-3 text-right">
                                    <!-- Tombol Aksi Baru -->
                                    <a href="<?= site_url('admin/pesanan/' . $order['id'] . '/edit') ?>"
                                        class="text-primary hover:underline mr-3">Ubah</a>
                                    <form action="<?= site_url('admin/pesanan/' . $order['id']) ?>" method="post" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center p-4">Tidak ada data pesanan ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="p-4 border-t text-sm">
                <?= $pager->links('orders', 'tailwind_pagination') ?>
            </div>
    </section>

    <!-- Status Update Modal -->
    <div x-show="statusModalOpen" @keydown.escape.window="statusModalOpen = false"
        class="fixed inset-0 flex items-center justify-center modal-backdrop z-50" style="display: none;">
        <div @click.away="statusModalOpen = false"
            class="bg-background-light w-full max-w-md rounded-xl border shadow-xl mx-4">
            <div class="p-4 border-b flex items-center justify-between">
                <h3 class="font-display text-lg font-bold">Ubah Status Pesanan #<span x-text="order.id"></span></h3>
                <button @click="statusModalOpen = false"
                    class="size-8 rounded-full hover:bg-primary/10 flex items-center justify-center"><span
                        class="material-symbols-outlined">close</span></button>
            </div>
            <form :action="'<?= site_url('admin/pesanan/update/') ?>' + order.id" method="post" class="p-6">
                <?= csrf_field() ?>
                <label class="flex flex-col">
                    <span class="text-sm mb-1">Status Baru</span>
                    <select name="status" class="form-select rounded-lg" required>
                        <option value="menunggu" :selected="order.status === 'menunggu'">Menunggu</option>
                        <option value="dikonfirmasi" :selected="order.status === 'dikonfirmasi'">Dikonfirmasi</option>
                        <option value="dalam_penyewaan" :selected="order.status === 'dalam_penyewaan'">Dalam Penyewaan
                        </option>
                        <option value="selesai" :selected="order.status === 'selesai'">Selesai</option>
                        <option value="dibatalkan" :selected="order.status === 'dibatalkan'">Dibatalkan</option>
                    </select>
                </label>
                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" @click="statusModalOpen = false"
                        class="px-4 h-10 rounded-lg border hover:bg-primary/5">Batal</button>
                    <button type="submit"
                        class="px-5 h-10 rounded-lg bg-primary text-white font-bold hover:bg-primary/90">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>