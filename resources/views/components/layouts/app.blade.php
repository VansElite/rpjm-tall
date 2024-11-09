<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>
    <script src='https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.css' rel='stylesheet' />

    <!--- for dark mode --> <script src="https://cdn.jsdelivr.net/npm/theme-change@2.0.2/index.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    <livewire:navbar>
        {{-- NAVBAR mobile only
        <x-nav sticky class="lg:hidden">
            <x-slot:brand>
                <x-app-brand />
            </x-slot:brand>
            <x-slot:actions>
                <label for="main-drawer" class="lg:hidden me-3">
                    <x-icon name="o-bars-3" class="cursor-pointer" />
                </label>
            </x-slot:actions>
        </x-nav> --}}

        {{-- MAIN --}}
        <x-main with-nav full-width>
            {{-- SIDEBAR --}}
            <livewire:sidebar>


                {{-- The `$slot` goes here --}}
                <x-slot:content full-width full-height>
                    {{ $slot }}
                </x-slot:content>
        </x-main>

        {{-- TOAST area --}}
        <x-toast />
</body>

</html>
