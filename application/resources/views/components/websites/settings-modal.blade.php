@props(['selectedWebsite', 'form'])

<flux:modal variant="flyout" name="knowledge-website-settings">
    <flux:heading size="lg">{{ __('Website Settings') }}</flux:heading>
    <flux:text class="mt-2">{{ __('Manage the settings for this website.') }}</flux:text>
    <flux:tab.group>

        <flux:tabs>
            <flux:tab name="pages">{{ __('Pages') }}</flux:tab>
            <flux:tab name="settings">{{ __('Settings') }}</flux:tab>
        </flux:tabs>

        <flux:tab.panel name="pages">
            <div class="flex justify-between mb-5 items-center">
                <flux:text class=" text-accent">
                    {{ $selectedWebsite?->url }}
                </flux:text>
            </div>

            @foreach ($selectedWebsite?->sitemap ?? [] as $page)
                <div class="flex justify-between mt-2 items-center">
                    <flux:text>
                        {{ $page['url'] }}
                    </flux:text>
                    <flux:button.group>
                        <flux:button size="xs" icon="trash" variant="subtle"
                            wire:click="removeFromSiteMap('{{ $page['url'] }}')" />
                        @if ($page['trained'])
                            <flux:icon variant="solid" size="xs" name="check"
                                class="text-success size-5! mt-0.5!" />
                        @else
                            <flux:icon variant="solid" size="xs" name="x-mark"
                                class="text-danger size-5! mt-0.5!" />
                        @endif
                    </flux:button.group>
                </div>
            @endforeach
            <form class="flex gap-2 items-center mt-5" wire:submit="addToSiteMap({{ $selectedWebsite?->id }})">
                <flux:input class="w-40!" placeholder="{{ __('/new-page') }}" size="xs"
                    wire:model="form.newPage" />
                <flux:button type="submit" variant="subtle" size="sm" icon="plus">
                </flux:button>
            </form>
            @error('form.newPage')
                <flux:text class="text-danger">{{ $message }}</flux:text>
            @enderror
        </flux:tab.panel>
        <flux:tab.panel name="settings">
            <flux:button wire:target='deleteWebsite' variant="danger" size="sm"
                wire:click="deleteWebsite({{ $selectedWebsite?->id }})">
                {{ __('Delete Website') }}
            </flux:button>
        </flux:tab.panel>
    </flux:tab.group>
</flux:modal>
