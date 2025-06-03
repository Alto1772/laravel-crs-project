@props([
    "name",
    "title",
    "btnName",
    "image",
    "imagePreview",
    "model" => "image",
])

<div
    {{ $attributes->only("class") }}
    x-data
>
    <p class="text-label label sm:hidden">{{ $title }}</p>
    <div class="flex flex-row items-center gap-4 sm:flex-col">
        <div>
            <div
                @class(["relative flex size-28 items-center justify-center rounded-md border-dashed border-base-content/40 sm:size-32", "border-2" => ! $image && empty($imagePreview)])
            >
                <img
                    @if ($image)
                        src="{{ $image->temporaryUrl() }}"
                    @elseif (! empty($imagePreview))
                        src="{{ $imagePreview }}"
                    @endif
                    @class(["absolute z-[2] size-full rounded-md object-cover", "hidden" => ! $image && empty($imagePreview)])
                    alt="image-upload"
                    id="imagePreview"
                    x-ref="imgPrev"
                />
                <span class="icon-[tabler--upload] m-[25%] size-full"></span>
            </div>

            @error("image")
                <p
                    class="mt-1 max-w-28 text-sm leading-tight text-error sm:max-w-32"
                >
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex flex-col gap-2 sm:max-w-full" id="imageForm">
            <label for="upload" class="btn btn-primary sm:btn-sm">
                <span class="icon-[tabler--upload] h-full"></span>
                {{ $btnName }}
                <input
                    type="file"
                    name="{{ $name }}"
                    wire:model="{{ $model }}"
                    id="upload"
                    class="hidden"
                    accept="image/*"
                    {{ $attributes->except("class") }}
                />
            </label>
            <button
                class="btn btn-secondary btn-soft sm:btn-sm"
                type="button"
                @click="if ($wire.imagePreview) {
                        $refs.imgPrev.src = $wire.imagePreview
                    } else {
                        $refs.imgPrev.classList.add('hidden')
                        $refs.imgPrev.parentElement.classList.add('border-2')
                    }
                    $wire.image = null
                "
            >
                Reset
            </button>
        </div>
    </div>
    <p class="text-xs italic leading-4 text-base-content/70 sm:max-w-32">
        Maximum file size allowed is
        <b class="text-base-content">5MB.</b>
    </p>
</div>
