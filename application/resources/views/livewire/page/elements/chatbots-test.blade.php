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
<div class="relative">
    <div class="fixed bottom-0 right-0 flex items-end p-5 h-full">
        <iframe src="http://localhost:81/embed/chatbot" width="350" height="70%" style="border:none;"></iframe>
    </div>

</div>
