@php
    $chatbot = \App\Models\Chatbot::first();
    $chatbot->messages = [
        [
            'role' => 'user',
            'content' => 'Hello! I am lotfi',
        ],
        [
            'role' => 'assistant',
            'content' => 'Hello! I am lotfi
            hihihi
            ',
        ],
        [
            'role' => 'user',
            'content' => 'Hello! I am lotfi',
        ],
        [
            'role' => 'user',
            'content' => 'Hello! I am lotfi',
        ],
        [
            'role' => 'user',
            'content' => 'Hello! I am lotfi',
        ],
        [
            'role' => 'user',
            'content' => 'Hello! I am lotfi',
        ],
        [
            'role' => 'user',
            'content' => 'Hello! I am lotfi',
        ],
    ];
@endphp
<iframe style="position: fixed;bottom:0;right:0;align-items:end;height:100%;width:100%;padding:20px" width="100%"
    height="100%" src="{{ route('chatbot.embed', ['chatbot' => 5]) }}"></iframe>
