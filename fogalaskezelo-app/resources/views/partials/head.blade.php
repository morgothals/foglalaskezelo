


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF token a JavaScript-hez és formokhoz -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<!-- Vite-compiled CSS és JS -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Livewire stílusok -->
@livewireStyles

