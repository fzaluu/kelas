<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'XI PPLG 2 - Class Portal'); ?></title>

    <!-- Tailwind CSS Engine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js Interactivity Engine -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom CSS Animations (Terpisah) -->
    <link rel="stylesheet" href="<?php echo e(asset('css/animations.css')); ?>">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    <?php echo $__env->make('partials.public-navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="flex-grow pt-16">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('partials.public-footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html> <?php /**PATH C:\laragon\www\website-pplg\resources\views/layouts/public.blade.php ENDPATH**/ ?>