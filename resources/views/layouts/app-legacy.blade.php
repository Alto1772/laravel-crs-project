@props(['title' => 'Landing Page'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" href="{{ Vite::asset('resources/images/crs-logo.png') }}" type="image/x-icon" />

    <!-- Fonts -->
    @vite('webfonts.css')
    {{-- @include("layouts.sections.fonts") --}}

    @vite(['resources/css/app-legacy.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    {{--
            <main
            {{ $attributes->merge(["class" => "min-h-screen px-3 sm:px-0"]) }}
            >
            {{ $slot }}
            </main>
        --}}
    @yield('content')

    <!-- Scripts -->
    <!-- Vendor Scripts -->

    <!-- Page Scripts -->
    @stack('page-scripts')
    {{-- @include("layouts.sections.scripts") --}}
</body>

</html>
