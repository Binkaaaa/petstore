<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    {{-- Vite: include your compiled CSS (and JS if you need it) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    {{-- sidebar, header, etc. --}}

    <main>
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>
