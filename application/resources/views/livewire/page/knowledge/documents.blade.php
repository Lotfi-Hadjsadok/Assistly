<div class="space-y-6">
    <div>
        <flux:heading size="xl">{{ __('Documents') }}</flux:heading>
        <flux:text class="mt-2">{{ __('Manage all your documents knowledge sources here.') }}
        </flux:text>
        <flux:separator variant="subtle" class="my-8" />
    </div>

    {{-- Search and filters section --}}
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
        <div class="w-full">
            <flux:input wire:model.live="search" placeholder="Search knowledge..." icon="search" clearable />
        </div>
        <div class="flex gap-4 w-full sm:w-auto">
            <flux:modal.trigger name="add-document">
                <flux:button variant="primary">
                    <flux:icon name="plus" class="mr-2 h-4 w-4" />
                    {{ __('Add new document') }}
                </flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    {{-- Add Document Modal --}}
    <flux:modal name="add-document" class="sm:max-w-md">
        <form wire:submit="addDocument" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Add New Document') }}</flux:heading>
                <flux:text class="mt-2">{{ __('Upload a document to your knowledge base.') }}</flux:text>
            </div>

            <div>
                <flux:input type="file" wire:model="document" accept=".pdf,.doc,.docx,.txt" />
                <flux:text class="mt-2 text-sm text-muted">{{ __('Supported formats: PDF, DOC, DOCX, TXT (max 10MB)') }}
                </flux:text>
            </div>

            <div class="flex items-center gap-3">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button type="button" variant="ghost" wire:click="resetForm">
                        {{ __('Cancel') }}
                    </flux:button>
                </flux:modal.close>

                <flux:button variant="primary" type="submit">
                    {{ __('Upload Document') }}
                </flux:button>
            </div>
            @if ($errors->any())
                <div class="mt-4">
                    <flux:text class="text-danger">{{ $errors->first() }}</flux:text>
                </div>
            @endif
        </form>
    </flux:modal>

    <div class="mt-6">
        @if ($documents && count($documents) > 0)
            <div class="grid gap-4">
                <div class="hidden sm:grid grid-cols-12 gap-4 px-4 py-3 bg-muted/50 rounded-lg">
                    <div class="col-span-4">
                        <flux:text class="text-sm font-medium">KNOWLEDGE</flux:text>
                    </div>
                    <div class="col-span-2">
                        <flux:text class="text-sm font-medium">ADDED</flux:text>
                    </div>
                    <div class="col-span-2">
                        <flux:text class="text-sm font-medium">STATUS</flux:text>
                    </div>
                    <div class="col-span-2">
                        <flux:text class="text-sm font-medium">TRAINED AT</flux:text>
                    </div>
                    <div class="col-span-2"></div>
                </div>

                @foreach ($documents as $document)
                    <livewire:page.knowledge.document-row :key="$document->id" :document="$document" />
                @endforeach
            </div>
        @else
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center py-16 px-4 border rounded-lg">
                <flux:icon name="search" class="h-12 w-12 mb-4 dark:text-gray-300" />
                <flux:heading size="lg" class="text-center mb-2">{{ __('You have no documents yet') }}
                </flux:heading>
                <flux:text class="text-center mb-6">{{ __('Add a document to feed your knowledge base.') }}
                </flux:text>
            </div>
        @endif
    </div>
</div>
