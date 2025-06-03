@props(['model' => $attributes->get('wire:model')])

<div x-data="{ text: '', uploaded: false }" x-on:livewire-upload-start="uploaded = false; text = 'Uploading'"
    x-on:livewire-upload-finish="uploaded = true; text = 'Upload Complete'">
    @isset($label)
        <label class="label label-text" for="{{ $model }}">{{ $label }}</label>
    @endisset
    <div class="flex">
        <input type="file" class="input flex-grow  @error($model) is-invalid @enderror" :class="uploaded && 'is-valid'"
            id="{{ $model }}" wire:model='{{ $model }}' wire:loading.attr="disabled">
        <span class="ms-4 loading loading-spinner text-accent loading-lg" wire:loading
            wire:target="{{ $model }}"></span>
    </div>
    @error($model)
        <span class="label label-text-alt">{{ $message }}</span>
    @else
        <span class="label label-text-alt" :class="!text && 'hidden'" x-text="text">
        </span>
    @enderror
</div>
