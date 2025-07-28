<div x-cloak x-data="chatbot" class="min-w-100 rounded-2xl flex justify-between flex-col shadow-2xl overflow-hidden">
    <!-- Header -->
    <div :style="{ backgroundImage: `linear-gradient(to left, ${$wire.$parent.chatbotForm.settings.brand_color}, ${transaparentColor($wire.$parent.chatbotForm.settings.brand_color, '80')})` }"
        class="flex py-10 flex-col gap-2 items-center justify-between">
        <h3 class="font-semibold text-2xl text-white" x-text="$wire.$parent.chatbotForm.settings.headline"></h3>
        <p class="text-sm text-gray-200" x-text="$wire.$parent.chatbotForm.settings.description"></p>
    </div>

    <!-- Chat Messages -->
    <div class="p-4 space-y-4 flex-1  overflow-y-auto bg-gray-50">
        <!-- Welcome Message -->
        @foreach ($messages as $index=>$message)
        <div class="flex items-start {{ $message['role'] == 'user' ? 'flex-row-reverse':'' }} gap-3">
            @if ($message['role'] != 'user')
            <div :style="{ backgroundColor: $wire.$parent.chatbotForm.settings.brand_color }"
                class="w-8 h-8 border border-gray-200 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" />
                </svg>
            </div>
            @endif

            <div @if ($message['role']=='user' )
                :style="{ backgroundColor: $wire.$parent.chatbotForm.settings.brand_color }" @endif
                class="bg-white rounded-2xl {{ $message['role'] == 'user' ? 'rounded-tr-md':'rounded-tl-md' }} px-4 py-3 shadow-sm max-w-xs">
                <span @if($index<1) x-html="$wire.$parent.chatbotForm.settings.welcome_message" @endif
                    class="text-sm whitespace-pre-wrap break-words {{ $message['role']=='user' ? "
                    text-white":"text-gray-800" }}">@if ($index > 0){!! trim($message['content']) !!}@endif</span>
            </div>
        </div>
        @endforeach

        <div wire:loading.flex wire:target='sendMessage' class="flex flex-row-reverse">
            <div :style=" { backgroundColor: $wire.$parent.chatbotForm.settings.brand_color }"
                class="bg-white opacity-70 rounded-2xl rounded-tr-md px-4 py-3 shadow-sm max-w-xs">
                <span x-text="$wire.message.trim()" class="text-sm whitespace-pre-wrap break-words text-white">
                </span>
            </div>
        </div>

        <!-- Action Buttons -->
        @if (count($message) < 1) <div class="space-y-3 pt-2">
            @for ($i = 0; $i < 3; $i++) <button :style="{ backgroundColor: transaparentColor($wire.$parent.chatbotForm.settings.brand_color, '20'), borderColor: $wire.$parent.chatbotForm.settings.brand_color, color: $wire.$parent.chatbotForm.settings.brand_color,
            }" class="w-full  border-[1.5px] rounded-full px-4 py-3 text-sm font-medium transition-colors text-center">
                Custom Question {{ $i + 1 }}
                </button>
                @endfor

                @endif
    </div>

    <!-- Input Area -->
    <form @submit.prevent='sendMessage' class="border-t border-gray-100 p-4 bg-white">
        <div class="flex items-center space-x-2">
            <input wire:model='message' x-model="message" :style="{ borderColor: $wire.$parent.chatbotForm.settings.brand_color,
            '--tw-ring-color': $wire.$parent.chatbotForm.settings.brand_color
            }" type="text" placeholder="Type your message here"
                class="flex-1 border border-gray-200 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2  focus:border-transparent" />
            <button :style="{ backgroundColor: $wire.$parent.chatbotForm.settings.brand_color,
                '--tw-ring-color': $wire.$parent.chatbotForm.settings.brand_color
                }" class="w-10 h-10 rounded-full flex items-center justify-center text-white transition-colors">
                <flux:icon name="send-horizontal" class="w-5 h-5" />
            </button>
        </div>
        <p class="text-xs text-gray-500 text-center mt-2">Powered by <span
                :style="{ color: $wire.$parent.chatbotForm.settings.brand_color }" class="font-medium">ChatBot</span>
        </p>
    </form>

    @script
    <script>
        Alpine.data('chatbot', () => ({
        messages: [],
        message:'',
        transaparentColor(color, code) {
            return `${color}${code}`;
        },
        loading: false,
        sendMessage() {
            this.$wire.sendMessage()
            this.message=''
        }
    }));
    </script>
    @endscript