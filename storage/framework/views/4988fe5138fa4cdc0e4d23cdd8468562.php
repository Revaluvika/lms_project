

<?php $__env->startSection('content'); ?>
<h2 class="text-2xl font-semibold mb-4">Daftar Nilai Yang Anda Input</h2>

<a href="<?php echo e(route('nilai.create')); ?>" 
   class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
    + Tambah Nilai
</a>

<div class="bg-white rounded shadow p-4">
    <table class="w-full table-auto">
        <thead class="border-b">
            <tr>
                <th class="py-2">Siswa</th>
                <th>Mapel</th>
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
            <?php $__currentLoopData = $nilai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="border-b">
                <td class="py-2"><?php echo e($n->siswa->name); ?></td>
                <td><?php echo e($n->mapel); ?></td>
                <td><?php echo e($n->nilai); ?></td>
                <td><?php echo e($n->keterangan); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lms_project\resources\views/pages/nilai/index.blade.php ENDPATH**/ ?>