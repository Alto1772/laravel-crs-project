@aware(['id' => null])

<button
    {{ $attributes->class(['dropdown-toggle flex items-center'])->merge([
        'id' => $id,
        'type' => 'button',
        'aria-haspopup' => 'menu',
        'aria-expanded' => 'false',
        'aria-label' => 'Dropdown',
    ]) }}>
    {{ $slot }}
</button>
