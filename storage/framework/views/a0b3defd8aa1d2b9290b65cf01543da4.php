

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Dashboard Orang Tua</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            <?php echo $__env->make('components.icons.profil', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div>
                <h2 class="font-bold text-xl">Ananda</h2>
                <p class="text-gray-500">Lihat Profil</p>
            </div>
        </div>

        
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            <?php echo $__env->make('components.icons.nilai', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div>
                <h2 class="font-bold text-xl">88%</h2>
                <p class="text-gray-500">Rata-rata Nilai</p>
            </div>
        </div>

        
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            <?php echo $__env->make('components.icons.pesan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div>
                <h2 class="font-bold text-xl">3</h2>
                <p class="text-gray-500">Pesan Baru</p>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lms_project\resources\views/dashboard/orang-tua.blade.php ENDPATH**/ ?>