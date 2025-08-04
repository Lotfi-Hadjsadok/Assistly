<div x-cloak x-data="chatbot" class="flex flex-col justify-end">
    <div x-show="showChat" style="width: {{ $width }}; height: {{ $height }};"
        class="rounded-2xl  flex justify-between flex-col shadow-2xl overflow-hidden">
        <!-- Header -->
        <div style="background:{{ $chatbot['settings']['brand_color'] }}" @if($preview)
            :style="{ backgroundImage: `linear-gradient(to left, ${$wire.$parent.chatbotForm.settings.brand_color}, ${transaparentColor($wire.$parent.chatbotForm.settings.brand_color, 'BF')})` }"
            @endif class="flex py-10 flex-col gap-2 items-center justify-between">

            <h3 class="font-semibold text-2xl text-white" @if($preview)
                x-text="$wire.$parent.chatbotForm.settings.headline" @endif>
                {{ $chatbot['settings']['headline'] }}
            </h3>

            <p class="text-sm text-gray-200" @if($preview) x-text="$wire.$parent.chatbotForm.settings.description"
                @endif>
                {{ $chatbot['settings']['description'] }}
            </p>

            <button wire:click="newChat"
                class="bg-white w-30 justify-center flex items-center !px-4 py-2 !rounded-full text-sm" @if($preview)
                x-bind:style="{ color: $wire.$parent.chatbotForm.settings.brand_color }" @endif
                style="color:{{ $chatbot['settings']['brand_color'] }}">
                <span wire:loading wire:target='newChat'>
                    <flux:icon.loading class="size-5" />
                </span>
                <span wire:loading.remove wire:target='newChat' class="flex items-center gap-2">
                    {{ __("New Chat") }}
                </span>
            </button>
        </div>


        <!-- Chat Messages -->
        <div x-ref="messageContainer" class="p-4 space-y-4 flex-1 overflow-y-auto bg-gray-50">
            <!-- Welcome Message -->
            @foreach ($messages as $index => $message)
            <div class="flex items-start {{ $message['role'] == 'user' ? 'flex-row-reverse' : '' }} gap-3">
                @if ($message['role'] != 'user')
                <div style="background:{{ $chatbot['settings']['brand_color'] }}" @if($preview)
                    :style="{ backgroundColor: $wire.$parent.chatbotForm.settings.brand_color }" @endif
                    class="w-8 h-8 border border-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" />
                    </svg>
                </div>
                @endif

                <div @if ($message['role']=='user' ) style="background:{{ $chatbot['settings']['brand_color'] }}"
                    @if($preview) :style="{ backgroundColor: $wire.$parent.chatbotForm.settings.brand_color }" @endif
                    @endif
                    class="bg-white rounded-2xl {{ $message['role'] == 'user' ? 'rounded-tr-md' : 'rounded-tl-md' }} px-4 py-3 shadow-sm max-w-xs">
                    <span @if($index < 1 && $preview) x-html="$wire.$parent.chatbotForm.settings.welcome_message" @endif
                        class="text-sm message-content {{ $index == 0 ? 'whitespace-pre-line' : '' }}  break-words 
                    {{ $message['role'] == 'user' ? 'text-white' : 'text-gray-800' }}">@if ($index > 0){!!
                        trim(parseMarkdown($message['content'])) !!}@elseif($index==0) {{
                        $chatbot['settings']['welcome_message']
                        }}@endif</span>
                </div>
            </div>
            @endforeach

            <!-- Loading Message -->
            <div wire:loading.flex wire:target='sendMessage' class="flex flex-row-reverse">
                <div style="background:{{ $chatbot['settings']['brand_color'] }}" @if($preview)
                    :style="{ backgroundColor: $wire.$parent.chatbotForm.settings.brand_color }" @endif
                    class="bg-white opacity-70 rounded-2xl rounded-tr-md px-4 py-3 shadow-sm max-w-xs">
                    <span x-text="messageLoadingPlaceholder" class="text-sm whitespace-pre-wrap break-words text-white">
                    </span>
                </div>
            </div>

            @if ($loading)
            <div class="flex items-start gap-3">
                <div style="background:{{ $chatbot['settings']['brand_color'] }}" @if($preview)
                    :style="{ backgroundColor: $wire.$parent.chatbotForm.settings.brand_color }" @endif
                    class="w-8 h-8 border border-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" />
                    </svg>
                </div>
                <div class="bg-white rounded-2xl rounded-tl-md px-4 py-3 shadow-sm max-w-xs">
                    <div class="flex items-center space-x-1">
                        <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 150ms">
                        </div>
                        <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay: 300ms">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            @if (count($messages) < 1) <div class="space-y-3 pt-2">
                @for ($i = 0; $i < 3; $i++) <button
                    style="background:{{ $chatbot['settings']['brand_color'] }}20; border-color:{{ $chatbot['settings']['brand_color'] }}; color:{{ $chatbot['settings']['brand_color'] }}"
                    @if($preview) :style="{ 
                                    backgroundColor: transaparentColor($wire.$parent.chatbotForm.settings.brand_color, '20'), 
                                    borderColor: $wire.$parent.chatbotForm.settings.brand_color, 
                                    color: $wire.$parent.chatbotForm.settings.brand_color
                                }" @endif
                    class="w-full border-[1.5px] rounded-full px-4 py-3 text-sm font-medium transition-colors text-center">
                    Custom Question {{ $i + 1 }}
                    </button>
                    @endfor
        </div>
        @endif
    </div>

    <!-- Input Area -->
    <form @submit.prevent='sendMessage' class="border-t border-gray-100 p-4 bg-white">
        <div class="flex items-center space-x-2">
            <input wire:model='message' x-model="message" style="border-color:{{ $chatbot['settings']['brand_color'] }};
            --tw-ring-color:{{ $chatbot['settings']['brand_color'] }};
            " @if($preview) :style="{ 
                           borderColor: $wire.$parent.chatbotForm.settings.brand_color,
                           '--tw-ring-color': $wire.$parent.chatbotForm.settings.brand_color
                       }" @endif type="text" placeholder="Type your message here"
                class="flex-1 border border-gray-200 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:border-transparent" />

            <button style="background:{{ $chatbot['settings']['brand_color'] }}" @if($preview) :style="{ 
                            backgroundColor: $wire.$parent.chatbotForm.settings.brand_color,
                            '--tw-ring-color': $wire.$parent.chatbotForm.settings.brand_color
                        }" @endif
                class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-colors">
                <flux:icon name="send-horizontal" class="w-5 h-5" />
            </button>
        </div>

        <p class="text-xs text-gray-500 text-center mt-2">
            Powered by
            <span style="color:{{ $chatbot['settings']['brand_color'] }}" @if($preview)
                :style="{ color: $wire.$parent.chatbotForm.settings.brand_color }" @endif class="font-medium">
                ChatBot
            </span>
        </p>

    </form>
</div>

<div class="mt-5 flex justify-end ">
    <button @click="toggleChat" style="background:{{ $chatbot['settings']['brand_color'] }}" @if($preview)
        :style="{ backgroundColor: $wire.$parent.chatbotForm.settings.brand_color }" @endif
        class="w-14 h-14 rounded-full shadow-lg flex items-center justify-center text-white hover:scale-110 transition-transform duration-200">
        <svg x-show="!showChat" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
            </path>
        </svg>
        <svg x-show="showChat" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</div>

</div>

@script
<script>
    Alpine.data('chatbot', () => ({
        messages: [],
        message: '',
        messageLoadingPlaceholder:'',
        showChat: {{ $preview ? 'true' : 'false' }},
        toggleChat() {
            this.showChat =  !this.showChat;
        },
        init() {
            this.$nextTick(() => {
                this.scrollToBottom();
            });
            this.$wire.on('message-sent', () => {
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            });
        },
        scrollToBottom() {
            this.$refs.messageContainer.scrollTo({
                top: this.$refs.messageContainer.scrollHeight,
                behavior: 'smooth'
            });
        },
        transaparentColor(color, code) {
            return `${color}${code}`;
        },

        
        async sendMessage() {
            this.message = this.message.trim();
            if (this.message == '' || this.$wire.loading || this.messageLoadingPlaceholder != '') {
                return;
            }
            this.messageLoadingPlaceholder = this.message;
            this.message = '';

            setTimeout(() => {
                this.scrollToBottom();
            }, 100);
            await this.$wire.sendMessage();
            this.messageLoadingPlaceholder = '';
        }
    }));
</script>
@endscript