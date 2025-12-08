<div class="fixed top-0 left-64 right-0 bg-white shadow h-16 flex items-center justify-between px-6 z-40">

    {{-- Judul Halaman --}}
    <h2 class="text-xl font-semibold capitalize">
        Dashboard {{ str_replace('_', ' ', Auth::user()->role->label()) }}
    </h2>

    {{-- Bagian Kanan --}}
    <div class="flex items-center gap-6">

        {{-- NOTIFIKASI (DISABLED)
        <a href="{{ route('notif.index') }}" class="relative">
            @include('components.icons.notifikasi')

            @php
                $notifCount = \App\Models\Message::where('user_id', Auth::id())->where('is_read', false)->count();

            @endphp

            @if ($notifCount > 0)
                <span id="notif-badge"
                    class="absolute -top-1 -right-1 bg-red-600 text-white text-xs 
                        rounded-full w-5 h-5 flex items-center justify-center">
                    {{ $notifCount }}
                </span>
            @endif
        </a>
        --}}

        {{-- PESAN (DISABLED)
        <a href="{{ route('chat.index') }}" class="relative">
            @include('components.icons.pesan')

            @php
                $msgCount = \App\Models\Message::where('user_id', Auth::id())->where('is_read', false)->count();
            @endphp

            @if ($msgCount > 0)
                <span id="chat-badge"
                    class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs 
                        rounded-full w-5 h-5 flex items-center justify-center">
                    {{ $msgCount }}
                </span>
            @endif
        </a>
        --}}

        {{-- PROFIL DROPDOWN --}}
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2">
                @include('components.icons.profil')
                <span>{{ Auth::user()->name }}</span>
            </button>

            {{-- Dropdown --}}
            <div x-show="open" @click.outside="open = false"
                class="absolute right-0 mt-2 w-40 bg-white shadow rounded py-2 border z-50">

                <a href="{{ route('settings.index') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm">
                    Pengaturan
                </a>

                <a href="{{ route('logout') }}" class="block px-4 py-2 hover:bg-gray-100 text-sm text-red-600">
                    Logout
                </a>
            </div>
        </div>

    </div>
</div>


{{-- POLLING NOTIF & CHAT (DISABLED) --}}
{{-- 
<script>
    setInterval(() => {
        // Notifikasi
        fetch("{{ route('notif.count') }}")
            .then(r => r.json())
            .then(d => {
                const badge = document.getElementById('notif-badge');
                if (badge) {
                    badge.innerText = d.count;
                    badge.style.display = d.count > 0 ? 'flex' : 'none';
                }
            });

        // Chat
        fetch("{{ route('chat.count') }}")
            .then(r => r.json())
            .then(d => {
                const badge = document.getElementById('chat-badge');
                if (badge) {
                    badge.innerText = d.count;
                    badge.style.display = d.count > 0 ? 'flex' : 'none';
                }
            });
    }, 3000);
</script>
--}}
