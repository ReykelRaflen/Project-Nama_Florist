<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Ubah Pembayaran
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="rounded-xl border p-6 bg-background-light">
    <h1 class="font-display text-2xl font-bold text-primary mb-6">Ubah Pembayaran untuk Pesanan #<?= $payment['id_pesanan'] ?></h1>
    
    <form action="<?= site_url('admin/pembayaran/' . $payment['id']) ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PUT">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col md:col-span-2">
                <span class="text-sm mb-1">Pesanan</span>
                <div class="h-11 px-3 rounded-lg bg-gray-100 flex items-center">#<?= $order['id'] ?> - <?= esc($order['nama']) ?></div>
            </div>
            <label class="flex flex-col"><span class="text-sm mb-1">Jumlah (Rp)</span><input name="jumlah" type="number" value="<?= old('jumlah', $payment['jumlah']) ?>" class="form-input rounded-lg" required /></label>
            <label class="flex flex-col"><span class="text-sm mb-1">Metode Pembayaran</span>
                <select name="metode" class="form-select rounded-lg" required>
                    <option value="transfer_bank" <?= old('metode', $payment['metode']) == 'transfer_bank' ? 'selected' : '' ?>>Transfer Bank</option>
                    <option value="tunai" <?= old('metode', $payment['metode']) == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                </select>
            </label>
            <label class="flex flex-col"><span class="text-sm mb-1">Status Pembayaran</span>
                <select name="status" class="form-select rounded-lg" required>
                    <option value="menunggu" <?= old('status', $payment['status']) == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="lunas" <?= old('status', $payment['status']) == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                    <option value="gagal" <?= old('status', $payment['status']) == 'gagal' ? 'selected' : '' ?>>Gagal</option>
                    <option value="dikembalikan" <?= old('status', $payment['status']) == 'dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
                </select>
            </label>
            <label class="flex flex-col"><span class="text-sm mb-1">Tanggal Pembayaran (Opsional)</span><input name="tanggal_pembayaran" type="date" value="<?= old('tanggal_pembayaran', $payment['tanggal_pembayaran'] ? date('Y-m-d', strtotime($payment['tanggal_pembayaran'])) : '') ?>" class="form-input rounded-lg"/></label>
            <label class="flex flex-col md:col-span-2"><span class="text-sm mb-1">ID Transaksi (Opsional)</span><input name="id_transaksi" value="<?= old('id_transaksi', $payment['id_transaksi']) ?>" class="form-input rounded-lg" placeholder="ID dari payment gateway atau bank"/></label>

            <div class="md:col-span-2 text-right"><button type="submit" class="h-11 px-6 rounded-lg bg-primary text-white font-bold">Simpan Perubahan</button></div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>