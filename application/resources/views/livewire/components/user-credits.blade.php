<div>
    <div class="flex flex-col items-center gap-2 bg-white/7 ring-2 ring-accent!  rounded-lg p-2">
        <div class="flex items-center gap-2">
            <flux:icon name="sparkles" class="size-6 text-accent" />
            <flux:text class="text-sm text-accent">
                My Credits
            </flux:text>
        </div>
        <flux:text class="text-sm text-accent">
            Knowledge Credits:
            {{ number_format(auth()->user()->knowledge_credits) }}
        </flux:text>
        <flux:text class="text-sm text-accent">
            Answer Credits:
            {{ number_format(auth()->user()->credits) }}
        </flux:text>
    </div>
</div>