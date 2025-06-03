<x-main-container class="max-w-screen-md mx-auto">
    @session('success')
        <div class="alert alert-success alert-soft mb-4">{{ $value }}</div>
    @endsession
    <div class="card">
        <form class="card-body" wire:submit='send'>
            <h1 class="text-3xl font-bold text-center">Message Us</h1>
            <p class="mt-4 text-base-content/70 text-center">If you have any concerns, questions, or any kind of
                feedback, please fill up the forms to contact us.</p>
            <div class="mt-4">
                <label for="email">Your Email</label>
                <input type="email" id="email" wire:model='email'
                    class="input @error('email') is-invalid @enderror" placeholder="john.doe@gmail.com">
                @error('email')
                    <label for="email" class="label label-text">{{ $message }}</label>
                @enderror
            </div>
            <div class="mt-4">
                <textarea class="textarea min-h-80 @error('feedback') is-invalid @enderror" wire:model='feedback'
                    placeholder="Your lengthy description of your feedback" id="feedback"></textarea>
                @error('feedback')
                    <label for="feedback" class="label label-text">{{ $message }}</label>
                @enderror
            </div>
            <button class="mt-4 btn btn-primary w-max mx-auto" type="submit">Send message</button>
        </form>
    </div>
</x-main-container>
