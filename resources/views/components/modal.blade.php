@props(['id' => null])

@php
    use Illuminate\View\ComponentSlot;

    $dialogExtra ??= new ComponentSlot();
    $contentExtra ??= new ComponentSlot();
@endphp

<div
    {{ $attributes->class('overlay modal hidden overflow-y-auto overflow-x-hidden overlay-open:opacity-100 max-md:p-0')->merge([
            'id' => $id,
            'role' => 'dialog',
            'tabindex' => '-1',
        ]) }}>
    <div
        {{ $dialogExtra->attributes->class('overlay-animation-target modal-dialog scale-125 overlay-open:scale-100 overlay-open:opacity-100 overlay-open:duration-300 max-md:max-w-none') }}>
        {{ $dialogExtra }}

        <div
            {{ $contentExtra->attributes->class('modal-content justify-between max-md:h-full max-md:max-h-none max-md:rounded-none') }}>
            {{ $contentExtra }}

            <div class="modal-header">
                @isset($header)
                    {{ $header ?? '' }}
                @elseif (isset($title))
                    <h3 class="modal-title me-3 max-sm:text-lg">
                        {{ $title }}
                    </h3>
                @endisset

                <button type="button" class="btn btn-circle btn-text btn-sm absolute end-3 top-3" aria-label="Close"
                    data-overlay="#{{ $id }}">
                    <span class="icon-[tabler--x] size-4"></span>
                </button>
            </div>

            @php
                // Set the body as the main slot
                $body ??= $slot;
            @endphp

            <div {{ $body->attributes->class('modal-body flex-grow max-sm:text-sm') }}>
                {{ $body }}
            </div>

            @isset($footer)
                <div {{ $footer->attributes->class('modal-footer') }}>
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
