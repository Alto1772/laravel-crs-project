@props([
    "status",
    "type" => "success",
])

@php
    $classes = "rounded border border-lime-900 bg-lime-700/70 px-4 py-5 text-center text-sm text-white";
    $styleClasses = match ($type) {
        "success" => "border-lime-900 bg-lime-700/70",
        "error" => "border-red-900 bg-red-700/70",
        "warning" => "border-amber-900 bg-amber-700/70",
    };

    $classes .= " $styleClasses";
@endphp

@if ($status)
    <div {{ $attributes->merge(["class" => $classes]) }}>
        {{ $status }}
    </div>
@endif
