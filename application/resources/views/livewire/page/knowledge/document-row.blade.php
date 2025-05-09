<div
    class="grid grid-cols-12 gap-4 px-4 dark:odd:bg-surface-dark/30 odd:bg-surface-dark/50 py-3 rounded-lg items-center">
    <div class="col-span-4">
        <div class="flex items-center gap-3">
            <flux:icon name="file-text" class="h-5 w-5 dark:text-gray-300" />
            <flux:text class="text-wrap break-words w-[80%]">
                {{ $document->file_name }}
            </flux:text>
        </div>
    </div>
    <div class="col-span-2">
        <flux:text>{{ $document->created_at->diffForHumans() }}</flux:text>
    </div>
    <div class="col-span-2">
        <flux:badge wire:loading.remove wire:target="trainDocument"
            icon="{{ $document->status == KnowledgeStatus::TRAINING ? 'loading' : null }}" variant="pill"
            color="{{ $document->status->color() }}">
            {{ $document->status->label() }}
        </flux:badge>
        <flux:badge wire:loading.flex wire:target="trainDocument" icon="loading" variant="pill"
            color="{{ KnowledgeStatus::TRAINING->color() }}">
            {{ KnowledgeStatus::TRAINING->label() }}
        </flux:badge>
    </div>
    <div class="col-span-2">
        <flux:text>{{ $document->trained_at ? $document->trained_at->diffForHumans() : '-' }}</flux:text>
    </div>
    <div class="col-span-2 flex justify-end">
        <flux:dropdown>
            <flux:button variant="ghost" icon="ellipsis-vertical" />

            <flux:menu>
                @if ($document->status != KnowledgeStatus::TRAINED)
                    <flux:menu.item wire:loading.remove wire:target='trainDocument' wire:click="trainDocument"
                        class="hover:bg-success/20! hover:text-success!" icon="brain">
                        {{ __('Train') }}
                    </flux:menu.item>
                    <flux:menu.separator wire:loading.remove wire:target='trainDocument' />
                @endif
                <flux:menu.item wire:confirm="Are you sure you want to delete this document?"
                    wire:click="deleteDocument" icon="trash" variant="danger">
                    {{ __('Delete') }}
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </div>
</div>
