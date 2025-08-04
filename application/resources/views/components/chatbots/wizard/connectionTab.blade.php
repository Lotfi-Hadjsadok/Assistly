<flux:tab.panel name="connections">
    <flux:heading class="text-xl">
        Embed your chatbot
    </flux:heading>
    <div class="space-y-4 mt-4">
        <flux:text>
            Copy and paste the following <code>&lt;iframe&gt;</code> code into your website to embed your chatbot:
        </flux:text>
        <div class="relative">
            <pre
                class="rounded-lg bg-accent/5 border-2 border-accent! text-accent! text-sm p-4 text-wrap"><code>&lt;iframe src="{{ url('/') }}/embed/chatbot/{{ auth()->user()->api_key }}/{{ $chatbot->id }}" width="100%" height="100%" style="position: fixed;bottom:0;right:0;align-items:end;height:100%;width:100%;padding:20px"&gt;&lt;/iframe&gt;</code></pre>
        </div>
    </div>
</flux:tab.panel>