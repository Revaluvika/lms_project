

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Dashboard Kepala Sekolah</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            <?php echo $__env->make('components.icons.data-guru', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div>
                <h2 class="text-xl font-bold">25</h2>
                <p class="text-gray-500">Total Guru</p>
            </div>
        </div>

        
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            <?php echo $__env->make('components.icons.data-siswa', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div>
                <h2 class="text-xl font-bold">340</h2>
                <p class="text-gray-500">Jumlah Siswa</p>
            </div>
        </div>

        
        <div class="bg-white shadow rounded-xl p-6 flex items-center space-x-4">
            <?php echo $__env->make('components.icons.laporan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div>
                <h2 class="text-xl font-bold">12</h2>
                <p class="text-gray-500">Laporan Baru</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lms_project\resources\views/dashboard/kepala-sekolah.blade.php ENDPATH**/ ?>