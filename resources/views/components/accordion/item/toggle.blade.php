@aware(['active' => false, 'id' => null, 'iconType' => 'chevron'])

<button
    {{ $attributes->class('accordion-toggle me-auto inline-flex items-center pe-0 text-start')->merge([
        'aria-controls' => $id !== null ? "{$id}-collapse" : null,
        'aria-expanded' => $active,
    ]) }}>

    @switch($iconType)
        @case('chevron')
            <span
                class="icon-[tabler--chevron-right] me-4 block size-4.5 shrink-0 text-base-content transition-transform duration-300 accordion-item-active:rotate-90"></span>
        @break

        @case('plus')
            <span class="icon-[tabler--plus] me-4 accordion-item-active:hidden text-base-content size-4.5 block shrink-0"></span>
            <span
                class="icon-[tabler--minus] me-4 accordion-item-active:block text-base-content size-4.5 hidden shrink-0"></span>
        @break
    @endswitch
    {{ $slot }}
</button>
