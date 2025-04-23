<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <title>Fodrászat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs"></script>
</head>

<body class="font-sans antialiased scroll-smooth">

    <!-- Navigációs sáv -->
    @livewire('homepage.navbar')

    <!-- Szekciók -->
    @livewire('homepage.hero-section')
    @livewire('homepage.services-section')
    @livewire('homepage.salon-section')
    @livewire('homepage.about-section')
    @livewire('homepage.gallery-section')
    @livewire('homepage.footer-section')

</body>

</html>
