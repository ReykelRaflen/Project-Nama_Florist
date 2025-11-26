<!-- app/Views/partials/admin_sidebar.php -->
<aside
  class="hidden lg:flex lg:flex-col w-64 shrink-0 bg-background-light dark:bg-background-dark/60 border-r border-gray-200 dark:border-gray-800">
  <div class="h-16 px-6 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
    <span class="material-symbols-outlined text-3xl text-primary">local_florist</span>
    <h1 class="font-display text-xl font-bold tracking-wide text-primary">Admin Florist</h1>
  </div>
  <nav class="flex-1 px-3 py-4 space-y-1">
    <a href="<?= site_url('admin/dashboard') ?>"
      class="flex items-center gap-3 px-3 py-2 rounded-lg <?= (uri_string() == 'admin/dashboard' || uri_string() == 'admin') ? 'bg-primary/10 text-primary' : 'hover:bg-primary/5' ?>">
      <span class="material-symbols-outlined">dashboard</span>
      <span class="text-sm font-medium">Dashboard</span>
    </a>
    <a href="<?= site_url('admin/pesanan') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/5">
      <span class="material-symbols-outlined">receipt_long</span>
      <span class="text-sm font-medium">Manajemen Pesanan</span>
    </a>
    <a href="<?= site_url('admin/papanbunga') ?>"
      class="flex items-center gap-3 px-3 py-2 rounded-lg <?= (strpos(uri_string(), 'admin/papanbunga') !== false) ? 'bg-primary/10 text-primary' : 'hover:bg-primary/5' ?>">
      <span class="material-symbols-outlined">inventory_2</span>
      <span class="text-sm font-medium">Manajemen Produk</span>
    </a>
    <a href="<?= site_url('admin/pembayaran') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/5">
      <span class="material-symbols-outlined">payments</span>
      <span class="text-sm font-medium">Manajemen Pembayaran</span>
    </a>
    <a href="<?= site_url('admin/pengguna') ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/5">
      <span class="material-symbols-outlined">group</span>
      <span class="text-sm font-medium">Manajemen Pengguna</span>
    </a>
    <div class="pt-2">
      <a href="<?= site_url('logout') ?>"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
        <span class="material-symbols-outlined">logout</span>
        <span class="text-sm font-medium">Keluar</span>
      </a>
    </div>
  </nav>
  <div class="p-4 border-t border-gray-200 dark:border-gray-800 text-xs text-text-light/60 dark:text-text-dark/60">
    © <?= date('Y') ?> Nama Florist
  </div>
</aside>