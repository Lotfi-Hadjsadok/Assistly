<div
    class="grid grid-cols-1 sm:grid-cols-12 gap-4 p-4 dark:odd:bg-surface-dark/30 odd:bg-surface-dark/50 rounded-lg  items-center">
    <div class="col-span-4 sm:col-span-3">
        <flux:heading class="sm:hidden">KNOWLEDGE</flux:heading>
        <flux:text class="text-wrap break-words">{{ $website->url }}</flux:text>
    </div>
    <div class="col-span-2 sm:col-span-3">
        <flux:heading class="sm:hidden">ADDED</flux:heading>
        <flux:text class="text-sm">{{ $website->created_at->diffForHumans() }}</flux:text>
    </div>
    <div class="col-span-2 sm:col-span-2">
        <flux:badge wire:loading.remove variant="pill" color="{{ $website->status->color() }}">
            {{ $website->status->label() }}
        </flux:badge>
        <flux:badge wire:loading variant="pill" color="yellow">
            {{ KnowledgeStatus::TRAINING->label() }}
        </flux:badge>
    </div>
    <div class="col-span-3 sm:col-span-2">
        <flux:heading class="sm:hidden">TRAINED AT</flux:heading>
        <flux:text class="text-sm text-nowrap">{{ $website->trained_at?->diffForHumans() ?? '-' }}</flux:text>
    </div>
    <div class="col-span-1 flex justify-end">
        <flux:dropdown>
            <flux:button variant="ghost" icon="ellipsis-vertical" />

            <flux:menu>
                <flux:menu.item wire:click="$parent.trainWebsite({{ $website }})"
                    class="hover:bg-success/20! hover:text-success!" icon="brain">
                    Train
                </flux:menu.item>
                <flux:menu.separator />
                <flux:menu.item wire:confirm="Are you sure you want to delete this website?"
                    wire:click="$parent.deleteWebsite({{ $website->id }})" icon="trash" variant="danger">
                    Delete
                </flux:menu.item>
                <flux:menu.separator />
                <flux:menu.item wire:click="$parent.openSettings({{ $website->id }})" icon="cog"
                    class="hover:bg-primary/20! hover:text-primary!">
                    Settings
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </div>
</div>
