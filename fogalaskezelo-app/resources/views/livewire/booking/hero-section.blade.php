@php
$heroBackground = asset('images/szalon-hero.jpeg');
@endphp
<section id="hero" class="relative h-[70vh] md:h-[90vh] w-full bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ $heroBackground }}');">
    <!-- Áttetsző sötét réteg -->
    <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
        <div class="text-center px-4">
            <div class="max-w-4xl mx-auto space-y-6">
                <!-- Szalon neve -->
                <h1 class="text-white text-4xl md:text-6xl font-bold">
                    Create Salon
                </h1>

                <!-- Gomb -->
                <a href="/idopontfoglalas"
                    class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold text-lg px-6 py-3 rounded shadow-md transition-all duration-300">
                    Foglalás most
                </a>
            </div>
        </div>
    </div>
</section>
