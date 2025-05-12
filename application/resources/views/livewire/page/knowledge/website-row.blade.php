<div
    class="grid grid-cols-1 sm:grid-cols-12 gap-4 p-4 dark:odd:bg-surface-dark/30 odd:bg-surface-dark/50 rounded-lg  items-center">
    <div class="col-span-4 sm:col-span-3">
        <flux:heading class="sm:hidden">{{ __('KNOWLEDGE') }}</flux:heading>
        <flux:text class="text-wrap break-words">{{ $website->url }}</flux:text>
    </div>
    <div class="col-span-2 sm:col-span-3">
        <flux:heading class="sm:hidden">{{ __('ADDED') }}</flux:heading>
        <flux:text class="text-sm">{{ $website->created_at->diffForHumans() }}</flux:text>
    </div>
    <div class="col-span-2 sm:col-span-2">
        <flux:badge icon="{{ $website->status == KnowledgeStatus::TRAINING ? 'loading' : null }}" wire:loading.remove
            wire:target="trainWebsite" variant="pill" color="{{ $website->status->color() }}">
            {{ $website->status->label() }}
        </flux:badge>
        <flux:badge class="w-fit!" icon="loading" wire:loading.flex wire:target="trainWebsite" variant="pill"
            color="{{ KnowledgeStatus::TRAINING->color() }}">
            {{ KnowledgeStatus::TRAINING->label() }}
        </flux:badge>

    </div>
    <div class="col-span-3 sm:col-span-2">
        <flux:heading class="sm:hidden">{{ __('TRAINED AT') }}</flux:heading>
        <flux:text class="text-sm text-nowrap">{{ $website->trained_at?->diffForHumans() ?? '-' }}</flux:text>
    </div>
    <div class="col-span-1 flex justify-end">
        <flux:dropdown>
            <flux:button variant="ghost" icon="ellipsis-vertical" />

            <flux:menu>
                @if ($website->hasToTrain)
                    <flux:menu.item wire:loading.remove wire:target='trainWebsite' wire:click="trainWebsite"
                        class="hover:bg-success/20! hover:text-success!" icon="brain">
                        Train
                    </flux:menu.item>
                    <flux:menu.separator wire:loading.remove wire:target='trainWebsite' />
                @endif
                <flux:menu.item wire:confirm="Are you sure you want to delete this website?" wire:click="deleteWebsite"
                    icon="trash" variant="danger">
                    {{ __('Delete') }}
                </flux:menu.item>
                <flux:menu.separator />
                <flux:menu.item wire:click="openSettings" icon="cog"
                    class="hover:bg-primary/20! hover:text-primary!">
                    {{ __('Settings') }}
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </div>
</div>
