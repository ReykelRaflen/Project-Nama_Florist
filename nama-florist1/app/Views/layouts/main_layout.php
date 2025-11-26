<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= $this->renderSection('title') ?> - Nama Florist</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    
    <!-- ========================================================== -->
    <!-- [PERUBAHAN] FONT FAMILY SEKARANG KONSISTEN -->
    <!-- ========================================================== -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet" />

    <!-- ========================================================== -->
    <!-- [PERUBAHAN] TAILWIND CONFIG SEKARANG KONSISTEN -->
    <!-- ========================================================== -->
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
    
    <style>
        .font-display { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Manrope', sans-serif; }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-background-light dark:bg-background-dark font-sans text-text-light dark:text-text-dark">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            
            <!-- Memanggil Header Partial -->
            <?= $this->include('partials/header') ?>

            <!-- Main Content -->
            <!-- Tag <main> sekarang ada di dalam setiap view (homepage, katalog, dll) -->
            <?= $this->renderSection('content') ?>

            <!-- Memanggil Footer Partial -->
            <?= $this->include('partials/footer') ?>
            
        </div>
    </div>

    <?= $this->renderSection('scripts') ?>
</body>
</html>