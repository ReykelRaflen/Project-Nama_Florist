<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
Selesaikan Pesanan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="px-6 md:px-10 lg:px-20 flex-1 justify-center py-10">
    <div class="flex flex-col max-w-7xl mx-auto">
        <div class="flex flex-col gap-4 mb-8">
            <p class="text-primary dark:text-accent text-4xl lg:text-5xl font-black leading-tight tracking-[-0.033em] font-display">
                Selesaikan Pesanan</p>
            <p class="text-text-light/80 dark:text-text-dark/80 text-base font-normal leading-normal">Lengkapi pesanan
                Anda dengan memberikan detail berikut.</p>
        </div>
        <div class="flex items-center justify-center gap-2 md:gap-4 p-3 flex-wrap pr-4 mb-8 border-y border-gray-200 dark:border-gray-700">
            <div class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-primary text-white pl-5 pr-5">
                <span class="material-symbols-outlined text-base">local_shipping</span>
                <p class="text-sm font-medium leading-normal">1. Alamat Pengiriman</p>
            </div>
            <div class="w-12 h-px bg-gray-200 dark:border-gray-700 hidden md:block"></div>
            <div class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full border border-gray-200 dark:border-gray-700 pl-5 pr-5">
                <span class="material-symbols-outlined text-base text-text-light/60 dark:text-text-dark/60">payment</span>
                <p class="text-text-light/60 dark:text-text-dark/60 text-sm font-medium leading-normal">2. Pembayaran</p>
            </div>
        </div>
        
        <?= form_open('checkout/process') ?>
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2">
                    <h2 class="text-primary dark:text-accent text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 font-display">
                        Detail Pengiriman &amp; Ucapan</h2>
                    
                    <?php if ($validation->getErrors()): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative m-4" role="alert">
                            <strong class="font-bold">Error! Harap periksa kembali data Anda:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                <?php foreach ($validation->getErrors() as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                        <label class="flex flex-col min-w-40 flex-1"><p class="pb-2">Nama Pemesan</p><input name="nama_pemesan" class="form-input rounded-lg h-14" placeholder="Nama Lengkap Anda" value="<?= old('nama_pemesan', $user['nama'] ?? '') ?>" required /></label>
                        <label class="flex flex-col min-w-40 flex-1"><p class="pb-2">Nomor Telepon Pemesan</p><input name="telepon_pemesan" class="form-input rounded-lg h-14" placeholder="081234567890" type="tel" value="<?= old('telepon_pemesan', $user['telepon'] ?? '') ?>" required /></label>
                        <label class="flex flex-col min-w-40 flex-1"><p class="pb-2">Nama Penerima</p><input name="nama_penerima" class="form-input rounded-lg h-14" placeholder="Nama Lengkap Penerima" value="<?= old('nama_penerima') ?>" required /></label>
                        <label class="flex flex-col min-w-40 flex-1"><p class="pb-2">Nomor Telepon Penerima</p><input name="telepon_penerima" class="form-input rounded-lg h-14" placeholder="089876543210" type="tel" value="<?= old('telepon_penerima') ?>" required /></label>
                        <label class="flex flex-col min-w-40 flex-1 md:col-span-2"><p class="pb-2">Alamat Lengkap Pengiriman</p><textarea name="alamat_penerima" class="form-textarea rounded-lg h-28" placeholder="Jl. Bunga Melati No. 123..." required><?= old('alamat_penerima', $user['alamat'] ?? '') ?></textarea></label>
                        <label class="flex flex-col min-w-40 flex-1"><p class="pb-2">Tanggal Pengiriman</p><input name="tanggal_sewa" class="form-input rounded-lg h-14" type="date" value="<?= old('tanggal_sewa') ?>" required /></label>
                        <label class="flex flex-col min-w-40 flex-1 md:col-span-2"><p class="pb-2">Ucapan pada Papan Bunga</p><textarea name="teks_pesan" class="form-textarea rounded-lg h-28" placeholder="Contoh: Selamat &amp; Sukses..." required><?= old('teks_pesan') ?></textarea></label>
                    </div>

                    <h2 class="text-primary dark:text-accent text-[22px] font-bold px-4 pb-3 pt-10 font-display">Pilih Metode Pembayaran</h2>
                    <div class="p-4 space-y-4">
                        <fieldset><legend class="sr-only">Metode Pembayaran</legend>
                            <div class="space-y-4">
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer has-[:checked]:border-accent has-[:checked]:ring-2 has-[:checked]:ring-accent">
                                    <input type="radio" name="metode_pembayaran" value="transfer_bank" class="form-radio text-primary focus:ring-accent" <?= old('metode_pembayaran', 'transfer_bank') == 'transfer_bank' ? 'checked' : '' ?>>
                                    <span class="ml-3 font-medium">Transfer Bank / Virtual Account</span>
                                </label>
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer has-[:checked]:border-accent has-[:checked]:ring-2 has-[:checked]:ring-accent">
                                    <input type="radio" name="metode_pembayaran" value="tunai" class="form-radio text-primary focus:ring-accent" <?= old('metode_pembayaran') == 'tunai' ? 'checked' : '' ?>>
                                    <span class="ml-3 font-medium">Tunai (Cash on Delivery)</span>
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-28 border rounded-xl p-6 bg-background-light dark:bg-background-dark/50 shadow-lg">
                        <h3 class="text-primary dark:text-accent text-xl font-bold mb-6 font-display">Ringkasan Pesanan Anda</h3>
                        <div class="flex items-center gap-4">
                            <img class="w-20 h-20 rounded-lg object-cover" alt="<?= esc($product['nama']) ?>" src="<?= base_url('uploads/images/' . $product['gambar']) ?>" />
                            <div>
                                <p class="font-semibold text-text-light dark:text-text-dark"><?= esc($product['nama']) ?></p>
                                <p class="text-sm text-text-light/70 dark:text-text-dark/70">Jumlah: 1</p>
                            </div>
                            <p class="ml-auto font-medium text-text-light dark:text-text-dark">Rp <?= number_format($product['harga'], 0, ',', '.') ?></p>
                        </div>
                        <div class="border-t border-dashed my-6"></div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-text-light/80 dark:text-text-dark/80"><span>Subtotal</span><span>Rp <?= number_format($product['harga'], 0, ',', '.') ?></span></div>
                            <div class="flex justify-between font-bold text-lg text-text-light dark:text-text-dark"><span>Total Pembayaran</span><span>Rp <?= number_format($product['harga'], 0, ',', '.') ?></span></div>
                        </div>
                        <div class="border-t my-6"></div>
                        <button type="submit" class="w-full flex items-center justify-center rounded-lg h-14 px-4 bg-primary text-white font-bold hover:bg-primary/90 transition-colors">
                            <span class="material-symbols-outlined mr-2">lock</span><span class="truncate">Lanjutkan ke Pembayaran</span>
                        </button>
                    </div>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</main>
<?= $this->endSection() ?>