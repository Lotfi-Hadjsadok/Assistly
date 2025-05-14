<flux:tab.panel name="general">
    <flux:heading class="text-xl">
        Appearance & basic settings
    </flux:heading>
    <div class="space-y-8">
        <flux:separator variant="subtle" class="my-8" />
        <flux:input label="Headline" wire:model.change='chatbotForm.settings.headline' />
        <flux:input label="Description" wire:model.change='chatbotForm.settings.description' />
        <flux:textarea label="Welcome message" wire:model.change='chatbotForm.settings.welcome_message' />
        <flux:radio.group wire:model.change='chatbotForm.settings.brand_color' label="Brand color" variant="cards"
            class="flex p-2 border border-gray-300/30 rounded-lg! flex-wrap gap-2! items-center!">
            @foreach ($chatbotForm->colors as $color)
                <flux:radio class="w-8! h-8! cursor-pointer rounded-lg! flex-none!"
                    style="background: {{ $color }}" value="{{ $color }}">
                </flux:radio>
            @endforeach
            <flux:input class:input="h-8! w-25!" class="max-w-fit!  rounded-lg! flex-none!"
                wire:model.change='chatbotForm.settings.brand_color' />
        </flux:radio.group>
        <div class="grid grid-cols-2 gap-5">
            <flux:select variant="listbox" wire:model.change="chatbotForm.settings.theme" label="Theme">
                <flux:select.option value="light">Light</flux:select.option>
                <flux:select.option value="dark">Dark</flux:select.option>
            </flux:select>
            <flux:select variant="listbox" wire:model.change="chatbotForm.settings.orientation" label="Orientation">
                <flux:select.option value="left">Left</flux:select.option>
                <flux:select.option value="right">Right</flux:select.option>
            </flux:select>
        </div>
    </div>
</flux:tab.panel>
