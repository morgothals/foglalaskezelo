<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ha Livewire layoutból kapott 'title' változó nem üres, azt használjuk,
         egyébként megnézzük a Yieldelt 'title' szekciót, default 'Admin' -->
    <title>{{ $title ?? $__env->yieldContent('title', 'Admin') }} – Foglaláskezelő</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow mb-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center h-16">
                <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl mr-6">Admin</a>
                <a href="{{ route('admin.availability.index') }}"
                    class="text-gray-700 hover:text-gray-900 mr-4">Elérhetőség</a>
                <!-- Ide további menüpontok -->
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    @livewireScripts
</body>

</html>
