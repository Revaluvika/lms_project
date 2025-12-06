

<?php $__env->startSection('content'); ?>
<div class="p-6">

    
    <h1 class="text-2xl font-bold mb-6">Pengaturan Akun</h1>

    
    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-6">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($err); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <div class="bg-white shadow p-6 rounded mb-8">
        <h2 class="text-xl font-semibold mb-4">Perbarui Profil</h2>

        <form method="POST" action="<?php echo e(route('settings.updateProfile')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="font-medium">Nama</label>
                <input type="text" name="name" value="<?php echo e($user->name); ?>"
                       class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="font-medium">Email</label>
                <input type="email" name="email" value="<?php echo e($user->email); ?>"
                       class="w-full border p-2 rounded" required>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>
    </div>

    
    <div class="bg-white shadow p-6 rounded">
        <h2 class="text-xl font-semibold mb-4">Ganti Password</h2>

        <form method="POST" action="<?php echo e(route('settings.updatePassword')); ?>">
            <?php echo csrf_field(); ?>

            <div class="mb-4">
                <label class="font-medium">Password Saat Ini</label>
                <input type="password" name="current_password"
                       class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="font-medium">Password Baru</label>
                <input type="password" name="password"
                       class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="font-medium">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation"
                       class="w-full border p-2 rounded" required>
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Ubah Password
            </button>
        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lms_project\resources\views/pages/settings/index.blade.php ENDPATH**/ ?>