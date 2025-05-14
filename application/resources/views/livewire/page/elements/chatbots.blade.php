<div class="space-y-6">
    <div>
        <flux:heading size="xl">{{ __('Chatbots') }}</flux:heading>
        <flux:text class=" mt-2">{{ __('Manage all your chatbots here.') }}
        </flux:text>
        <flux:separator variant="subtle" class="my-8" />
    </div>

    {{-- Search and filters section --}}
    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
        <div class="w-full">
            <flux:input wire:model.live="search" placeholder="{{ __('Search chatbots...') }}" icon="search" clearable />
        </div>
        <div class="flex gap-4 w-full sm:w-auto">
            <flux:button icon="plus" wire:click='newChatbot' variant="primary">
                {{ __('Add new chatbot') }}
            </flux:button>
        </div>
    </div>

    <div class="mt-6">
        @if ($chatbots && count($chatbots) > 0)
            <div class="grid gap-4">
                <div class="hidden sm:grid grid-cols-5 gap-4 px-4 py-3 bg-muted/50 rounded-lg">
                    <div class="col-span-2">
                        <flux:text class="text-sm font-medium">{{ __('Name') }}</flux:text>
                    </div>
                    <div class="col-span-1">
                        <flux:text class="text-sm font-medium">{{ __('Created at') }}</flux:text>
                    </div>
                    <div class="col-span-1">
                        <flux:text class="text-sm font-medium">{{ __('Updated at') }}</flux:text>
                    </div>
                    <div class="col-span-1">
                    </div>
                </div>

                @foreach ($chatbots as $chatbot)
                    <livewire:page.elements.chatbot-row :key="$chatbot->id" :chatbot="$chatbot" />
                @endforeach
            </div>
        @else
            {{-- Empty state --}}
            <div class="flex flex-col items-center justify-center py-16 px-4 border rounded-lg">
                <flux:icon name="search" class="h-12 w-12 text-white! mb-4" />
                <flux:heading size="lg" class="text-center mb-2">{{ __('You have no chatbots yet') }}
                </flux:heading>
                <flux:text class=" text-center mb-6">{{ __('Add a chatbot to start chatting with your customers.') }}
                </flux:text>
            </div>
        @endif
    </div>
</div>
