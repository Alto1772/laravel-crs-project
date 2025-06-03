<x-slot name="title">
    <div class="flex divide-x-2 divide-base-content/70 *:px-4">
        <span>
            {{ $questionnaire->board_program->fullName('-') }}
        </span>
        <span>Questionnaire</span>
    </div>
</x-slot>

<div class="mx-auto lg:px-[8%] max-w-screen-lg">
    <div class="flex gap-3 items-center">
        <!-- Go Back Button -->
        <a href="{{ route('admin.questionnaires') }}" class="btn btn-secondary btn-outline">
            <span class="icon-[tabler--arrow-left] size-5"></span>
            <span class="max-md:hidden">Go back</span>
        </a>

        <h2 class="flex-1 text-2xl font-bold text-center">Questionnaire Summary</h2>

        <!-- Import Button -->
        <div class="join">
            <button class="btn btn-primary join-item btn-soft" type="button" data-overlay="#importAnswersModal">
                <span class="icon-[tabler--file-import] size-5"></span>
                <span class="max-md:hidden">Import</span>
            </button>
            <x-dropdown>
                <x-slot name="toggle">
                    <x-dropdown.button class="btn-primary btn-square join-item">
                    </x-dropdown.button>
                </x-slot>

                <li><a class="dropdown-item" href="#">My Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Billing</a></li>
                <li><a class="dropdown-item" href="#">FAQs</a></li>
                <x-dropdown.item><a href="#">Test Item</a></x-dropdown.item>

            </x-dropdown>
        </div>

        <!-- Actions Button -->
        <x-dropdown>
            <x-slot name="toggle">
                <x-tooltip class="[--placement:bottom]" message="Actions">
                    <x-dropdown.button class="btn-text btn-secondary btn-square" :noIcon="true">
                        <span class="icon-[tabler--dots-vertical]"></span>
                    </x-dropdown.button>
                </x-tooltip>
            </x-slot>

            <li><a class="dropdown-item" href="#">My Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Billing</a></li>
            <li><a class="dropdown-item" href="#">FAQs</a></li>
        </x-dropdown>
    </div>

    {{-- <pre class="text-wrap my-6">{{ $questionnaire->toJson() }}</pre> --}}

    <div class="mt-4">
        <div class="stats grid text-center">
            <div class="stat">
                <div class="stat-title">Dataset Count</div>
                <div class="stat-value">{{ $questionnaire->answers_count }}</div>
            </div>
            <div class="stat">
                <div class="stat-title">Row Count</div>
                <div class="stat-value">{{ $questionnaire->answer_rows_count }}</div>
            </div>
        </div>
    </div>
    <div class="mt-4 overflow-x-scroll">
        <table class="table table-md rounded border border-base-content/25">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Question</th>
                    <th>Choices</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questionnaire->questions as $question)
                    @foreach ($question->choices as $choice)
                        <tr>
                            @if ($loop->first)
                                <td rowspan="{{ $loop->count }}" class="max-w-0">
                                    {{ $loop->parent->index + 1 }}
                                </td>
                                <td rowspan="{{ $loop->count }}" class="w-1/2 max-w-0 truncate text-wrap">
                                    {{ $question->title }}
                                </td>
                            @endif
                            <td class="w-1/2 max-w-0 truncate">{{ $choice->text }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <livewire:import-answers-modal :$questionnaire />
</div>
