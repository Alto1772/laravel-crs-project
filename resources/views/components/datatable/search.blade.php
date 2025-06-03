@props(["placeholder" => "Search..."])

<div class="input-group max-w-[15rem]">
    <span class="input-group-text">
        <span
            class="icon-[tabler--search] size-4 shrink-0 text-base-content"
        ></span>
    </span>
    <label class="sr-only" for="table-export-search"></label>
    <input
        type="search"
        class="input input-sm grow"
        {{ $attributes }}
        id="table-export-search"
        placeholder="{{ $placeholder }}"
    />
</div>
