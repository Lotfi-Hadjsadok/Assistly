<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="height: 100%; width: 100%; margin: 0; padding: 0;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title> {{-- You can set a more dynamic title if needed --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: end;
            align-items: end;
            overflow: hidden;

        }
    </style>
</head>

<body>
    <livewire:page.elements.chatbots.chatbot size="xs" height="70%" width="350px" :chatbot="$chatbot"
        :preview="false" />
</body>

</html>
