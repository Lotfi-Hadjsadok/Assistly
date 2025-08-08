@props([
'title',
'icon',
'linkedItems' => collect(),
'availableItems' => collect(),
'onUnlink' => null,
'onLink' => null,
'itemRoute' => null,
'itemRouteText' => null
])

<section class="space-y-4">
    <flux:heading size="lg" class="flex items-center gap-2">
        <flux:icon name="{{ $icon }}" class="h-5 w-5 text-gray-200" />
        {{ $title }}
    </flux:heading>

    {{-- Linked Items --}}
    @if($linkedItems->isNotEmpty())
    <div class="grid gap-2">
        @foreach($linkedItems as $item)
        <div class="flex items-center justify-between p-3 border-2 border-gray-300/30 rounded-lg bg-muted/50">
            <div class="flex items-center gap-3 min-w-0 flex-1">
                <flux:icon name="{{ $icon }}" class="h-4 w-4 text-gray-200 flex-shrink-0" />
                <div class="min-w-0 flex-1">
                    <flux:text class="font-medium truncate">{{ $item->display_name ?? $item->file_name ?? $item->url }}
                    </flux:text>
                    <flux:text class="text-sm text-muted-foreground">
                        Added {{ $item->created_at->diffForHumans() }}
                    </flux:text>
                </div>
            </div>
            @if($onUnlink)
            <flux:button icon="x-mark" size="xs"
                class="rounded-full! bg-transparent! border-none! ring-none! text-danger!"
                wire:click="{{ $onUnlink }}({{ $item->id }})">
            </flux:button>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-8 border-2 border-gray-300/30 rounded-lg bg-muted/30">
        <flux:icon name="{{ $icon }}" class="h-8 w-8 mx-auto text-gray-200 mb-2" />
        <flux:text class="text-muted-foreground">No {{ strtolower($title) }} linked yet</flux:text>
    </div>
    @endif

    {{-- Available Items --}}
    @if($availableItems->isNotEmpty())
    <div class="space-y-2">
        <flux:heading size="sm" class="text-muted-foreground">Unlinked {{ $title }}</flux:heading>
        <div class="grid gap-2">
            @foreach($availableItems as $item)
            <div class="flex items-center justify-between p-3 border-2 border-gray-300/30 rounded-lg">
                <div class="flex items-center gap-3 min-w-0 flex-1">
                    <flux:icon name="{{ $icon }}" class="h-4 w-4 text-gray-200 flex-shrink-0" />
                    <div class="min-w-0 flex-1">
                        <flux:text class="font-medium truncate">{{ $item->display_name ?? $item->file_name ?? $item->url
                            }}</flux:text>
                        <flux:badge variant="pill" color="{{ $item->status->color() }}" class="mt-1">
                            {{ $item->status->label() }}
                        </flux:badge>
                    </div>
                </div>
                @if($onLink)
                <flux:button icon="plus" size="sm" variant="primary" wire:click="{{ $onLink }}({{ $item->id }})">
                    Link
                </flux:button>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
</section>