@props([
    'id' => 'loading-overlay',
    'message' => 'Loading...',
    'blur' => true,
    'rounded' => false,
    'inMainContainer' => false,
    'liveLoading' => false,
])

@php
    $attributes = $attributes->class([
        'inset-0 flex flex-col items-center justify-center gap-4 bg-base-300/70',
        'backdrop-blur-sm' => $blur,
        'rounded-lg' => $rounded,
        'fixed lg:left-64 top-16 z-20' => $inMainContainer,
        'absolute z-10' => !$inMainContainer,
    ]);
@endphp

<div @if ($liveLoading) wire:loading.flex @endif id="{{ $id }}" {{ $attributes }}>
    <span class="loading loading-spinner loading-lg text-primary"></span>
    @if (!empty($message))
        <p class="text-xl font-semibold text-primary-content">{{ $message }}</p>
    @endif
</div>
