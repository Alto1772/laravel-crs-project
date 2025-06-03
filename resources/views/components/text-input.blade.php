@props([
    "variant" => "default",
    "size" => null,
    "id" => "text",
    "type" => "text",
    "label" => "Label",
    "placeholder" => "",
    "isInvalid" => false,
    "isValid" => false,
    "labelMessage" => "",
])

@php
    switch ($variant) {
        case "floating":
            $parentClasses = "relative";
            $inputClasses = "input input-floating peer";
            $labelClasses = "input-floating-label";
            break;
        case "filled":
            $parentClasses = "relative";
            $inputClasses = "input input-filled peer";
            $labelClasses = "input-filled-label";
            break;
        default:
            $parentClasses = "";
            $inputClasses = "input";
            $labelClasses = "label label-text";
            break;
    }

    $inputClasses .= match ($size) {
        "sm" => " input-sm",
        "lg" => " input-lg",
        default => "",
    };

    if ($isInvalid) {
        $inputClasses .= " is-invalid";
    }
    if ($isValid) {
        $inputClasses .= " is-valid";
    }
@endphp

<div {{ $attributes->only("class")->class($parentClasses) }}>
    @if ($variant === "default")
        <label for="{{ $id }}" class="{{ $labelClasses }}">
            {{ $label }}
        </label>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->except("class")->class($inputClasses) }}
    />
    @if ($variant !== "default")
        <label for="{{ $id }}" class="{{ $labelClasses }}">
            {{ $label }}
        </label>
    @endif

    @if ($variant === "filled")
        <span class="input-filled-focused"></span>
    @endif

    @if (($isInvalid || $isValid) && ! empty($labelMessage))
        <span class="label label-text-alt">{{ $labelMessage }}</span>
    @endif
</div>
