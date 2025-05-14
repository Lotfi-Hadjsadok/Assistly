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
        <x-chatbots.chatbot size="xs" height="70%" width="350px" :$chatbot :preview="false" />
    </div>

</div>
