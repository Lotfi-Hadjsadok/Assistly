<div>
    <flux:sidebar sticky stashable {{ $attributes }}>
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand href="{{ route('dashboard') }}" logo="/img/demo/logo.png" name="Assistly" class="px-2 dark:hidden" />
        <flux:brand href="{{ route('dashboard') }}" logo="/img/demo/dark-mode-logo.png" name="Assistly"
            class="px-2 hidden dark:flex" />

        <flux:input variant="filled" placeholder="{{ __('Search...') }}" icon="magnifying-glass" />
        <flux:navlist variant="outline">
            <flux:navlist.item icon="layout-dashboard" href="{{ route('dashboard') }}">{{ __('Dashboard') }}
            </flux:navlist.item>

            <flux:navlist.group heading="{{ __('Knowledge Base') }}" class="mt-4">
                <flux:navlist.item icon="globe" href="{{ route('knowledge.websites') }}">{{ __('Websites') }}
                </flux:navlist.item>
                <flux:navlist.item icon="file-text" href="{{ route('knowledge.documents') }}">{{ __('Documents') }}
                </flux:navlist.item>
                <flux:navlist.item icon="question-mark-circle" href="#">{{ __('FAQS') }}</flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group heading="{{ __('Elements') }}" class="mt-4">
                <flux:navlist.item icon="chat-bubble-bottom-center-text" href="{{ route('elements.chatbots') }}">
                    {{ __('Chat Bots') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog-6-tooth" href="#">{{ __('Settings') }}</flux:navlist.item>
            <flux:navlist.item icon="information-circle" href="#">{{ __('Help') }}</flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" align="left" class="max-lg:hidden">
            <flux:profile name="{{ auth()->user()->name }}" />

            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>{{ __('Olivia Martin') }}</flux:menu.radio>
                    <flux:menu.radio>{{ __('Truly Delta') }}</flux:menu.radio>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.item href="{{ route('logout') }}" icon="arrow-right-start-on-rectangle">{{ __('Logout') }}
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:profile name="{{ auth()->user()->name }}" />
    </flux:header>

    <flux:main container class="max-w-xl lg:max-w-3xl">
        {{ $slot }}
    </flux:main>
</div>
