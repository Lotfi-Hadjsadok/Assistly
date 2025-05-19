<?php
$sizeClass = match ($size) {
    'xs' => 'text-xs',
    'sm' => 'text-sm',
    default => 'text-xs',
};

$iconSize = match ($size) {
    'xs' => 'size-5',
    'sm' => 'size-6',
    default => 'size-5',
};

?>

<div wire:ignore x-init="window.addEventListener('sendMessage', (e) => {
    messages.push({
        content: e.detail.content,
        role: e.detail.role,
    });
    loading = e.detail.role == 'user' ? true : false;
    $nextTick(() => { $refs.messagesContainer.scrollTop = $refs.messagesContainer.scrollHeight; });
});"
    x-data='{
    messages: @json($messages),
    chatbot: @json($chatbot),
    preview: @json($preview),
    loading:false
}'
    class="p-3 space-y-3 flex-1 overflow-auto">
    <template x-for="(message, index) in messages" :key="index">
        <div class="flex gap-4 group" :class="message.role === 'assistant' ? 'justify-start' : 'justify-end'">

            <div x-show="message.role === 'assistant'"
                :style="{
                    background: preview ?
                        $wire.$parent.chatbotForm.settings.brand_color : chatbot.settings.brand_color
                }"
                class="w-fit h-fit p-2 rounded-full flex items-center justify-center">
                <x-chatbots.chatbot.bot-icon class="text-white {{ $iconSize }}" />
            </div>

            <div :style="{
                background: preview && message.role === 'user' ?
                    $wire.$parent.chatbotForm.settings.brand_color : (message.role === 'user' ?
                        chatbot.settings.brand_color :
                        'var(--color-zinc-200)')
            }"
                class="rounded-b-xl! max-w-full flex items-start w-fit border-none shadow-none p-3 text-base"
                :class="[
                    message.role === 'user' ? 'rounded-tl-xl!' : 'rounded-tr-xl!',
                    message.role === 'user' ? 'text-white' : 'text-black'
                ]">
                <div x-html="message.content" class="whitespace-pre-line {{ $sizeClass }}">
                </div>
            </div>
        </div>
    </template>
    <div x-show="loading" class="flex items-center  gap-4">
        <div :style="{
            background: preview ?
                $wire.$parent.chatbotForm.settings.brand_color : chatbot.settings.brand_color
        }"
            class="w-fit h-fit p-2 items-center justify-center">
            <x-chatbots.chatbot.bot-icon class="text-white {{ $iconSize }}" />
        </div>
        <span class="bg-zinc-200 p-2  rounded-b-xl! flex  rounded-tr-xl! {{ $sizeClass }}">
            Thinking ...
        </span>
    </div>
</div>
