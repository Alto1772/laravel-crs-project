@props(['id' => null, 'rtl' => false])

<div
    {{ $attributes->class(['dropdown relative inline-flex', 'rtl:[--placement:bottom-end]' => $rtl]) }}>
    @isset($toggle)
        {{ $toggle }}
    @else
        <x-dropdown.button />
    @endisset

    @php
        $menu ??= $slot;
    @endphp

    <ul
        {{ $menu->attributes->class('dropdown-menu hidden min-w-60 dropdown-open:opacity-100')->merge([
            'role' => 'menu',
            'aria-orientation' => 'vertical',
            'aria-labelledby' => $id,
        ]) }}>
        {{ $menu }}
    </ul>
</div>
