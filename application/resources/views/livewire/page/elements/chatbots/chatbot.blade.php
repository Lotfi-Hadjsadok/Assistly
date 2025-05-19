@php
    $size = match ($size) {
        'xs' => 'xs',
        'sm' => 'sm',
        default => 'sm',
    };
    $iconSize = match ($size) {
        'xs' => 'size-6',
        'sm' => 'size-7',
        default => 'size-6',
    };
    $headlineSize = match ($size) {
        'xs' => 'text-lg',
        'sm' => 'text-xl',
        default => 'text-xl',
    };
    $descriptionSize = match ($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        default => 'text-sm',
    };
    $buttonSize = match ($size) {
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        default => 'text-sm',
    };
@endphp

<div x-data="{
    showChat: {{ $preview ? 'true' : 'false' }}
}"
    style="height: {{ $height }}; width: {{ $width }};min-width: {{ $width }};"
    class="flex-col flex relative justify-end">
    <div x-cloak x-transition x-show="showChat"
        class="relative flex flex-col  justify-between overflow-hidden h-full bg-white! p-0! border-none rounded-3xl!">
        <div @if ($preview) :style="{
            background: 'linear-gradient(to right, ' + normalizeHex($wire.$parent.chatbotForm.settings.brand_color) + ', ' +
                normalizeHex($wire.$parent.chatbotForm.settings.brand_color) + 'B3)'
        }" @endif
            style="background: linear-gradient(to right, {{ normalizeHex($chatbot->settings['brand_color']) }}, {{ normalizeHex($chatbot->settings['brand_color']) }}B3)"
            class="space-y-4 p-8 text-center">
            <flux:heading>
                <span class="{{ $headlineSize }}"
                    @if ($preview) wire:text='$parent.chatbotForm.settings.headline' @endif>{{ $chatbot->settings['headline'] }}</span>
            </flux:heading>
            <flux:text class="text-white">
                <span class="{{ $descriptionSize }}"
                    @if ($preview) wire:text='$parent.chatbotForm.settings.description' @endif>{{ $chatbot->settings['description'] }}</span>
            </flux:text>
            <div>
                <flux:button icon="chat-bubble-bottom-center-text" variant="primary"
                    class="rounded-lg bg-black/40 hover:bg-black/20 shadow-none! border-none!">
                    <flux:text class="text-white! {{ $buttonSize }}">New chat</flux:text>
                </flux:button>
                <flux:button icon="question-mark-circle" variant="primary"
                    class="rounded-lg bg-black/40 hover:bg-black/20 shadow-none! border-none!">
                    <flux:text class="text-white! {{ $buttonSize }}">See FAQ</flux:text>
                </flux:button>
            </div>


        </div>

        <div class="p-5 space-y-4 flex-1 overflow-auto">
            @foreach ($messages as $index => $message)
                <x-chatbots.chatbot.message :$size :content="$message['content']" :role="$message['role']" :chatbot="$chatbot"
                    :preview="$preview" :is_welcome_message="true" />
            @endforeach
        </div>

        <div class="p-2 bottom-0 flex flex-col justify-between left-0  bg-gray-100 right-0">
            <flux:card class="bg-white! p-0! ring-1! ring-gray-300/50! flex  items-center justify-between w-full">
                <flux:input class:input="text-black!" class="p-1" size="{{ $size }}"
                    placeholder="Type your message here..." />
                <flux:button icon="paper-airplane" size="{{ $size }}" class="text-black!" variant="ghost" />
            </flux:card>
            <div class="flex gap-1 items-center  justify-center mt-2">
                <flux:text class="text-gray-500 text-[10px]">
                    Powered by
                </flux:text>
                <flux:text class="text-accent font-bold text-[11px]">
                    Assitly
                </flux:text>
            </div>
            <div>
            </div>
        </div>
    </div>

    <div @class([
        'flex',
        'justify-end' => $chatbot->settings['orientation'] == 'right',
        'justify-start' => $chatbot->settings['orientation'] == 'left',
    ])
        @if ($preview) :class="$wire.$parent.chatbotForm.settings.orientation == 'right' ? 'justify-end' : 'justify-start'" @endif>
        <button @click="showChat = !showChat"
            @if ($preview) :style="{
                background: $wire.$parent.chatbotForm.settings.brand_color
            }" @endif
            style="background: {{ $chatbot->settings['brand_color'] }}"
            class="w-fit p-4 mt-4 rounded-full flex items-center justify-center">
            <x-chatbots.chatbot.bot-icon x-cloak x-show="!showChat" class="text-white {{ $iconSize }}!" />
            <flux:icon x-cloak x-show="showChat" name="x-mark" class="text-white {{ $iconSize }}!"></flux:icon>
        </button>
    </div>
</div>
