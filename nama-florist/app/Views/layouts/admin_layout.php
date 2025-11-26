<!DOCTYPE html>
<html class="light" lang="id">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title><?= $this->renderSection('title') ?> - Nama Florist Admin</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet" />
  
  <!-- [START] BAGIAN YANG DIPERBAIKI -->
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#224B0C",
            "accent": "#D4AF37",
            "background-light": "#FFFFFF",
            "background-dark": "#101010",
            "text-light": "#1F2937",
            "text-dark": "#F3F4F6",
          },
          fontFamily: {
            "display": ["Playfair Display", "serif"],
            "sans": ["Manrope", "sans-serif"]
          },
          borderRadius: {
            "DEFAULT": "0.5rem",
            "lg": "0.75rem",
            "xl": "1rem",
            "full": "9999px"
          },
        },
      },
    }
  </script>
  <!-- [END] BAGIAN YANG DIPERBAIKI -->

  <style>
    .font-display { font-family: 'Playfair Display', serif; }
    .font-sans { font-family: 'Manrope', sans-serif; }
  </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-sans text-text-light dark:text-text-dark">
  <div class="relative flex h-auto min-h-screen w-full overflow-hidden">
    
    <!-- Memanggil Sidebar Partial -->
    <?= $this->include('partials/admin_sidebar') ?>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
      
      <!-- Memanggil Header Partial -->
      <?= $this->include('partials/admin_header') ?>

      <!-- Area Konten Dinamis -->
      <main class="flex-1 px-4 sm:px-6 md:px-8 py-6">
        <div class="max-w-7xl mx-auto">
            <?= $this->renderSection('content') ?>
        </div>
      </main>
    </div>
  </div>
</body>
</html>