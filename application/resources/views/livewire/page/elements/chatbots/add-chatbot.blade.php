<div class="flex flex-col md:flex-row gap-10 md:h-[calc(100vh-4rem)]">
    <div x-data class="mb-10 w-full md:overflow-y-auto p-5">
        <flux:text class="flex gap-2 items-center mb-1">
            <flux:icon class="size-5!" name="chat-bubble-bottom-center-text" />
            Chatbots
        </flux:text>
        <flux:heading size="xl">{{ __('Untitled') }}</flux:heading>
        <flux:text class=" mt-2">{{ __('Create and manage your chatbots') }}
        </flux:text>
        <flux:separator variant="subtle" class="my-8" />

        <flux:tab.group class="w-full text-xl!">
            <flux:tabs>
                <flux:tab class="text-base!" name="knowledge">Knowledge</flux:tab>
                <flux:tab class="text-base!" name="behavior">Behavior</flux:tab>
                <flux:tab class="text-base!" name="connections">Connections</flux:tab>
                <flux:tab class="text-base!" name="settings">Settings</flux:tab>
                <flux:tab class="text-base!" name="install">Install</flux:tab>
            </flux:tabs>

            <!-- Knowledge Tab -->
            <flux:tab.panel name="knowledge">
                <flux:heading class="text-xl">
                    Appearance & basic settings
                </flux:heading>
                <div class="space-y-8">
                    <flux:separator variant="subtle" class="my-8" />
                    <flux:input label="Headline" wire:model='settings.headline' />
                    <flux:input label="Description" wire:model='settings.description' />
                    <flux:textarea label="Welcome message" wire:model='settings.welcome_message' />
                    <label class="flex gap-2 flex-col">
                        <flux:label>Welcome message popup
                        </flux:label>
                        <flux:switch wire:model='settings.has_welcome_message_popup' />
                    </label>
                    <label class="flex gap-2 flex-col">
                        <flux:label>Collect name & email
                        </flux:label>
                        <flux:switch wire:model='settings.has_collect_name_and_email' />
                    </label>
                    <flux:radio.group wire:model='settings.brand_color' label="Brand color" variant="cards"
                        class="flex p-2 border border-gray-300/30 rounded-lg! flex-wrap gap-2! items-center!">
                        @foreach ($colors as $color)
                            <flux:radio class="w-8! h-8! cursor-pointer rounded-lg! flex-none!"
                                style="background: {{ $color }}" value="{{ $color }}">
                            </flux:radio>
                        @endforeach
                        <flux:input class:input="h-8! w-25!" class="max-w-fit!  rounded-lg! flex-none!"
                            wire:model='settings.brand_color' />
                    </flux:radio.group>
                    <div class="grid grid-cols-2 gap-5">
                        <flux:select variant="listbox" wire:model="settings.theme" label="Theme">
                            <flux:select.option value="light">Light</flux:select.option>
                            <flux:select.option value="dark">Dark</flux:select.option>
                        </flux:select>
                        <flux:select variant="listbox" wire:model="settings.orientation" label="Orientation">
                            <flux:select.option value="left">Left</flux:select.option>
                            <flux:select.option value="right">Right</flux:select.option>
                        </flux:select>
                    </div>
                </div>
            </flux:tab.panel>

            <!-- Behavior Tab -->
            <flux:tab.panel name="behavior">
                <flux:text>Knowledge</flux:text>
            </flux:tab.panel>

            <!-- Connections Tab -->
            <flux:tab.panel name="connections">
                <flux:text>Knowledge</flux:text>
            </flux:tab.panel>

            <!-- Settings Tab -->
            <flux:tab.panel name="settings">
                <flux:text>Knowledge</flux:text>
            </flux:tab.panel>

            <!-- Install Tab -->
            <flux:tab.panel name="install">
                <flux:text>Knowledge</flux:text>
            </flux:tab.panel>
        </flux:tab.group>
    </div>


    <div x-data="{
        showChat: true
    }" class="flex-col flex !min-w-115 w-115 h-full justify-end">
        <div x-transition x-show="showChat"
            class="relative  w-full h-[90%]  bg-white! overflow-hidden p-0! border-none rounded-3xl!">
            <div :style="{
                background: 'linear-gradient(to right, ' + normalizeHex($wire.settings.brand_color) + ', ' +
                    normalizeHex($wire.settings.brand_color) + 'B3)'
            }"
                style="background: linear-gradient(to right, {{ normalizeHex($settings['brand_color']) }}, {{ normalizeHex($settings['brand_color']) }}B3)"
                class="space-y-4 p-8 text-center">
                <flux:heading wire:text='settings.headline' size="xl">{{ $settings['headline'] }}
                </flux:heading>
                <flux:text wire:text='settings.description' class="text-white">
                    {{ $settings['description'] }}
                </flux:text>
                <div>
                    <flux:button icon="chat-bubble-bottom-center-text" variant="primary"
                        class="rounded-lg bg-black/40 hover:bg-black/20 shadow-none! border-none!">
                        <flux:text class="text-white!">New chat</flux:text>
                    </flux:button>
                    <flux:button icon="question-mark-circle" variant="primary"
                        class="rounded-lg bg-black/40 hover:bg-black/20 shadow-none! border-none!">
                        <flux:text class="text-white!">See FAQ</flux:text>
                    </flux:button>
                </div>


            </div>

            <div class="p-5 space-y-4 h-[60%] overflow-auto">
                <div class="flex gap-4 group ">
                    <flux:icon name="chat-bubble-bottom-center-text" class="size-8 text-gray-900" />
                    <div wire:text='settings.welcome_message' style="background:var(--color-zinc-300)"
                        class="max-w-full flex items-start text-wrap whitespace-pre-wrap w-fit border-none shadow-none even:mr-10 odd:ml-20   rounded-none! p-4! rounded-b-xl! odd:rounded-tl-xl! even:rounded-tr-xl!">
                        <flux:text class="text-black text-base! group-even:text-white!">
                            {{ $settings['welcome_message'] }}
                        </flux:text>
                    </div>
                </div>
                @foreach ($messages as $index => $message)
                    <div class="flex gap-4 group justify-end">
                        @if ($message['role'] === 'assistant')
                            <flux:icon name="chat-bubble-bottom-center-text" class="size-8 text-gray-900" />
                        @endif
                        <div style="background: {{ $index % 2 === 0 ? $settings['brand_color'] : 'var(--color-zinc-300)' }}"
                            class="max-w-full flex items-start text-wrap whitespace-pre-wrap w-fit border-none shadow-none even:mr-10 odd:ml-20  rounded-none! p-4! rounded-b-xl! odd:rounded-tl-xl! even:rounded-tr-xl!"
                            :style="{
                                background: {{ $index }} % 2 === 0 ? $wire.settings.brand_color :
                                    'var(--color-zinc-300)'
                            }">
                            <flux:text class="text-black text-base! group-even:text-white!">
                                {{ $message['content'] }}
                            </flux:text>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-2 absolute bottom-0 left-0 h-[12%] bg-gray-100 right-0">
                <flux:card
                    class="bg-white!  ring-1! ring-gray-300/50! flex h-[50%]! items-center justify-between w-full">
                    <flux:input class:input="text-black!" placeholder="Type your message here..." />
                    <flux:button icon="paper-airplane" class="text-black!" variant="ghost" />
                </flux:card>
                <div class="flex gap-1 items-center  justify-center h-[calc(50%)]">
                    <flux:text class="text-gray-500 text-xs">
                        Powered by
                    </flux:text>
                    <flux:text class="text-accent font-bold text-xs">
                        Assitly
                    </flux:text>
                </div>
                <div>
                    ss
                </div>
            </div>
        </div>

        <div class="flex" :class="$wire.settings.orientation == 'right' ? 'justify-end' : 'justify-start'">
            <button @click="showChat = !showChat"
                :style="{
                    background: $wire.settings.brand_color
                }"
                class="w-fit p-4 mt-4 rounded-full flex items-center justify-center">
                <flux:icon x-cloak x-show="!showChat" name="chat-bubble-bottom-center-text"
                    class="text-white size-10!">
                </flux:icon>
                <flux:icon x-cloak x-show="showChat" name="x-mark" class="text-white size-10!"></flux:icon>
            </button>
        </div>
    </div>
    <!-- Begin Chatbot Preview -->


    <!-- End Chatbot Preview -->
</div>
