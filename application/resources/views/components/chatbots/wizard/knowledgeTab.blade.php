<flux:tab.panel name="knowledge">
    <flux:heading class="text-xl">
        Link Knowledge to your chatbot
    </flux:heading>

    <div wire:replace class="space-y-8 mt-4">
        <flux:text class="text-muted-foreground">
            Select the knowledge sources (documents and websites) that your chatbot should use to answer questions.
        </flux:text>

        {{-- Knowledge Documents Section --}}
        <x-chatbots.knowledge-section title="Documents" icon="file-text"
            :linkedItems="$chatbotForm->chatbot->knowledgeDocuments" :availableItems="$this->availableDocuments"
            onUnlink="unlinkDocument" onLink="linkDocument" />

        {{-- Knowledge Websites Section --}}
        <x-chatbots.knowledge-section title="Websites" icon="globe"
            :linkedItems="$chatbotForm->chatbot->knowledgeWebsites" :availableItems="$this->availableWebsites"
            onUnlink="unlinkWebsite" onLink="linkWebsite" />
    </div>
</flux:tab.panel>