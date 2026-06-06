<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <x-seo::meta />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @seo([
        'title' => 'yourjourneyvoices',
        'description' => 'yourjourneyvoices',
        'image' => asset('images/login-image.png'),
        'site_name' => config('app.name'),
        'favicon' => asset('favicon.ico'),
    ])

    <meta  href="{{ asset('favicon.ico') }}"  rel="icon" />

    <title>yourjourneyvoices</title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')

    @livewireStyles
</head>

<body class="h-full !font-['Poppins']">
    <div
        id="page-loading-bar"
        class="z-50 fixed top-0 left-0 w-full hidden pointer-events-none"
        aria-hidden="true"
    >
        <div class="bg-gradient-to-r from-gray-800 from-70% to-orange-500 h-1 w-full"></div>
    </div>

    {{ $slot }}

</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var bar = document.getElementById('page-loading-bar');
        if (!bar) return;

        bar.classList.remove('hidden');

        setTimeout(function () {
            bar.classList.add('hidden');
        }, 400);
    });
</script>

@yield('scripts')
@livewireScripts

<x-cookie-consent />

</html>
