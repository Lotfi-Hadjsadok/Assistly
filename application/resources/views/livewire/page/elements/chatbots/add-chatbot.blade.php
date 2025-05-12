<div class="flex gap-10">
    <div class="mb-10 w-full">
        <flux:text class="flex gap-2 items-center mb-1">
            <flux:icon class="size-5!" name="chat-bubble-bottom-center-text" />
            Chatbots
        </flux:text>
        <flux:heading size="xl">{{ __('Untitled') }}</flux:heading>
        <flux:text class=" mt-2">{{ __('Create and manage your chatbots') }}
        </flux:text>
        <flux:separator variant="subtle" class="my-8" />

        <flux:tab.group class="w-full text-xl!">
            <flux:tabs wire:model="tab">
                <flux:tab class="text-base!" name="knowledge">Knowledge</flux:tab>
                <flux:tab class="text-base!" name="behavior">Behavior</flux:tab>
                <flux:tab class="text-base!" name="connections">Connections</flux:tab>
                <flux:tab class="text-base!" name="settings">Settings</flux:tab>
                <flux:tab class="text-base!" name="install">Install</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="knowledge">
                <flux:text>Knowledge</flux:text>
            </flux:tab.panel>
            <flux:tab.panel name="behavior">
                <flux:text>Knowledge</flux:text>
            </flux:tab.panel>
            <flux:tab.panel name="connections">
                <flux:text>Knowledge</flux:text>
            </flux:tab.panel>
            <flux:tab.panel name="settings">
                <flux:text>Knowledge</flux:text>
            </flux:tab.panel>
            <flux:tab.panel name="install">
                <flux:text>Knowledge</flux:text>
            </flux:tab.panel>
        </flux:tab.group>
    </div>


    <!-- Begin Chatbot Preview -->
    <div class="max-w-130 flex p-5 justify-center h-[calc(100vh-4rem)]">
        <flux:card class="relative h-full w-full bg-white! overflow-hidden p-0! border-none rounded-3xl!">
            <div class="bg-linear-to-r/decreasing from-accent to-accent/70 space-y-4 p-10 text-center">
                <flux:heading size="xl">Chat with our AI</flux:heading>
                <flux:text class="text-white">
                    Ask anything you want to know about our products and services.
                </flux:text>
                <flux:button icon="chat-bubble-bottom-center-text" variant="primary"
                    class="rounded-lg bg-black/40 hover:bg-black/20 shadow-none! border-none!">
                    <flux:text class="text-white!">Chat with AI</flux:text>
                </flux:button>
            </div>

            <div class="p-5 space-y-4 h-[60%] overflow-auto">

                <div class="flex gap-4 group">
                    <flux:icon name="chat-bubble-bottom-center-text" class="size-8 text-gray-900" />
                    <flux:card
                        class="w-full border-none shadow-none even:mr-10 odd:ml-20 group-even:bg-accent! group-odd:bg-gray-300!  rounded-none! p-4! rounded-b-xl! odd:rounded-tl-xl! even:rounded-tr-xl!">
                        <flux:text class="text-black text-base! group-even:text-gray-200!">
                            Sorry, I don't have any knowledge yet.

                            I need to be trained before I can answer questions.

                            Click the Knowledge tab to add knowledge.
                        </flux:text>
                    </flux:card>
                </div>

                <div class="flex gap-4 group">
                    <flux:card
                        class="w-full border-none shadow-none even:mr-10 odd:ml-20 group-even:bg-accent! group-odd:bg-gray-300!  rounded-none! p-4! rounded-b-xl! odd:rounded-tl-xl! even:rounded-tr-xl!">
                        <flux:text class="text-black text-base! group-even:text-gray-200!">
                            Sorry, I don't have any knowledge yet.

                            I need to be trained before I can answer questions.

                            Click the Knowledge tab to add knowledge.
                        </flux:text>
                    </flux:card>
                </div>
                <div class="flex gap-4 group">
                    <flux:card
                        class="w-full border-none shadow-none even:mr-10 odd:ml-20 group-even:bg-accent! group-odd:bg-gray-300!  rounded-none! p-4! rounded-b-xl! odd:rounded-tl-xl! even:rounded-tr-xl!">
                        <flux:text class="text-black text-base! group-even:text-gray-200!">
                            Sorry, I don't have any knowledge yet.

                            I need to be trained before I can answer questions.

                            Click the Knowledge tab to add knowledge.
                        </flux:text>
                    </flux:card>
                </div>
                <div class="flex gap-4 group">
                    <flux:card
                        class="w-full border-none shadow-none even:mr-10 odd:ml-20 group-even:bg-accent! group-odd:bg-gray-300!  rounded-none! p-4! rounded-b-xl! odd:rounded-tl-xl! even:rounded-tr-xl!">
                        <flux:text class="text-black text-base! group-even:text-gray-200!">
                            Sorry, I don't have any knowledge yet.

                            I need to be trained before I can answer questions.

                            Click the Knowledge tab to add knowledge.
                        </flux:text>
                    </flux:card>
                </div>
                <div class="flex gap-4 group">
                    <flux:card
                        class="w-full border-none shadow-none even:mr-10 odd:ml-20 group-even:bg-accent! group-odd:bg-gray-300!  rounded-none! p-4! rounded-b-xl! odd:rounded-tl-xl! even:rounded-tr-xl!">
                        <flux:text class="text-black text-base! group-even:text-gray-200!">
                            Sorry, I don't have any knowledge yet.

                            I need to be trained before I can answer questions.

                            Click the Knowledge tab to add knowledge.
                        </flux:text>
                    </flux:card>
                </div>
                <div class="flex gap-4 group">
                    <flux:card
                        class="w-full border-none shadow-none even:mr-10 odd:ml-20 group-even:bg-accent! group-odd:bg-gray-300!  rounded-none! p-4! rounded-b-xl! odd:rounded-tl-xl! even:rounded-tr-xl!">
                        <flux:text class="text-black text-base! group-even:text-gray-200!">
                            Sorry, I don't have any knowledge yet.

                            I need to be trained before I can answer questions.

                            Click the Knowledge tab to add knowledge.
                        </flux:text>
                    </flux:card>
                </div>
                <div class="flex gap-4 group">
                    <flux:card
                        class="w-full border-none shadow-none even:mr-10 odd:ml-20 group-even:bg-accent! group-odd:bg-gray-300!  rounded-none! p-4! rounded-b-xl! odd:rounded-tl-xl! even:rounded-tr-xl!">
                        <flux:text class="text-black text-base! group-even:text-gray-200!">
                            Sorry, I don't have any knowledge yet.

                            I need to be trained before I can answer questions.

                            Click the Knowledge tab to add knowledge.
                        </flux:text>
                    </flux:card>
                </div>

            </div>

            <div class="p-2 absolute bottom-0 left-0 h-[12%] bg-gray-100 right-0">
                <flux:card
                    class="bg-white!  ring-1! ring-gray-300/50! flex h-[50%]! items-center justify-between w-full">
                    <flux:input class:input="text-black!" placeholder="Type your message here..." />
                    <flux:button icon="paper-airplane" class="text-black!" variant="ghost" />
                </flux:card>
                <div class="flex gap-1 items-center  justify-center h-[calc(50%)]">
                    <flux:text class="text-gray-500 text-xs">
                        Powered by
                    </flux:text>
                    <flux:text class="text-accent font-bold text-xs">
                        Assitly
                    </flux:text>
                </div>
                <div>
                    ss
                </div>
        </flux:card>
    </div>
    <!-- End Chatbot Preview -->
</div>
