@props([
    "messages",
])

@if ($messages)
    <ul
        {{ $attributes->merge(["class" => "text-sm font-semibold text-red-800 space-y-1"]) }}
    >
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
