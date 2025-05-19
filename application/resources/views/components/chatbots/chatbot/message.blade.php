@props(['content', 'role', 'chatbot', 'preview' => false, 'is_welcome_message' => false, 'size'])

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

<div @class([
    'flex gap-4 group',
    'justify-end' => $role === 'user',
    'justify-start' => $role === 'assistant',
])>
    @if ($role === 'assistant')
        <div @if ($preview) :style="{
            background: $wire.$parent.chatbotForm.settings.brand_color
        }" @endif
            style="background: {{ $chatbot->settings['brand_color'] }}"
            class="w-fit h-fit p-2 rounded-full flex items-center justify-center">
            <x-chatbots.chatbot.bot-icon class="text-white {{ $iconSize }}" />
        </div>
    @endif
    <div @if ($role === 'user') style="background: {{ $chatbot->settings['brand_color'] }};"
        @else
            style="background: var(--color-zinc-300);" @endif
        @class([
            'rounded-b-xl!',
            'max-w-full flex items-start w-fit border-none shadow-none p-3  text-base',
            'rounded-tl-xl! ' => $role === 'user',
            'rounded-tr-xl!' => $role === 'assistant',
        ])>
        <div @if ($is_welcome_message) x-effect="msg = $wire.$parent.chatbotForm.settings.welcome_message" @endif
            x-data="{
                msg: {{ $preview && $is_welcome_message ? '$wire.$parent.chatbotForm.settings.welcome_message' : '`' . $content . '`' }}
            }" x-html="msg" :class="'whitespace-pre-line'" @class([
                $sizeClass,
                'text-white! rounded-tl-xl!' => $role === 'user',
                'text-black!' => $role === 'assistant',
            ])>
            {!! nl2br($content) !!}
        </div>
    </div>
</div>
