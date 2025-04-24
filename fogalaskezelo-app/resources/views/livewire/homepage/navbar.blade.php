<header x-data="{
        open: false,
        scrollToSection(id) {
            const el = document.querySelector(`#${id}`);
            const y = el.getBoundingClientRect().top + window.pageYOffset - 100;
            window.scrollTo({ top: y, behavior: 'smooth' });
            this.open = false; // Menü zárása mobilon
        }
    }" class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="text-xl font-bold">Fodrászat</div>

        <!-- Hamburger (mobil) -->
        <button @click="open = !open" class="md:hidden text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Navigációs linkek (asztali) -->
        <nav class="space-x-4 hidden md:block">
            <a href="#hero" @click.prevent="scrollToSection('hero')" class="hover:text-blue-600">Főoldal</a>
            <a href="#services" @click.prevent="scrollToSection('services')"
                class="hover:text-blue-600">Szolgáltatások</a>
            <a href="#salon" @click.prevent="scrollToSection('salon')" class="hover:text-blue-600">Szalon</a>
            <a href="#about" @click.prevent="scrollToSection('about')" class="hover:text-blue-600">Rólunk</a>
            <a href="#gallery" @click.prevent="scrollToSection('gallery')" class="hover:text-blue-600">Galéria</a>
            <a href="#footer" @click.prevent="scrollToSection('footer')" class="hover:text-blue-600">Kapcsolat</a>
            <a href="/foglalasok" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Időpontfoglalás
            </a>
        </nav>
    </div>

    <!-- Mobil navigáció -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4" @click.away="open = false"
        class="md:hidden px-4 pb-4 space-y-2">
        <a href="#hero" @click.prevent="scrollToSection('hero')" class="block hover:text-blue-600">Főoldal</a>
        <a href="#services" @click.prevent="scrollToSection('services')"
            class="block hover:text-blue-600">Szolgáltatások</a>
        <a href="#salon" @click.prevent="scrollToSection('salon')" class="block hover:text-blue-600">Szalon</a>
        <a href="#about" @click.prevent="scrollToSection('about')" class="block hover:text-blue-600">Rólunk</a>
        <a href="#gallery" @click.prevent="scrollToSection('gallery')" class="block hover:text-blue-600">Galéria</a>
        <a href="#footer" @click.prevent="scrollToSection('footer')" class="block hover:text-blue-600">Kapcsolat</a>
        <a href="/foglalasok" @click="open = false"
            class="block mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Időpontfoglalás
        </a>
    </div>

</header>