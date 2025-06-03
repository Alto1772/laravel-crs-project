@props(['id' => 'alert', 'dismissible' => false])

<div
    {{ $attributes->class([
            'alert flex items-center gap-4',
            'transition duration-300 ease-in-out removing:-translate-x-5 removing:opacity-0' => $dismissible,
        ])->merge(['role' => 'alert', 'id' => $id]) }}>
    {{ $slot }}
    @if ($dismissible)
        <button class="ms-auto leading-none" type="button" data-remove-element="#{{ $id }}"
            aria-label="Close Button">
            <span class="icon-[tabler--x] size-5"></span>
        </button>
    @endif
</div>
