<div class="card relative">
    <x-loading-overlay liveLoading wire:target="image" rounded message="Uploading..." />
    <form wire:submit="save">
        <div class="card-body items-center">
            <div class="flex w-full flex-col gap-6 sm:w-11/12 sm:flex-row md:w-4/5">
                <div class="flex-1 space-y-4">
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <x-text-input class="basis-3/12" variant="floating" id="name" wire:model="name"
                            label="Abbrev." :isInvalid="$errors->has('name')" :labelMessage="$errors->first('name')" required maxlength="8" />
                        <x-text-input class="basis-9/12" variant="floating" id="long_name" wire:model="long_name"
                            label="Full Name" :isInvalid="$errors->has('long_name')" :labelMessage="$errors->first('long_name')" required />
                    </div>
                    <x-textarea wire:model="description" id="description" label="Description" :isInvalid="$errors->has('description')"
                        :labelMessage="$errors->first('description')" required />
                </div>
                <x-image-upload class="space-y-2" name="image" title="Logo" btnName="Upload Logo" :$image
                    :$imagePreview />
            </div>

            <x-edit-programs class="mt-8 w-full sm:w-11/12 md:w-4/5" />
        </div>
        <div class="card-footer flex justify-end gap-3">
            <a href="{{ route('admin.colleges') }}" class="btn btn-secondary btn-soft" wire:navigate>
                Go Back
            </a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
