<x-modal id="importAnswersModal" wire:ignore.self class="[--overlay-backdrop:static] modal-middle"
    data-overlay-keyboard="false">

    <x-slot:title>Import Answers</x-slot:title>
    <x-slot:body class="space-y-3">
        <x-upload-file wire:model='inputCsv' />
        <div class="flex items-center gap-1">
            <input type="checkbox" class="checkbox checkbox-error" id="delAllCheckbox" wire:model='deleteAllAnswers' />
            <label class="label label-text text-base" for="delAllCheckbox">Delete & Import</label>
        </div>

        @session('success')
            <x-alert id="success-alert" class="alert-success alert-outline mt-2" dismissible>
                {{ $value }}
            </x-alert>
        @endsession
        @session('error')
            <x-alert id="error-alert" class="alert-error alert-outline mt-2" dismissible>
                {{ $value }}
            </x-alert>
        @endsession

        {{-- <h3 class="divider my-2 divider-success text-lg">Results</h3>
        <div class="stats max-sm:stats-vertical bg-base-200 shadow-none w-full">
            <div class="stat">
                <div class="stat-title">Imported</div>
                <div class="stat-value text-success">+ 58</div>
                <div class="stat-desc"><b>300</b> overall (initially at 242)</div>
            </div>
            <div class="stat">
                <div class="stat-title">Ignored</div>
                <div class="stat-value text-warning">- 25</div>
                <div class="stat-desc"><b>30%</b> out of 83 imported</div>
            </div>
        </div> --}}
    </x-slot:body>
    <x-slot:footer>
        <button type="button" class="btn btn-secondary max-sm:btn-sm" data-overlay="#importAnswersModal">
            Close
        </button>
    </x-slot:footer>
</x-modal>


@script
    <script>
        // Refresh on page update
        Livewire.hook('morph.added', ({
            el,
            component
        }) => {
            window.HSStaticMethods.autoInit([
                'remove-element',
            ]);
        });
    </script>
@endscript
