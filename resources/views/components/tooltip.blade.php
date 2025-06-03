@php
    use Illuminate\View\ComponentSlot;
@endphp

<div {{ $attributes->class('tooltip inline-flex') }}>
    {{ $slot }}
    <span class="tooltip-content tooltip-shown:visible tooltip-shown:opacity-100" role="tooltip">
        @php
            if (!($message instanceof ComponentSlot)) {
                $message = new ComponentSlot($message);
            }
        @endphp

        <span {{ $message->attributes->class('tooltip-body') }}>
            {{ $message }}
        </span>
    </span>
</div>
