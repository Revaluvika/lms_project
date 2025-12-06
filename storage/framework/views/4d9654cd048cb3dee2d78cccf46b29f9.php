

<?php $__env->startSection('title', 'LearnFlux - Smart Learning Management System'); ?>

<?php $__env->startSection('content'); ?>
<section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-24 min-h-screen">
  <div class="max-w-6xl mx-auto px-6 text-center">

    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-4">
      Selamat Datang di LearnFlux LMS
    </h1>
    <p class="text-lg text-gray-600 mb-12">
      Pilih peran Anda untuk masuk ke sistem
    </p>

    <div class="grid md:grid-cols-3 gap-8">

      
      <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
        <div class="flex justify-center mb-4">
          <?php if (isset($component)) { $__componentOriginal2c2c192acd488946b7eefc0abdfa83e5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2c2c192acd488946b7eefc0abdfa83e5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.dinas','data' => ['class' => 'w-16 h-16 text-blue-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.dinas'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 text-blue-700']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2c2c192acd488946b7eefc0abdfa83e5)): ?>
<?php $attributes = $__attributesOriginal2c2c192acd488946b7eefc0abdfa83e5; ?>
<?php unset($__attributesOriginal2c2c192acd488946b7eefc0abdfa83e5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2c2c192acd488946b7eefc0abdfa83e5)): ?>
<?php $component = $__componentOriginal2c2c192acd488946b7eefc0abdfa83e5; ?>
<?php unset($__componentOriginal2c2c192acd488946b7eefc0abdfa83e5); ?>
<?php endif; ?>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Dinas Pendidikan</h3>
        <p class="text-gray-600 mb-6">Monitoring dan manajemen seluruh sekolah</p>
        <a href="<?php echo e(route('login.role', ['role' => 'dinas'])); ?>" class="block bg-blue-900 text-white font-semibold py-2 rounded-lg hover:bg-blue-800 transition">
          Masuk Sebagai Dinas Pendidikan
        </a>
      </div>

      
      <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
        <div class="flex justify-center mb-4">
          <?php if (isset($component)) { $__componentOriginala4a85666b80fe6642c90011306fd168d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala4a85666b80fe6642c90011306fd168d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.kepsek','data' => ['class' => 'w-16 h-16 text-blue-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.kepsek'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 text-blue-700']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala4a85666b80fe6642c90011306fd168d)): ?>
<?php $attributes = $__attributesOriginala4a85666b80fe6642c90011306fd168d; ?>
<?php unset($__attributesOriginala4a85666b80fe6642c90011306fd168d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala4a85666b80fe6642c90011306fd168d)): ?>
<?php $component = $__componentOriginala4a85666b80fe6642c90011306fd168d; ?>
<?php unset($__componentOriginala4a85666b80fe6642c90011306fd168d); ?>
<?php endif; ?>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Kepala Sekolah</h3>
        <p class="text-gray-600 mb-6">Kelola kinerja guru dan monitoring siswa</p>
        <a href="<?php echo e(route('login.role', ['role' => 'kepala_sekolah'])); ?>" class="block bg-blue-900 text-white font-semibold py-2 rounded-lg hover:bg-blue-800 transition">
          Masuk Sebagai Kepala Sekolah
        </a>
      </div>

      
      <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
        <div class="flex justify-center mb-4">
          <?php if (isset($component)) { $__componentOriginal3c804e9f04f1c79a9b7fddeae9bb0daa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c804e9f04f1c79a9b7fddeae9bb0daa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.guru','data' => ['class' => 'w-16 h-16 text-blue-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.guru'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 text-blue-700']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c804e9f04f1c79a9b7fddeae9bb0daa)): ?>
<?php $attributes = $__attributesOriginal3c804e9f04f1c79a9b7fddeae9bb0daa; ?>
<?php unset($__attributesOriginal3c804e9f04f1c79a9b7fddeae9bb0daa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c804e9f04f1c79a9b7fddeae9bb0daa)): ?>
<?php $component = $__componentOriginal3c804e9f04f1c79a9b7fddeae9bb0daa; ?>
<?php unset($__componentOriginal3c804e9f04f1c79a9b7fddeae9bb0daa); ?>
<?php endif; ?>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Guru</h3>
        <p class="text-gray-600 mb-6">Buat kelas, upload materi, dan kelola siswa</p>
        <a href="<?php echo e(route('login.role', ['role' => 'guru'])); ?>" class="block bg-blue-900 text-white font-semibold py-2 rounded-lg hover:bg-blue-800 transition">
          Masuk Sebagai Guru
        </a>
      </div>

      
      <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
        <div class="flex justify-center mb-4">
          <?php if (isset($component)) { $__componentOriginal72b6875c2fd25bd21f7af5d813168d8a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal72b6875c2fd25bd21f7af5d813168d8a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.siswa','data' => ['class' => 'w-16 h-16 text-blue-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.siswa'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 text-blue-700']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal72b6875c2fd25bd21f7af5d813168d8a)): ?>
<?php $attributes = $__attributesOriginal72b6875c2fd25bd21f7af5d813168d8a; ?>
<?php unset($__attributesOriginal72b6875c2fd25bd21f7af5d813168d8a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal72b6875c2fd25bd21f7af5d813168d8a)): ?>
<?php $component = $__componentOriginal72b6875c2fd25bd21f7af5d813168d8a; ?>
<?php unset($__componentOriginal72b6875c2fd25bd21f7af5d813168d8a); ?>
<?php endif; ?>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Siswa</h3>
        <p class="text-gray-600 mb-6">Akses kelas, kerjakan tugas, dan ikuti ujian</p>
        <a href="<?php echo e(route('login.role', ['role' => 'siswa'])); ?>" class="block bg-blue-900 text-white font-semibold py-2 rounded-lg hover:bg-blue-800 transition">
          Masuk Sebagai Siswa
        </a>
      </div>

      
      <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
        <div class="flex justify-center mb-4">
          <?php if (isset($component)) { $__componentOriginald1449c8468e0e303a6703d327998eb8a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald1449c8468e0e303a6703d327998eb8a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.orangtua','data' => ['class' => 'w-16 h-16 text-blue-700']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.orangtua'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-16 h-16 text-blue-700']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald1449c8468e0e303a6703d327998eb8a)): ?>
<?php $attributes = $__attributesOriginald1449c8468e0e303a6703d327998eb8a; ?>
<?php unset($__attributesOriginald1449c8468e0e303a6703d327998eb8a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald1449c8468e0e303a6703d327998eb8a)): ?>
<?php $component = $__componentOriginald1449c8468e0e303a6703d327998eb8a; ?>
<?php unset($__componentOriginald1449c8468e0e303a6703d327998eb8a); ?>
<?php endif; ?>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Orang Tua</h3>
        <p class="text-gray-600 mb-6">Pantau perkembangan dan nilai anak</p>
        <a href="<?php echo e(route('login.role', ['role' => 'orang_tua'])); ?>" class="block bg-blue-900 text-white font-semibold py-2 rounded-lg hover:bg-blue-800 transition">
          Masuk Sebagai Orang Tua
        </a>
      </div>

    </div>
  </div>
</section>


<footer class="bg-gray-900 text-gray-300 py-8 text-center">
  <h3 class="text-xl font-semibold text-white">LearnFlux LMS</h3>
  <p class="text-gray-400 mt-2">© <?php echo e(date('Y')); ?> LearnFlux — Semua Hak Dilindungi</p>
</footer>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lms_project\resources\views/pages/home.blade.php ENDPATH**/ ?>