<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
  <h1 class="font-display text-2xl md:text-3xl font-bold text-primary mb-6">Dashboard</h1>

  <!-- KPI Cards (Sama Persis) -->
  <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="p-5 rounded-xl border border-gray-200 dark:border-gray-800 bg-background-light dark:bg-background-dark/50">
      <div class="flex items-center justify-between">
        <p class="text-sm text-text-light/70 dark:text-text-dark/70">Pesanan Hari Ini</p>
        <span class="material-symbols-outlined text-primary">receipt_long</span>
      </div>
      <p class="mt-2 text-3xl font-extrabold"><?= $pesananHariIni ?? 0 ?></p>
      <p class="text-xs text-green-600 mt-1">&nbsp;</p> <!-- Placeholder untuk statistik -->
    </div>
    <div class="p-5 rounded-xl border border-gray-200 dark:border-gray-800 bg-background-light dark:bg-background-dark/50">
      <div class="flex items-center justify-between">
        <p class="text-sm text-text-light/70 dark:text-text-dark/70">Total Pendapatan</p>
        <span class="material-symbols-outlined text-primary">trending_up</span>
      </div>
      <p class="mt-2 text-3xl font-extrabold">Rp <?= number_format($totalPendapatan ?? 0, 0, ',', '.') ?></p>
      <p class="text-xs text-green-600 mt-1">Dari pesanan selesai</p>
    </div>
    <div class="p-5 rounded-xl border border-gray-200 dark:border-gray-800 bg-background-light dark:bg-background-dark/50">
      <div class="flex items-center justify-between">
        <p class="text-sm text-text-light/70 dark:text-text-dark/70">Pembayaran Tertunda</p>
        <span class="material-symbols-outlined text-primary">pending_actions</span>
      </div>
      <p class="mt-2 text-3xl font-extrabold"><?= $pembayaranTertunda ?? 0 ?></p>
      <p class="text-xs text-amber-600 mt-1">Perlu ditindaklanjuti</p>
    </div>
    <div class="p-5 rounded-xl border border-gray-200 dark:border-gray-800 bg-background-light dark:bg-background-dark/50">
      <div class="flex items-center justify-between">
        <p class="text-sm text-text-light/70 dark:text-text-dark/70">Pengguna Baru (24h)</p>
        <span class="material-symbols-outlined text-primary">group_add</span>
      </div>
      <p class="mt-2 text-3xl font-extrabold"><?= $penggunaBaru ?? 0 ?></p>
      <p class="text-xs text-green-600 mt-1">24 jam terakhir</p>
    </div>
  </section>

  <!-- Grid: Recent Orders + Quick Actions (Struktur Grid Utama) -->
  <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Orders (Sama Persis) -->
    <div class="lg:col-span-2 rounded-xl border border-gray-200 dark:border-gray-800 bg-background-light dark:bg-background-dark/50">
      <div class="p-5 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
        <h2 class="font-display text-lg font-bold">Pesanan Terbaru</h2>
        <a href="#" class="text-sm text-primary hover:underline">Lihat semua</a>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
          <thead class="bg-primary/10">
            <tr>
              <th class="px-4 py-3 text-left text-sm font-semibold">Kode</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">Pelanggan</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">Total</th>
              <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
              <th class="px-4 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
          <?php if (!empty($pesananTerbaru)): ?>
              <?php 
                $statusClasses = [
                    'selesai' => 'bg-green-100 text-green-700',
                    'dikonfirmasi' => 'bg-blue-100 text-blue-700',
                    'dalam_penyewaan' => 'bg-blue-100 text-blue-700',
                    'menunggu' => 'bg-amber-100 text-amber-700',
                    'dibatalkan' => 'bg-red-100 text-red-700',
                ];
              ?>
              <?php foreach($pesananTerbaru as $pesanan): ?>
              <tr>
                <td class="px-4 py-3 text-sm font-mono">INV-<?= str_pad($pesanan['id'], 4, '0', STR_PAD_LEFT) ?></td>
                <td class="px-4 py-3 text-sm"><?= esc($pesanan['nama_pelanggan']) ?></td>
                <td class="px-4 py-3 text-sm"><?= date('d M Y', strtotime($pesanan['dibuat_pada'])) ?></td>
                <td class="px-4 py-3 text-sm">Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></td>
                <td class="px-4 py-3">
                  <span class="px-2 py-0.5 text-xs rounded-full <?= $statusClasses[$pesanan['status']] ?? 'bg-gray-100 text-gray-700' ?>">
                    <?= ucfirst(str_replace('_', ' ', $pesanan['status'])) ?>
                  </span>
                </td>
                <td class="px-4 py-3 text-right"><a href="#" class="text-sm text-primary hover:underline">Kelola</a></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-4">Belum ada pesanan terbaru.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Quick Actions (Sama Persis) -->
    <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-background-light dark:bg-background-dark/50 p-5">
      <h2 class="font-display text-lg font-bold mb-4">Aksi Cepat</h2>
      <div class="grid grid-cols-1 gap-3">
        <a href="<?= site_url('admin/papanbunga/new') ?>" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-800 hover:bg-primary/5">
          <span class="material-symbols-outlined text-primary">add</span>
          <div>
            <p class="text-sm font-semibold">Tambah Produk</p>
            <p class="text-xs text-text-light/70 dark:text-text-dark/70">Buat produk papan bunga baru</p>
          </div>
        </a>
        <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-800 hover:bg-primary/5">
          <span class="material-symbols-outlined text-primary">local_shipping</span>
          <div>
            <p class="text-sm font-semibold">Kelola Pesanan</p>
            <p class="text-xs text-text-light/70 dark:text-text-dark/70">Lihat dan update status pesanan</p>
          </div>
        </a>
        <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-800 hover:bg-primary/5">
          <span class="material-symbols-outlined text-primary">payments</span>
          <div>
            <p class="text-sm font-semibold">Verifikasi Pembayaran</p>
            <p class="text-xs text-text-light/70 dark:text-text-dark/70">Konfirmasi pembayaran yang masuk</p>
          </div>
        </a>
        <a href="#" class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-800 hover:bg-primary/5">
          <span class="material-symbols-outlined text-primary">person</span>
          <div>
            <p class="text-sm font-semibold">Kelola Pengguna</p>
            <p class="text-xs text-text-light/70 dark:text-text-dark/70">Tambah/ubah/ban pengguna</p>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- Products preview (Sama Persis) -->
  <section class="mt-8 rounded-xl border border-gray-200 dark:border-gray-800 bg-background-light dark:bg-background-dark/50">
    <div class="p-5 border-b border-gray-200 dark:border-gray-800 flex items-center justify-between">
      <h2 class="font-display text-lg font-bold">Produk Teratas</h2>
      <a href="<?= site_url('admin/papanbunga') ?>" class="text-sm text-primary hover:underline">Kelola produk</a>
    </div>
    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <?php if (!empty($produkTeratas)): ?>
        <?php foreach($produkTeratas as $produk): ?>
        <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-gray-800 group">
          <img src="<?= base_url('uploads/images/' . $produk['gambar']) ?>" alt="<?= esc($produk['nama']) ?>" class="h-36 w-full object-cover group-hover:scale-105 transition-transform" />
          <div class="p-3">
            <p class="font-semibold truncate"><?= esc($produk['nama']) ?></p>
            <p class="text-sm text-text-light/70 dark:text-text-dark/70">Mulai Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
          </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
      
      <!-- Card "Tambah Produk" -->
      <a href="<?= site_url('admin/papanbunga/new') ?>" class="rounded-xl overflow-hidden border border-gray-200 dark:border-gray-800 group block">
        <div class="h-36 w-full bg-gradient-to-br from-primary/10 to-accent/20 flex items-center justify-center group-hover:from-primary/20 group-hover:to-accent/30 transition-colors">
          <span class="material-symbols-outlined text-primary text-4xl">add_circle</span>
        </div>
        <div class="p-3">
          <p class="font-semibold">Tambah produk</p>
          <span class="text-sm text-primary hover:underline">Mulai sekarang</span>
        </div>
      </a>
    </div>
  </section>
<?= $this->endSection() ?>