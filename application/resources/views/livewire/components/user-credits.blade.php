<div>
    <div class="flex flex-col items-center gap-2 bg-zinc-900 border-2 border-cyan-500 rounded-lg p-2">
        <div class="flex items-center gap-2">
            <flux:icon name="sparkles" class="size-6 text-cyan-600" />
            <flux:text class="text-sm text-cyan-600">
                My Credits
            </flux:text>
        </div>
        <flux:text class="text-sm text-cyan-600">
            Knowledge Credits:
            {{ number_format(auth()->user()->knowledge_credits) }}
        </flux:text>
        <flux:text class="text-sm text-cyan-600">
            Answer Credits:
            {{ number_format(auth()->user()->credits) }}
        </flux:text>
    </div>
</div>