<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
        }
    </style>
</head>

<body>
    @php
        $chatbot = \App\Models\Chatbot::latest()->first();
        // You might want to pass messages dynamically or fetch them based on a parameter
        $chatbot->messages = [
            [
                'role' => 'user',
                'content' => 'Hello!',
            ],
            [
                'role' => 'assistant',
                'content' => 'Hi there! How can I help you today?',
            ],
        ];
    @endphp

    <div>
        <livewire:page.elements.chatbots.chatbot size="xs" height="100vh" width="100%" :$chatbot
            :preview="false" />
    </div>
</body>

</html>
