<?= $this->extend('layouts/main_layout') ?>

<?= $this->section('title') ?>
  Masuk
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="w-full px-4 sm:px-6 md:px-8 lg:px-10 py-12">
  <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-center">
    <!-- Brand/Intro -->
    <div class="hidden md:block">
      <div class="rounded-xl overflow-hidden relative">
        <div class="h-72 bg-cover bg-center" style="background-image: linear-gradient(rgba(0,0,0,0.25), rgba(0,0,0,0.55)), url('https://source.unsplash.com/random/800x600/?flowers,bouquets');"></div>
        <div class="absolute inset-0 flex items-end p-6">
          <h1 class="font-display text-white text-3xl font-black leading-tight">Selamat Datang Kembali</h1>
        </div>
      </div>
      <p class="mt-6 text-gray-600 dark:text-gray-400">Masuk untuk melanjutkan pemesanan dan melihat status order Anda.</p>
    </div>

    <!-- Card Login -->
    <div class="bg-background-light dark:bg-background-dark rounded-xl shadow-lg p-6 md:p-8 border border-primary/10 dark:border-accent/10">
      <div class="flex items-center gap-3 mb-2 text-primary dark:text-accent">
        <span class="material-symbols-outlined text-2xl">login</span>
        <h2 class="font-display text-2xl font-bold">Masuk Akun</h2>
      </div>
      <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Belum punya akun? <a class="text-primary dark:text-accent font-semibold hover:underline" href="<?= site_url('register') ?>">Daftar</a></p>
      
      <!-- Pesan Flash dari Controller -->
      <?php if(session()->getFlashdata('success')): ?>
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
              <?= session()->getFlashdata('success') ?>
          </div>
      <?php endif; ?>
      <?php if(session()->getFlashdata('error')): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
              <?= session()->getFlashdata('error') ?>
          </div>
      <?php endif; ?>
      
      <?= form_open('/login', ['class' => 'space-y-4']) ?>
        <div>
          <label class="block text-sm font-medium mb-1" for="email">Email</label>
          <input id="email" name="email" type="email" required placeholder="nama@contoh.com" value="<?= old('email') ?>" class="form-input w-full rounded-lg bg-primary/10 dark:bg-accent/10 border-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-accent/50" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1" for="password">Kata Sandi</label>
          <input id="password" name="password" type="password" required placeholder="••••••••" class="form-input w-full rounded-lg bg-primary/10 dark:bg-accent/10 border-none focus:ring-2 focus:ring-primary/50 dark:focus:ring-accent/50" />
        </div>
        <button type="submit" class="w-full h-11 rounded-full bg-primary text-white font-bold tracking-wide hover:bg-primary/90 transition">Masuk</button>
      <?= form_close() ?>
    </div>
  </div>
</section>
<?= $this->endSection() ?>