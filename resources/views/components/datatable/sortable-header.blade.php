@props([
    "sortField",
    "field",
    "sortDirection",
])

<th scope="col" {{ $attributes }}>
    <div class="flex cursor-pointer items-center justify-between">
        <span>{{ $slot }}</span>
        @if ($sortField === $field)
            @if ($sortDirection === "asc")
                <span class="icon-[tabler--chevron-up]"></span>
            @else
                <span class="icon-[tabler--chevron-down]"></span>
            @endif
        @endif
    </div>
</th>
