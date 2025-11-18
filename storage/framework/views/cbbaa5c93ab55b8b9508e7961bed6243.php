

<?php $__env->startSection('title', 'Login - ' . ucfirst($role)); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
  <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-blue-700 mb-6">
      Login Sebagai <?php echo e(ucfirst(str_replace('-', ' ', $role))); ?>

    </h2>

    <form method="POST" action="<?php echo e(route('login.submit')); ?>" class="space-y-4">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="role" value="<?php echo e($role); ?>">
      <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1">Email</label>
        <input type="email" name="email" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-600 mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
        Masuk
      </button>
    </form>

    <div class="mt-6 text-center">
      <a href="<?php echo e(route('home')); ?>" class="text-sm text-blue-600 hover:underline">← Kembali ke Beranda</a>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lms_project\resources\views/auth/login.blade.php ENDPATH**/ ?>