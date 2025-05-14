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
                {{-- <flux:tab class="text-base!" name="connections">Connections</flux:tab> --}}
                {{-- <flux:tab class="text-base!" name="settings">Settings</flux:tab> --}}
                {{-- <flux:tab class="text-base!" name="install">Install</flux:tab> --}}
            </flux:tabs>

            <!-- Knowledge Tab -->
            <x-chatbots.wizard.generalTab :$chatbotForm />

            {{-- <!-- Behavior Tab -->
            <flux:tab.panel name="behavior">
                <flux:text>Behavior</flux:text>
            </flux:tab.panel>

            <!-- Connections Tab -->
            <flux:tab.panel name="connections">
                <flux:text>Connections</flux:text>
            </flux:tab.panel>

            <!-- Settings Tab -->
            <flux:tab.panel name="settings">
                <flux:text>Settings</flux:text>
            </flux:tab.panel>

            <!-- Install Tab -->
            <flux:tab.panel name="install">
                <flux:text>Install</flux:text>
            </flux:tab.panel> --}}
        </flux:tab.group>
    </div>



    <!-- Begin Chatbot Preview -->
    <x-chatbots.chatbot :chatbot="$chatbotForm" :preview="true" />
    <!-- End Chatbot Preview -->
</div>
