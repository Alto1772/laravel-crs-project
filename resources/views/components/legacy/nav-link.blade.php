@props([
    "active",
])

@php
    $classes =
        "relative inline-block after:absolute after:-bottom-2 after:left-0 after:h-0.5 after:bg-gray-800 after:duration-500 " .
        ($active ?? false ? "after:w-full" : "after:w-0 hover:after:w-full");
@endphp

<a {{ $attributes->merge(["class" => $classes]) }}>
    {{ $slot }}
</a>
