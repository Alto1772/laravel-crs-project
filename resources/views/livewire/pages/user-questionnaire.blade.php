<x-main-container>
    <form wire:submit='submit' class="max-w-2xl sm:space-y-6 space-y-2 mx-auto" x-data="{
        scrollTo: () => {
            $nextTick(() => document.querySelector('.card.has-error')?.scrollIntoView())
        }
    }"
        x-on:validation-error.window="scrollTo()">

        @session('warning')
            <x-alert class="alert-warning" dismissible>
                {{ $value }}
            </x-alert>
        @endsession

        @foreach ($questions as $question)
            <div @class([
                'card sm:px-6',
                'has-error ring-2 ring-error' => $this->checkQuestionIsRequired(
                    $question->id),
            ]) id="question-{{ $question->id }}">
                <div class="card-header">
                    <h3 class="text-lg flex gap-x-2">
                        <p class="flex-1">{!! Str::replace('\n', '<br>', e($question->title)) !!}</p>
                        <span class="text-red-700 font-bold select-none">*</span>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @foreach ($question->choices->sortBy('order_index') as $choice)
                            <div class="flex items-start gap-2">
                                <input type="radio" wire:model="userAnswers.{{ $question->id }}"
                                    class="radio radio-primary" id="userAnswers.{{ $question->id }}.{{ $loop->index }}"
                                    name="userAnswers.{{ $question->id }}" value="{{ $choice->order_index }}">
                                <label for="userAnswers.{{ $question->id }}.{{ $loop->index }}"
                                    class="label label-text">{{ $choice->text }}</label>
                            </div>
                            {{-- DEBUG --}}
                            {{-- @if ($loop->last)
                                <div class="flex items-start gap-2">
                                    <input type="radio" wire:model="userAnswers.{{ $question->id }}"
                                        name="userAnswers.{{ $question->id }}" class="radio radio-primary"
                                        value="{{ $choice->order_index + 1 }}">
                                    <label for="userAnswers.{{ $question->id }}" class="label label-text">Nonexistent
                                        choice</label>
                                </div>
                            @endif --}}
                        @endforeach
                    </div>

                    @if ($this->checkQuestionIsRequired($question->id))
                        @error('userAnswers.' . $question->id)
                            <p class="text-error text-sm mt-6">* {{ $message }}</p>
                        @else
                            <p class="text-error text-sm mt-6">* Required</p>
                        @enderror
                    @endif
                </div>
            </div>
        @endforeach

        <div class="flex gap-2 justify-between">
            <div class="join">
                <a href="{{ $previousPageUrl ?? route('questionnaire.input-name') }}"
                    class="btn btn-secondary btn-soft join-item">
                    <span class="icon-[tabler--arrow-left] size-5"></span>
                    <span class="sm:hidden">Prev</span>
                    <span class="max-sm:hidden">Previous</span>
                </a>
                <x-tooltip message="Restart">
                    <a href="{{ route('questionnaire.take') }}"
                        class="btn btn-secondary btn-soft btn-square join-item">
                        <span class="icon-[tabler--reload] size-5"></span>
                    </a>
                </x-tooltip>
            </div>
            @if ($canSkipToResults)
                <a href="{{ route('assessment-results') }}" class="btn btn-accent btn-text">Skip to Results
                    <span class="icon-[tabler--chevrons-right]"></span>
                </a>
            @endif
            <button type="submit" @class(['btn btn-primary', 'font-bold' => !$hasMorePages])>
                @if ($hasMorePages)
                    Next
                    <span class="icon-[tabler--arrow-right] size-5" wire:loading.remove></span>
                @else
                    Submit
                @endif
                <span class="loading loading-spinner loading-sm" wire:loading></span>
            </button>
        </div>
    </form>
</x-main-container>
