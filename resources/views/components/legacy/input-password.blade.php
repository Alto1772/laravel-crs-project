@props(['id' => 'password'])

@php
    $parentAttribs = $attributes->only('class');
    $inputAttribs = $attributes->except('class');
@endphp

<div {{ $parentAttribs->merge(['class' => 'relative']) }} data-peek="false">
    <x-legacy.text-input :attributes="$inputAttribs->merge(['class' => 'w-full'])" type="password" id="{{ $id }}" />
    <label for="{{ $id }}" class="absolute right-4 top-1/2 size-4 -translate-y-1/2 sm:size-5">
        <span class="icon-[ion--lock-closed-outline] size-full text-fuchsia-700"></span>
    </label>
</div>
