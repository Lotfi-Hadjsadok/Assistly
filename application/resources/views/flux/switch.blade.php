@props([
    'name' => null,
    'align' => 'right',
])

@php
    // We only want to show the name attribute it has been set manually
    // but not if it has been set from the `wire:model` attribute...
    $showName = isset($name);
    if (!isset($name)) {
        $name = $attributes->whereStartsWith('wire:model')->first();
    }

    $classes = Flux::classes()
        ->add('group h-6 w-12 min-w-8 relative inline-flex items-center outline-offset-2')
        ->add('rounded-full')
        ->add('cursor-pointer')
        ->add('transition')
        ->add(
            'bg-zinc-800/15 [&[disabled]]:opacity-50 dark:bg-transparent dark:border dark:border-white/20 dark:[&[disabled]]:border-white/10',
        )
        ->add('[print-color-adjust:exact]')
        ->add(['data-checked:bg-(--color-accent)', 'data-checked:border-0']);

    $indicatorClasses = Flux::classes()
        ->add('size-4')
        ->add('rounded-full')
        ->add('transition translate-x-[3px] dark:translate-x-[2px] rtl:-translate-x-[3px] dark:rtl:-translate-x-[2px]')
        ->add('bg-white')
        ->add([
            'group-data-checked:translate-x-7 rtl:group-data-checked:-translate-x-7',
            'group-data-checked:bg-(--color-accent-foreground)',
        ]);
@endphp

@if ($align === 'left' || $align === 'start')
    <flux:with-inline-field :$attributes>
        <ui-switch {{ $attributes->class($classes) }}
            @if ($showName) name="{{ $name }}" @endif data-flux-control data-flux-switch>
            <span class="{{ \Illuminate\Support\Arr::toCssClasses($indicatorClasses) }}"></span>
        </ui-switch>
    </flux:with-inline-field>
@else
    <flux:with-reversed-inline-field :$attributes>
        <ui-switch {{ $attributes->class($classes) }}
            @if ($showName) name="{{ $name }}" @endif data-flux-control data-flux-switch>
            <span class="{{ \Illuminate\Support\Arr::toCssClasses($indicatorClasses) }}"></span>
        </ui-switch>
    </flux:with-reversed-inline-field>
@endif
