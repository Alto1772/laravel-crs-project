@props([
    "data",
])

<nav
    role="navigation"
    aria-label="Pagination Navigation"
    class="flex items-center justify-between gap-3 border-t border-base-content/25 p-3 max-md:flex-wrap max-md:justify-center"
>
    <div class="text-sm text-base-content/80">
        Showing
        <span>{{ $data->firstItem() ?? 0 }}</span>
        to
        <span>{{ $data->lastItem() ?? 0 }}</span>
        of
        <span>{{ $data->total() }}</span>
        users
    </div>
    <div class="flex items-center space-x-1">
        @if ($data->hasPages())
            <button
                rel="prev"
                class="btn btn-circle btn-text btn-sm"
                @disabled($data->onFirstPage())
                wire:click="previousPage('page')"
            >
                <span aria-hidden="true">«</span>
                <span class="sr-only">Previous</span>
            </button>
            <div
                class="flex items-center space-x-1 [&>.active]:text-bg-soft-primary"
            >
                @foreach ($data->onEachSide(1)->links()->elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span
                            class="relative -ml-px inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700"
                        >
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <button
                                wire:click="gotoPage({{ $page }}, 'page')"
                                @class(["btn btn-circle btn-text btn-sm", "active" => $page === $data->currentPage()])
                            >
                                {{ $page }}
                            </button>
                        @endforeach
                    @endif
                @endforeach
            </div>
            <button
                class="btn btn-circle btn-text btn-sm"
                @disabled(! $data->hasMorePages())
                wire:click="nextPage('page')"
                rel="next"
            >
                <span class="sr-only">Next</span>
                <span aria-hidden="true">»</span>
            </button>
        @endif
    </div>
</nav>
