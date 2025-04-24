<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <title>Időpontfoglalás</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs"></script>
</head>

<body class="font-sans antialiased scroll-smooth">



    <!-- Szekciók -->
    @livewire('booking.hero-section')
    @livewire('booking.services-section')
    @livewire('booking.staff-section')
    <section id="contact-opening-hours" class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-8">
            @livewire('booking.contact-section')
            @livewire('booking.opening-hours-section')
        </div>
    </section>

    @livewire('homepage.footer-section')

</body>

</html>