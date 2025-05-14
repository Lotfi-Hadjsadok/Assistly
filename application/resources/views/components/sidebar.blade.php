<div>
    <flux:sidebar sticky stashable {{ $attributes }}>
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand wire:navigate href="{{ route('dashboard') }}" logo="/img/demo/logo.png" name="Assistly"
            class="px-2 dark:hidden" />
        <flux:brand wire:navigate href="{{ route('dashboard') }}" logo="/img/demo/dark-mode-logo.png" name="Assistly"
            class="px-2 hidden dark:flex" />

        <flux:input variant="filled" placeholder="{{ __('Search...') }}" icon="magnifying-glass" />
        <flux:navlist variant="outline">
            <flux:navlist.item icon="layout-dashboard" wire:navigate href="{{ route('dashboard') }}">
                {{ __('Dashboard') }}
            </flux:navlist.item>

            <flux:navlist.group heading="{{ __('Knowledge Base') }}" class="mt-4">
                <flux:navlist.item icon="globe" wire:navigate href="{{ route('knowledge.websites') }}">
                    {{ __('Websites') }}
                </flux:navlist.item>
                <flux:navlist.item icon="file-text" wire:navigate href="{{ route('knowledge.documents') }}">
                    {{ __('Documents') }}
                </flux:navlist.item>
                <flux:navlist.item icon="question-mark-circle" wire:navigate href="#">{{ __('FAQS') }}
                </flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group heading="{{ __('Elements') }}" class="mt-4">
                <flux:navlist.item icon="chat-bubble-bottom-center-text" wire:navigate
                    href="{{ route('elements.chatbots') }}">
                    {{ __('Chatbots') }}</flux:navlist.item>

                <flux:navlist.item icon="chat-bubble-bottom-center-text" wire:navigate
                    href="{{ route('elements.chatbots.test') }}">
                    {{ __('Chat Test') }}</flux:navlist.item>

            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog-6-tooth" wire:navigate href="#">{{ __('Settings') }}</flux:navlist.item>
            <flux:navlist.item icon="information-circle" wire:navigate href="#">{{ __('Help') }}
            </flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" align="left" class="max-lg:hidden">
            <flux:profile name="{{ auth()->user()->name }}" />

            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>{{ __('Olivia Martin') }}</flux:menu.radio>
                    <flux:menu.radio>{{ __('Truly Delta') }}</flux:menu.radio>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.item wire:navigate href="{{ route('logout') }}" icon="arrow-right-start-on-rectangle">
                    {{ __('Logout') }}
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:profile name="{{ auth()->user()->name }}" />
    </flux:header>

    <flux:main class="max-w-xl lg:max-w-7xl">
        {{ $slot }}
    </flux:main>
</div>
