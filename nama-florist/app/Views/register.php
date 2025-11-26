<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
  Daftar Akun
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="w-full px-4 sm:px-6 md:px-8 lg:px-10 py-12">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-center">
      <!-- Brand/Intro -->
      <div class="hidden md:block order-2 md:order-1">
        <!-- ... Konten intro tidak berubah ... -->
        <div class="rounded-xl overflow-hidden relative">
          <div class="h-72 bg-cover bg-center"
               style="background-image: linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.55)), url('https://source.unsplash.com/random/800x600/?flower,arrangement');"></div>
          <div class="absolute inset-0 flex items-end p-6">
            <h1 class="font-display text-white text-3xl font-black leading-tight">Bergabung dengan Nama Florist</h1>
          </div>
        </div>
        <p class="mt-6 text-gray-600 dark:text-gray-400">Daftar untuk mulai berbelanja papan bunga premium.</p>
        <ul class="mt-4 space-y-2 text-sm text-gray-600 dark:text-gray-400 list-disc list-inside">
          <li>Koleksi eksklusif</li>
          <li>Voucher dan promo khusus</li>
          <li>Notifikasi status pesanan</li>
        </ul>
      </div>

      <!-- Card Register -->
      <div class="bg-background-light dark:bg-background-dark rounded-xl shadow-lg p-6 md:p-8 border border-primary/10 dark:border-accent/10 order-1 md:order-2">
        <!-- ... Header Card Register tidak berubah ... -->
        <div class="flex items-center gap-3 mb-2 text-primary dark:text-accent">
          <span class="material-symbols-outlined text-2xl">person_add</span>
          <h2 class="font-display text-2xl font-bold">Buat Akun</h2>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Sudah punya akun? <a class="text-primary dark:text-accent font-semibold hover:underline" href="<?= site_url('login') ?>">Masuk</a></p>
        
        <!-- Menampilkan Error Validasi -->
        <?php if(session()->has('validation')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops! Terjadi kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside">
                <?php foreach (session('validation')->getErrors() as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?= form_open('/register', ['class' => 'space-y-4']) ?>
          <!-- ... Semua input field (nama, email, dll.) tidak berubah ... -->
          <div>
            <label class="block text-sm font-medium mb-1" for="nama">Nama Lengkap</label>
            <input id="nama" name="nama" type="text" required placeholder="Nama Anda" value="<?= old('nama') ?>" class="form-input w-full rounded-lg bg-primary/10 dark:bg-accent/10 border-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-accent/50" />
          </div>
          <div>
            <label class="block text-sm font-medium mb-1" for="email">Email</label>
            <input id="email" name="email" type="email" required placeholder="nama@contoh.com" value="<?= old('email') ?>" class="form-input w-full rounded-lg bg-primary/10 dark:bg-accent/10 border-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-accent/50" />
          </div>
          <div>
            <label class="block text-sm font-medium mb-1" for="telepon">No. HP</label>
            <div class="flex rounded-lg overflow-hidden ring-1 ring-inset ring-primary/20 dark:ring-accent/20 focus-within:ring-2 focus-within:ring-primary/50 dark:focus-within:ring-accent/50">
              <span class="inline-flex items-center px-3 bg-primary/10 dark:bg-accent/10 text-sm text-primary dark:text-accent select-none">+62</span>
              <input id="telepon" name="telepon" type="tel" inputmode="numeric" required placeholder="81234567890" value="<?= old('telepon') ?>" class="form-input flex-1 rounded-none border-0 bg-primary/10 dark:bg-accent/10 focus:ring-0" />
            </div>
            <p class="mt-1 text-xs text-gray-500">Gunakan angka saja, 9-13 digit (contoh: 81234567890)</p>
          </div>
          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1" for="password">Kata Sandi</label>
              <input id="password" name="password" type="password" minlength="6" required placeholder="Min. 6 karakter" class="form-input w-full rounded-lg bg-primary/10 dark:bg-accent/10 border-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-accent/50" />
            </div>
            <div>
              <label class="block text-sm font-medium mb-1" for="confirm_password">Konfirmasi Sandi</label>
              <input id="confirm_password" name="confirm_password" type="password" minlength="6" required placeholder="Ulangi kata sandi" class="form-input w-full rounded-lg bg-primary/10 dark:bg-accent/10 border-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-accent/50" />
            </div>
          </div>
          
          <!-- [START] KODE BARU UNTUK SYARAT & KETENTUAN -->
          <label class="inline-flex items-start gap-3 text-sm">
            <!-- PENTING: name="terms" dan value="1" -->
            <input id="terms" name="terms" type="checkbox" value="1" required class="mt-1 rounded border-gray-300 text-primary focus:ring-primary" />
            <span>Saya menyetujui <a class="text-primary dark:text-accent font-medium hover:underline" href="<?= site_url('syarat-ketentuan') ?>">Syarat & Ketentuan</a> serta <a class="text-primary dark:text-accent font-medium hover:underline" href="<?= site_url('kebijakan-privasi') ?>">Kebijakan Privasi</a>.</span>
          </label>
          <!-- [END] KODE BARU -->

          <button type="submit" class="w-full h-11 rounded-full bg-primary text-white font-bold tracking-wide hover:bg-primary/90 transition">Daftar</button>
          
        <?= form_close() ?>
      </div>
    </div>
</section>
<?= $this->endSection() ?>