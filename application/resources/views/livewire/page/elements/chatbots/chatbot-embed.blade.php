<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<style>
    body {
        position: fixed;
        display: flex;
        justify-content: end;
        align-items: end;
        padding: 20px;
        width: 100%;
        height: 100%;
    }
</style>

<livewire:page.elements.chatbots.chatbot :chatbot="$chatbot" :preview="false" width="400px" height="700px" />
@fluxScripts
@livewireScripts

</html>