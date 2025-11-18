<div class="w-full bg-white shadow-sm fixed left-64 top-0 h-16 flex items-center justify-between px-6">

    <div class="flex items-center space-x-4">
        <h2 class="text-xl font-semibold capitalize">Dashboard {{ str_replace('_', ' ', Auth::user()->role) }}</h2>
    </div>

    <div class="flex items-center space-x-6">
        <div class="cursor-pointer">
            {!! file_get_contents(public_path('icons/notifikasi.svg')) !!}
        </div>

        <div class="cursor-pointer">
            {!! file_get_contents(public_path('icons/pesan.svg')) !!}
        </div>

        <div class="flex items-center space-x-2">
            {!! file_get_contents(public_path('icons/profil.svg')) !!}
            <span>{{ Auth::user()->name }}</span>
        </div>
    </div>

</div>
