

<?php $__env->startSection('title', 'LearnFlux - Smart Learning Management System'); ?>

<?php $__env->startSection('content'); ?>
<!-- HERO SECTION -->
<section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-24">
  <div class="max-w-7xl mx-auto text-center px-6">
    <h1 class="text-4xl md:text-6xl font-extrabold mb-6">Revolusi Pembelajaran Digital</h1>
    <p class="text-lg md:text-xl text-blue-100 mb-8">
      LearnFlux membantu sekolah bertransformasi menjadi ekosistem digital terpadu untuk guru, siswa, dan orang tua.
    </p>
    <a href="<?php echo e(route('login.role', ['role' => 'siswa'])); ?>" class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-blue-100 transition">
      Mulai Sekarang
    </a>
  </div>
</section>

<!-- FITUR UNGGULAN -->
<section class="py-20 bg-gray-50">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold mb-10 text-gray-800">Fitur Unggulan LearnFlux</h2>
    <div class="grid md:grid-cols-3 gap-10">
      <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
        <img src="<?php echo e(asset('assets/icons/classroom.svg')); ?>" alt="Kelas Digital" class="w-16 mx-auto mb-4">
        <h3 class="text-xl font-semibold mb-2 text-blue-700">Kelas Digital</h3>
        <p class="text-gray-600">Pengelolaan kelas interaktif dengan materi, tugas, dan evaluasi langsung.</p>
      </div>
      <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
        <img src="<?php echo e(asset('assets/icons/report.svg')); ?>" alt="Pelaporan Otomatis" class="w-16 mx-auto mb-4">
        <h3 class="text-xl font-semibold mb-2 text-blue-700">Pelaporan Otomatis</h3>
        <p class="text-gray-600">Guru dapat membuat laporan perkembangan siswa secara cepat dan efisien.</p>
      </div>
      <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
        <img src="<?php echo e(asset('assets/icons/parents.svg')); ?>" alt="Monitoring Orang Tua" class="w-16 mx-auto mb-4">
        <h3 class="text-xl font-semibold mb-2 text-blue-700">Monitoring Orang Tua</h3>
        <p class="text-gray-600">Orang tua bisa melihat nilai, absensi, dan perkembangan anak secara real-time.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA SECTION -->
<section class="bg-blue-600 py-20 text-white">
  <div class="max-w-5xl mx-auto text-center">
    <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Membawa Sekolah Anda ke Era Digital?</h2>
    <p class="text-blue-100 mb-8">Mulai gunakan LearnFlux hari ini dan tingkatkan kualitas pembelajaran sekolah Anda.</p>
    <a href="<?php echo e(route('login.role', ['role' => 'kepala-sekolah'])); ?>" class="bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-blue-100 transition">
      Daftar Sekarang
    </a>
  </div>
</section>

<!-- FOOTER -->
<footer class="bg-gray-900 text-gray-300 py-10">
  <div class="max-w-6xl mx-auto px-6 text-center">
    <h3 class="text-2xl font-semibold text-white mb-2">LearnFlux LMS</h3>
    <p class="mb-6 text-gray-400">© <?php echo e(date('Y')); ?> LearnFlux. Semua Hak Dilindungi.</p>
    <div class="flex justify-center space-x-6">
      <a href="#" class="hover:text-white">Kebijakan Privasi</a>
      <a href="#" class="hover:text-white">Syarat & Ketentuan</a>
      <a href="#" class="hover:text-white">Kontak</a>
    </div>
  </div>
</footer>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\lms_project\resources\views/pages/home.blade.php ENDPATH**/ ?>