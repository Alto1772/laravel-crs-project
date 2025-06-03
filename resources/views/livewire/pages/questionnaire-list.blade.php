<div class="mx-auto lg:px-[8%]">
    <x-loading-overlay liveLoading inMainContainer />

    <div class="mb-6">
        @session('success')
            <x-alert id="success-alert" class="alert-success alert-soft" dismissible>
                {{ $value }}
            </x-alert>
        @endsession
    </div>

    {{-- TODO add search bar and sort by options --}}

    @if ($boardPrograms->count() > 0)
        <x-accordion class="accordion-shadow" data-accordion-always-open>
            @foreach ($boardPrograms as $program)
                <x-accordion.item wire:key="program-{{ $program->id }}" id="item-program-{{ $program->id }}">
                    <x-slot:heading>
                        <x-accordion.item.toggle>
                            <x-tooltip :message="$program->long_name">
                                {{ $program->full_name }}
                            </x-tooltip>
                            @if ($program->questions_count > 0)
                                <span class="badge badge-neutral badge-soft badge-sm ms-2 gap-1">
                                    {{ $program->questions_count }} <span class="max-sm:hidden">questions</span>
                                </span>
                            @endif
                        </x-accordion.item.toggle>
                        @if ($program->questionnaires->count() > 0)
                            {{-- First View Button --}}
                            <x-tooltip>
                                <a href="{{ route('admin.questionnaires.show', $program->questionnaires->first()) }}"
                                    class="tooltip-toggle flex items-center gap-x-2 text-nowrap text-accent"
                                    aria-label="First View Button">
                                    <span class="icon-[tabler--eye-edit] block size-5"></span>
                                    View
                                </a>

                                <x-slot:message class="tooltip-accent">
                                    View first questionnaire
                                </x-slot:message>
                            </x-tooltip>
                        @endif

                        {{-- Delete Questionnaires Button --}}
                        <x-tooltip>
                            <button class="tooltip-toggle" aria-label="Delete All Contents Button"
                                wire:confirm="Are you sure you want to delete the contents of &quot;{{ $program->full_name }}&quot;?"
                                wire:click="deleteQuestionnaires({{ $program->id }})">
                                <span class="icon-[tabler--trash-x-filled] block size-5 text-error"></span>
                            </button>

                            <x-slot:message class="tooltip-error">
                                Delete All Questionnaires
                            </x-slot:message>
                        </x-tooltip>

                        {{-- Create Questionnaire Button --}}
                        {{-- TODO open up a modal that contains file input --}}
                        <x-tooltip message="Import and Create Questionnaire">
                            <button type="button" class="tooltip-toggle" aria-label="Import and Create Button"
                                x-on:click="$dispatch('show-import-modal', { id: {{ $program->id }} } )">
                                <span class="icon-[tabler--library-plus] block size-5"></span>
                            </button>
                        </x-tooltip>
                    </x-slot:heading>

                    <x-slot:content role="region">
                        <div class="px-5 pb-4">
                            {{-- Questionnaire List --}}
                            @if ($program->questionnaires->count() > 0)
                                <div
                                    class="flex w-full flex-col divide-y divide-base-content/25 rounded-md border border-base-content/25 *:p-3 first:*:rounded-t-md last:*:rounded-b-md">
                                    @foreach ($program->questionnaires as $questionnaire)
                                        <div class="flex items-center">
                                            <a href="{{ route('admin.questionnaires.show', $questionnaire) }}"
                                                class="link link-primary inline-flex items-center no-underline flex-grow">
                                                <span class="icon-[tabler--arrow-right] me-3 size-5"></span>
                                                Questionnaire ID - {{ $questionnaire->id }}
                                            </a>
                                            <x-tooltip>
                                                <button class="leading-none"
                                                    wire:confirm="Are you sure you want to delete {{ $questionnaire->id }}?"
                                                    wire:click="deleteQuestionnaire({{ $questionnaire->id }})">
                                                    <span class="icon-[tabler--x] size-5 text-error"></span>
                                                </button>

                                                <x-slot:message class="tooltip-error">
                                                    Delete Entry
                                                </x-slot:message>
                                            </x-tooltip>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center text-sm italic text-base-content/60">
                                    No questionnaires found for this board program...
                                </p>
                            @endif
                        </div>
                    </x-slot:content>
                </x-accordion.item>
            @endforeach
        </x-accordion>
    @else
        <p class="text-center text-sm italic text-base-content/60">
            No board programs found... To create one,
            <a href="{{ route('admin.colleges.create') }}" class="link link-primary">click here</a>
            to add a college with a board program.
        </p>
    @endif

    <livewire:create-questionnaire-modal :$boardPrograms />
</div>
{{--
@assets
    @vite(['resources/js/vendor/notyf.js', 'resources/css/vendor/notyf.css'])
@endassets --}}

@script
    <script>
        // Refresh on page update
        Livewire.hook('morph.added', ({
            el,
            component
        }) => {
            window.HSStaticMethods.autoInit([
                'accordion',
                'tooltip',
                'remove-element',
            ]);
        });
    </script>
@endscript
