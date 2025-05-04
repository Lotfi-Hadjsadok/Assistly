<div>
    <flux:sidebar sticky stashable {{ $attributes }}>
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand href="{{ route('dashboard') }}" logo="/img/demo/logo.png" name="Assistly" class="px-2 dark:hidden" />
        <flux:brand href="{{ route('dashboard') }}" logo="/img/demo/dark-mode-logo.png" name="Assistly"
            class="px-2 hidden dark:flex" />

        <flux:input variant="filled" placeholder="Search..." icon="magnifying-glass" />
        <flux:navlist variant="outline">
            <flux:navlist.item icon="layout-dashboard" href="{{ route('dashboard') }}">Dashboard
            </flux:navlist.item>

            <flux:navlist.group heading="Knowledge Base" class="mt-4">
                <flux:navlist.item icon="globe" href="{{ route('knowledge.websites') }}">Websites
                </flux:navlist.item>
                <flux:navlist.item icon="file-text" href="{{ route('knowledge.documents') }}">Documents
                </flux:navlist.item>
                <flux:navlist.item icon="question-mark-circle" href="#">FAQS</flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group heading="Elements" class="mt-4">
                <flux:navlist.item icon="chat-bubble-bottom-center-text" href="{{ route('elements.chatbots') }}">Chat
                    Bots</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog-6-tooth" href="#">Settings</flux:navlist.item>
            <flux:navlist.item icon="information-circle" href="#">Help</flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" align="left" class="max-lg:hidden">
            <flux:profile name="Lotfi Hadjsadok" />

            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio checked>Olivia Martin</flux:menu.radio>
                    <flux:menu.radio>Truly Delta</flux:menu.radio>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:profile name="Lotfi Hadjsadok" />
    </flux:header>

    <flux:main container class="max-w-xl lg:max-w-3xl">
        {{ $slot }}
    </flux:main>
</div>
