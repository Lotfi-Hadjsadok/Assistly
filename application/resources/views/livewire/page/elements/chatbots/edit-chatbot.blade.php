<div wire:ignore class="flex flex-col md:flex-row gap-10 md:h-[calc(100vh-4rem)]">
    <div x-data class="mb-10 w-full md:overflow-y-auto p-5">
        <flux:text class="flex gap-2 items-center mb-1">
            <flux:icon class="size-5!" name="chat-bubble-bottom-center-text" />
            Chatbots
        </flux:text>
        <flux:input wire:model.change='chatbotForm.name'
            class:input="bg-transparent! p-0! border-none! text-xl! shadow-none!" />
        <flux:text class=" mt-2">{{ __('Create and manage your chatbots') }}
        </flux:text>
        <flux:separator variant="subtle" class="my-8" />

        <flux:tab.group class="w-full text-xl!">
            <flux:tabs>
                <flux:tab class="text-base!" name="general">General</flux:tab>
                {{-- <flux:tab class="text-base!" name="behavior">Behavior</flux:tab> --}}
                <flux:tab class="text-base!" name="connections">Connections</flux:tab>
                {{-- <flux:tab class="text-base!" name="settings">Settings</flux:tab> --}}
                {{-- <flux:tab class="text-base!" name="install">Install</flux:tab> --}}
            </flux:tabs>

            <!-- Knowledge Tab -->
            <x-chatbots.wizard.generalTab :$chatbotForm />

            <x-chatbots.wizard.connectionTab :chatbot="$chatbot" />

            {{-- <!-- Behavior Tab -->
            <flux:tab.panel name="behavior">
                <flux:text>Behavior</flux:text>
            </flux:tab.panel>

            {{-- <!-- Connections Tab --> --}}
            <flux:tab.panel name="connections">
                <flux:heading class="text-xl">
                    Embed your chatbot
                </flux:heading>
                <div class="space-y-4 mt-4">
                    <flux:text>
                        Copy and paste the following <code>&lt;iframe&gt;</code> code into your website to embed your
                        chatbot:
                    </flux:text>
                    <div language="html" class="rounded-lg! bg-gray-100! p-4! text-base!">
                        &lt;iframe src="https://your-domain.com/chatbot/{{ $chatbot->id }}" width="400"
                        height="600" style="border:none;"&gt;&lt;/iframe&gt;
                    </div>
                    <flux:text class="text-xs text-gray-500!">
                        You can adjust the <code>width</code> and <code>height</code> as needed for your site.
                    </flux:text>
                </div>
            </flux:tab.panel>

            {{-- <!-- Settings Tab -->
            <flux:tab.panel name="settings">
                <flux:text>Settings</flux:text>
            </flux:tab.panel> --}}

            {{-- <!-- Install Tab -->
            <flux:tab.panel name="install">
                <flux:text>Install</flux:text>
            </flux:tab.panel> --}}


        </flux:tab.group>
    </div>



    <!-- Begin Chatbot Preview -->
    <livewire:page.elements.chatbots.chatbot :chatbot="$chatbotForm" :preview="true" />
    <!-- End Chatbot Preview -->
</div>
