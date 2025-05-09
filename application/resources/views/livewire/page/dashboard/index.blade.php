<div>
    <flux:heading size="xl">{{ __('Dashboard') }}</flux:heading>
    <flux:separator variant="subtle" class="my-8" />
    <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">
        <div class="w-80">
            <flux:heading size="lg">{{ __('Profile') }}</flux:heading>
            <flux:subheading>{{ __('This is how others will see you on the site.') }}</flux:subheading>
        </div>
        <div class="flex-1 space-y-6">
            <flux:input label="{{ __('Username') }}"
                description="{{ __('This is your public display name. It can be your real name or a pseudonym. You can only change this once every 30 days.') }}"
                placeholder="calebporzio" />
            <flux:select label="{{ __('Primary email') }}"
                description:trailing="{{ __('You can manage verified email addresses in your email settings.') }}"
                placeholder="{{ __('Select primary email...') }}">
                <flux:select.option>lotrrules22@aol.com</flux:select.option>
                <flux:select.option>phantomatrix@hotmail.com</flux:select.option>
            </flux:select>
            <flux:textarea label="{{ __('Bio') }}"
                description:trailing="{{ __('You can @mention other users and organizations to link to them.') }}"
                placeholder="{{ __('Tell us a little bit about yourself') }}" />
        </div>
