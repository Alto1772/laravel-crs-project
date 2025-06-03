<x-modal id="createQuestionnaireModal" wire:ignore.self class="[--overlay-backdrop:static] modal-middle"
    data-overlay-keyboard="false"
    x-on:show-import-modal.window="
        $wire.$set('programId', $event.detail.id, false)
        window.HSOverlay.open($el)"
    x-on:close-import-modal.window="window.HSOverlay.close($el)">

    <x-slot:title>Import & Create</x-slot:title>
    <x-slot:body class="space-y-4">
        <div>
            <label class="label label-text" for="programName">Board Program Name</label>
            <select class="select @error('programId') is-invalid @enderror" id="programName" wire:model="programId">
                @foreach ($boardPrograms as $program)
                    <option value="{{ $program->id }}">{{ $program->full_name }}
                    </option>
                @endforeach
            </select>
            @error('programId')
                <div class="label label-text-alt">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <x-upload-file wire:model="inputJson" label="Questionnaire JSON file" />
    </x-slot:body>
</x-modal>
