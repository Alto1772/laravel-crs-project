@props(['active' => false, 'id' => null, 'iconType' => 'chevron'])

@php
    $content ??= $slot;
    $heading ??= new \Illuminate\View\ComponentSlot('<x-toggle />');
@endphp

<div {{ $attributes->class(['accordion-item', 'active' => $active])->merge(['id' => $id]) }}>
    <div
        {{ $heading->attributes->class('accordion-heading *:py-4 last:*:pe-5 inline-flex w-full items-center gap-x-3.5') }}>
        {{ $heading }}
    </div>
    <div
        {{ $attributes->class(['accordion-content w-full overflow-hidden transition-[height] duration-300', 'hidden' => !$active])->merge([
                'id' => $id !== null ? "{$id}-collapse" : null,
                'aria-labelledby' => $id,
                'role' => 'region',
            ]) }}>
        {{ $content }}
    </div>
</div>
