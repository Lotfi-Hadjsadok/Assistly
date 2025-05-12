<div class="space-y-6">
    <div>
        <flux:heading size="xl">{{ __('Websites') }}</flux:heading>
        <flux:text class=" mt-2">{{ __('Manage all your websites knowledge sources here.') }}
        </flux:text>
        <flux:separator variant="subtle" class="my-8" />
    </div>

    {{-- Search and filters section --}}
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
        <div class="w-full">
            <flux:input wire:model.live="search" placeholder="{{ __('Search knowledge...') }}" icon="search" clearable />
        </div>
        <div class="flex gap-4 w-full sm:w-auto">
            <flux:button href="{{ route('elements.chatbots.add') }}" variant="primary">
                <flux:icon name="plus" class="mr-2 h-4 w-4" />
                {{ __('Add new chatbot') }}
            </flux:button>
        </div>
    </div>

    <div class="mt-6">
        @if ($chatbots = [] && count($chatbots) > 0)
            <div class="grid gap-4">
                <div class="hidden sm:grid grid-cols-12 gap-4 px-4 py-3 bg-muted/50 rounded-lg">
                    <div class="col-span-3">
                        <flux:text class="text-sm font-medium">{{ __('KNOWLEDGE') }}</flux:text>
                    </div>
                    <div class="col-span-3">
                        <flux:text class="text-sm font-medium">{{ __('ADDED') }}</flux:text>
                    </div>
                    <div class="col-span-2">
                        <flux:text class="text-sm font-medium">{{ __('TRAINED') }}</flux:text>
                    </div>
                    <div class="col-span-2">
                        <flux:text class="text-sm font-medium">{{ __('TRAINED') }}</flux:text>
                    </div>
                </div>

                @foreach ($chatbots as $chatbot)
                    <livewire:page.elements.chatbots-row :key="$chatbot->id" :chatbot="$chatbot" />
                @endforeach
            </div>
        @else
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center py-16 px-4 border rounded-lg">
                <flux:icon name="search" class="h-12 w-12  mb-4 dark:text-gray-300" />
                <flux:heading size="lg" class="text-center mb-2">{{ __('You have no knowledge yet') }}
                </flux:heading>
                <flux:text class=" text-center mb-6">{{ __('Add a website to feed your knowledge base.') }}
                </flux:text>
            </div>
        @endif
    </div>
</div>
