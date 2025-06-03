<div class="relative mt-4 flex min-h-32 min-w-full max-w-md flex-wrap content-center justify-center gap-4 sm:gap-8">
    @foreach ($colleges as $index => $college)
        <x-image-card class="group size-32 sm:size-44 cursor-pointer">
            <x-slot:bgimage class="absolute inset-0">
                <img src="{{ asset($college->image) }}" alt="{{ $college->name }} overlay logo"
                    class="min-h-full object-cover transition-transform duration-300 group-hover:scale-125 group-hover:blur-sm" />
            </x-slot>
            <x-slot:body aria-haspopup="dialog" aria-expanded="false" aria-controls="college-desc-modal"
                x-on:click="await $wire.select({{ $college }}); HSOverlay.open($refs.desc_modal)"
                class="bg-gray-900/25 transition-all duration-300 group-hover:bg-gray-900/75">
                <p class="text-3xl font-extrabold tracking-widest text-white opacity-0 transition-all duration-300 group-hover:scale-125 group-hover:opacity-100 sm:text-2xl"
                    id="college-name">{{ $college->name }}</p>
            </x-slot>
        </x-image-card>
    @endforeach

    <x-modal class="modal-middle" id="college-desc-modal" x-ref="desc_modal">
        <x-slot:title>
            {{ $selected?->name ?? 'College' }} description
        </x-slot>

        <p>
            {{ $selected?->description ?? fake()->paragraph() }}
        </p>

        @if (!empty($selected?->board_programs))
            <p class="mt-3">
                @if ($selected->board_programs->count() > 1)
                    These are the board programs offered by this college:
                @else
                    This is the board program offered by this college:
                @endif
            </p>

            <ul class="mt-3 list-inside list-disc font-bold">
                @foreach ($selected->board_programs as $program)
                    <li>{{ $program->long_name }}</li>
                @endforeach
            </ul>
        @endif

        <x-slot:footer>
            <button type="button" class="btn btn-secondary max-sm:btn-sm"
                x-on:click="HSOverlay.close($refs.desc_modal)">
                Close
            </button>
            {{--
                        <button type="button" class="btn btn-accent">
                        Start Answering
                        </button>
                    --}}
        </x-slot>
    </x-modal>
</div>


@script
    <script>
        // Refresh on page update
        Livewire.hook('morph.added', ({
            el,
            component
        }) => {
            window.HSStaticMethods.autoInit([
                'overlay',
            ]);
        });
    </script>
@endscript
