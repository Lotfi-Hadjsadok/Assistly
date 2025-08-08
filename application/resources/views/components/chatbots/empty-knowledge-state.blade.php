@props([
'documentsRoute' => null,
'websitesRoute' => null
])

<div class="text-center py-8 border-2 border-gray-300/30 rounded-lg bg-muted/30">
    <flux:icon name="search" class="h-8 w-8 mx-auto text-gray-200 mb-2" />
    <flux:text class="text-muted-foreground mb-2">No knowledge sources available</flux:text>
    <flux:text class="text-sm text-muted-foreground">
        @if($documentsRoute)
        <a href="{{ $documentsRoute }}" class="text-primary hover:underline">Add documents</a>
        @endif
        @if($documentsRoute && $websitesRoute)
        or
        @endif
        @if($websitesRoute)
        <a href="{{ $websitesRoute }}" class="text-primary hover:underline">add websites</a>
        @endif
        to your knowledge base first.
    </flux:text>
</div>