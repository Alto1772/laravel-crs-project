@props([
    "variant" => "default",
    "id" => "text",
    "label" => "Label",
    "placeholder" => "",
    "value" => "",
    "isInvalid" => false,
    "isValid" => false,
    "labelMessage" => "",
])

@php
    switch ($variant) {
        case "floating":
            $parentClasses = "relative";
            $textareaClasses = "textarea peer textarea-floating";
            $labelClasses = "textarea-floating-label";
            break;
        case "filled":
            $parentClasses = "relative";
            $textareaClasses = "textarea peer textarea-filled";
            $labelClasses = "textarea-filled-label";
            break;
        default:
            $parentClasses = "";
            $textareaClasses = "textarea";
            $labelClasses = "label label-text";
            break;
    }

    if ($isInvalid) {
        $textareaClasses .= " is-invalid";
    }
    if ($isValid) {
        $textareaClasses .= " is-valid";
    }
@endphp

<div {{ $attributes->only("class")->class($parentClasses) }}>
    @if ($variant === "default")
        <label for="{{ $id }}" class="{{ $labelClasses }}">
            {{ $label }}
        </label>
    @endif

    <textarea
        id="{{ $id }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->except("class")->class($textareaClasses) }}
    >
{{ $value }}</textarea
    >
    @if ($variant !== "default")
        <label for="{{ $id }}" class="{{ $labelClasses }}">
            {{ $label }}
        </label>
    @endif

    @if ($variant === "filled")
        <span class="textarea-filled-focused"></span>
    @endif

    @if (($isInvalid || $isValid) && ! empty($labelMessage))
        <span class="label label-text-alt">{{ $labelMessage }}</span>
    @endif
</div>
