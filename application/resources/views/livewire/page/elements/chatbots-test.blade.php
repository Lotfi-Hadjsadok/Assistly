<div class="space-y-6">
    <div>
        <flux:heading size="xl">{{ __('Chatbots') }}</flux:heading>
        <flux:text class="mt-2">{{ __('Test your chatbot integration here.') }}</flux:text>
        <flux:separator variant="subtle" class="my-8" />
    </div>

    <!-- Chat Container -->
    <div class="max-w-3xl mx-auto">
        <flux:card class="h-[600px] flex flex-col">
            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages">
                @foreach ($messages as $message)
                    <div class="flex {{ $message['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                        <div
                            class="{{ $message['role'] === 'user' ? 'bg-accent text-white' : 'bg-gray-100 dark:bg-surface' }} rounded-lg px-4 py-2 max-w-[80%]">
                            <flux:text>{{ $message['content'] }}</flux:text>
                        </div>
                    </div>
                @endforeach

                @if ($isTyping)
                    <div class="flex justify-start">
                        <div class="bg-gray-100 dark:bg-surface  rounded-lg px-4 py-2">
                            <flux:text>{{ __('Typing...') }}</flux:text>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Chat Input -->
            <div class="p-4 border-t">
                <form wire:submit="sendMessage" class="flex gap-2">
                    <div class="flex-1">
                        <flux:input wire:model="newMessage" placeholder="{{ __('Type your message...') }}"
                            class="w-full" />
                    </div>
                    <flux:button type="submit" variant="primary">
                        {{ __('Send') }}
                    </flux:button>
                </form>
            </div>
        </flux:card>
    </div>
</div>

<!-- Script to scroll to bottom on new messages -->
<script>
    document.addEventListener('livewire:initialized', () => {
        const scrollToBottom = () => {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        };

        // Scroll on new messages
        Livewire.on('botThinking', () => {
            scrollToBottom();
        });

        // Initial scroll
        scrollToBottom();
    });
</script>
