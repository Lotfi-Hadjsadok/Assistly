<div class="flex min-h-full flex-col justify-center px-6 py-30 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <flux:heading size="lg" class="mt-10 text-center">Sign in to your account</flux:heading>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" wire:submit="login">
            <flux:field>
                <flux:label>Email address</flux:label>
                <flux:input type="email" id="email" autocomplete="email" required wire:model="email" />
            </flux:field>

            <flux:field>
                <div class="flex items-center justify-between mb-3">
                    <flux:label>Password</flux:label>
                    <flux:text as="span" variant="subtle" class="text-sm">
                        <a href="#" class="font-semibold text-accent">Forgot
                            password?</a>
                    </flux:text>

                </div>
                <flux:input type="password" id="password" autocomplete="current-password" required
                    wire:model="password" />
                @error('password')
                    <flux:text class="text-danger mt-1">
                        {{ $message }}
                    </flux:text>
                @enderror
            </flux:field>

            <div>
                <flux:button type="submit" variant="primary" class="w-full">Sign in</flux:button>
            </div>

        </form>
        @error('email')
            <flux:text class="text-danger mt-1">
                {{ $message }}
            </flux:text>
        @enderror

        <flux:text class="mt-10 text-center text-sm text-gray-500">
            Not a member?
            <a href="#" class="font-semibold text-accent">Start a 14 day free trial</a>
        </flux:text>

    </div>
</div>
