<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface dark:bg-surface">
    <x-sidebar class="min-h-screen bg-surface-dark/30 dark:bg-surface-dark">
        {{ $slot }}
    </x-sidebar>
    @fluxScripts
    <flux:toast />
</body>

</html>
