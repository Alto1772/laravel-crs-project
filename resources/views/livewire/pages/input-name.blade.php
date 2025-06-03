<x-main-container>
    <form wire:submit='submit' class="max-w-lg sm:space-y-6 space-y-2 mx-auto">
        @session('warning')
            <x-alert class="alert-warning" dismissible wire:loading.remove>
                {{ $value }}
            </x-alert>
        @endsession

        @if (!empty(session('survey.user-answers')))
            <x-alert class="alert-warning alert-soft flex-col">
                <p>
                    It seems that you have <b>unsaved changes</b> prior to this starting page.
                    Clicking Next below will erase any progress that you have made.
                </p>
                <a class="link" href="{{ route('questionnaire.take') }}">Click here to continue answering.</a>
            </x-alert>
        @endif

        <div class="card sm:px-6">
            <div class="card-header">
                <h1 class="card-title">Enter your name</h1>
                <p class="text-base-content/50">Enter your full name or your nickname below to proceed.</p>
            </div>
            <div class="card-body">
                <input type="text" class="input @error('fullName') is-invalid @enderror" wire:model='fullName'>
                @error('fullName')
                    <span class="label label-text" wire:loading.remove>{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('home') }}" class="btn btn-secondary btn-text btn-square">
                <span class="icon-[tabler--home] size-5"></span>
            </a>
            <button type="submit" class="btn btn-primary">Next <span class="loading loading-spinner loading-sm"
                    wire:loading></span>
                <span class="icon-[tabler--arrow-right] size-5" wire:loading.remove></span>
            </button>
        </div>
    </form>
</x-main-container>
