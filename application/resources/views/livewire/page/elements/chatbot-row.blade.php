<div
    class="grid grid-cols-5 gap-4 items-center px-4 py-3 dark:odd:bg-surface-dark/30 odd:bg-surface-dark/50 rounded-lg shadow-sm">
    <div class="col-span-2 flex items-center">
        <flux:text class="font-medium">{{ $chatbot->name ?? 'Untitled' }}</flux:text>
    </div>
    <div class="col-span-1">
        <flux:text class="text-sm">{{ $chatbot->created_at ? $chatbot->created_at->diffForHumans() : '' }}
        </flux:text>
    </div>
    <div class="col-span-1">
        <flux:text class="text-sm">{{ $chatbot->updated_at ? $chatbot->updated_at->diffForHumans() : '' }}
        </flux:text>
    </div>
    <div class="col-span-1 flex gap-2 justify-end">
        <flux:dropdown>
            <flux:button variant="ghost" icon="ellipsis-vertical" />
            <flux:menu>
                <flux:menu.item href="{{ route('elements.chatbots.edit', $chatbot->id) }}" wire:navigate icon="cog"
                    class="hover:bg-primary/20! hover:text-primary!">
                    {{ __('Settings') }}
                </flux:menu.item>
                <flux:menu.separator />
                <flux:menu.item wire:confirm="Are you sure you want to delete this chatbot?" wire:click="deleteChatbot"
                    icon="trash" variant="danger">
                    {{ __('Delete') }}
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </div>
</div>
