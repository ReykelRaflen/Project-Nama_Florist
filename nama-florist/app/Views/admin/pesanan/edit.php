<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Ubah Pesanan #<?= $order['id'] ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="rounded-xl border p-6 bg-background-light">
    <h1 class="font-display text-2xl font-bold text-primary mb-6">Ubah Pesanan #<?= $order['id'] ?></h1>
    
    <form action="<?= site_url('admin/pesanan/' . $order['id']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="flex flex-col"><span class="text-sm mb-1">Pelanggan</span>
                <select name="id_penyewa" class="form-select rounded-lg" required>
                    <?php foreach($users as $user): ?>
                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $order['id_penyewa'] ? 'selected' : '' ?>><?= esc($user['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="flex flex-col"><span class="text-sm mb-1">Produk</span>
                <select name="id_papan_bunga" class="form-select rounded-lg" required>
                    <?php foreach($products as $product): ?>
                    <option value="<?= $product['id'] ?>" <?= $product['id'] == $order['id_papan_bunga'] ? 'selected' : '' ?>><?= esc($product['nama']) ?> (<?= number_to_currency($product['harga'], 'IDR', 'id_ID', 0) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="flex flex-col"><span class="text-sm mb-1">Tanggal Sewa</span><input name="tanggal_sewa" type="date" value="<?= $order['tanggal_sewa'] ?>" class="form-input rounded-lg" required /></label>
            <label class="flex flex-col"><span class="text-sm mb-1">Status</span>
                <select name="status" class="form-select rounded-lg" required>
                    <option value="menunggu" <?= $order['status'] == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="dikonfirmasi" <?= $order['status'] == 'dikonfirmasi' ? 'selected' : '' ?>>Dikonfirmasi</option>
                    <option value="dalam_penyewaan" <?= $order['status'] == 'dalam_penyewaan' ? 'selected' : '' ?>>Dalam Penyewaan</option>
                    <option value="selesai" <?= $order['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="dibatalkan" <?= $order['status'] == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                </select>
            </label>
            <label class="flex flex-col md:col-span-2"><span class="text-sm mb-1">Teks Ucapan</span><textarea name="teks_pesan" class="form-textarea rounded-lg" rows="3"><?= esc($order['teks_pesan']) ?></textarea></label>
            <div class="md:col-span-2 text-right"><button type="submit" class="h-11 px-6 rounded-lg bg-primary text-white font-bold">Simpan Perubahan</button></div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>