<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Tambah Pembayaran Manual
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="rounded-xl border p-6 bg-background-light">
    <h1 class="font-display text-2xl font-bold text-primary mb-6">Tambah Pembayaran Manual</h1>
    
    <!-- Tampilkan Error Validasi -->
    
    <form action="<?= site_url('admin/pembayaran') ?>" method="post">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <label class="flex flex-col md:col-span-2"><span class="text-sm mb-1">Pilih Pesanan</span>
                <select name="id_pesanan" class="form-select rounded-lg" required>
                    <option value="">-- Pilih ID Pesanan yang Belum Dibayar --</option>
                    <?php foreach($orders as $order): ?>
                    <option value="<?= $order['id'] ?>" <?= old('id_pesanan') == $order['id'] ? 'selected' : '' ?>>#<?= $order['id'] ?> - <?= esc($order['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="flex flex-col"><span class="text-sm mb-1">Jumlah (Rp)</span><input name="jumlah" type="number" value="<?= old('jumlah') ?>" class="form-input rounded-lg" placeholder="Contoh: 500000" required /></label>
            <label class="flex flex-col"><span class="text-sm mb-1">Metode Pembayaran</span>
                <select name="metode" class="form-select rounded-lg" required>
                    <option value="transfer_bank" <?= old('metode') == 'transfer_bank' ? 'selected' : '' ?>>Transfer Bank</option>
                    <option value="tunai" <?= old('metode') == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                </select>
            </label>
            <label class="flex flex-col"><span class="text-sm mb-1">Status Pembayaran</span>
                <select name="status" class="form-select rounded-lg" required>
                    <option value="menunggu" <?= old('status') == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="lunas" <?= old('status') == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                    <option value="gagal" <?= old('status') == 'gagal' ? 'selected' : '' ?>>Gagal</option>
                    <option value="dikembalikan" <?= old('status') == 'dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
                </select>
            </label>
            <label class="flex flex-col"><span class="text-sm mb-1">Tanggal Pembayaran (Opsional)</span><input name="tanggal_pembayaran" type="date" value="<?= old('tanggal_pembayaran') ?>" class="form-input rounded-lg"/></label>
            <label class="flex flex-col md:col-span-2"><span class="text-sm mb-1">ID Transaksi (Opsional)</span><input name="id_transaksi" value="<?= old('id_transaksi') ?>" class="form-input rounded-lg" placeholder="ID dari payment gateway atau bank"/></label>
            
            <div class="md:col-span-2 text-right"><button type="submit" class="h-11 px-6 rounded-lg bg-primary text-white font-bold">Simpan Pembayaran</button></div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>