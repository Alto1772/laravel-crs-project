@aware(['id' => null, 'noIcon' => false])

<button
    {{ $attributes->class(['dropdown-toggle flex items-center btn'])->merge([
        'id' => $id,
        'type' => 'button',
        'aria-haspopup' => 'menu',
        'aria-expanded' => 'false',
        'aria-label' => 'Dropdown',
    ]) }}>
    {{ $slot }}

    @isset($icon)
        {{ $icon }}
    @elseif(!$noIcon)
        <span class="icon-[tabler--chevron-down] dropdown-open:rotate-180 transition-transform duration-200 size-4"></span>
    @endisset
</button>
