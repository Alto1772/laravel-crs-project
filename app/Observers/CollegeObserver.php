<?php

namespace App\Observers;

use App\Models\College;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CollegeObserver
{
    private function deleteImage(string $image): void
    {
        if (Str::startsWith($image, '/storage/')) {
            // TODO: this isn't right
            unlink(public_path($image));
        }
    }

    /**
     * Handle the College "creating" event.
     */
    public function creating(College $college): void
    {
        if ($college->isDirty('image') && $college->image instanceof UploadedFile) {
            $newImage = $college->image;

            $filename = Str::slug($college->name) . '.' . $newImage->extension();
            $localImagePath = $newImage->storeAs('colleges', $filename, 'public');
            $storageUrl = Storage::url($localImagePath);
            $college->image = $storageUrl;
        }
    }

    /**
     * Handle the College "updating" event.
     */
    public function updating(College $college): void
    {
        // Ignore the ones that are not modified or as a plain string
        if ($college->isDirty('image') && $college->image instanceof UploadedFile) {
            $newImage = $college->image;
            $oldImageName = $college->getOriginal('image');

            $this->deleteImage($oldImageName);
            $filename = Str::slug($college->name) . '.' . $newImage->extension();
            $localImagePath = $newImage->storeAs('colleges', $filename, 'public');
            $storageUrl = Storage::url($localImagePath);
            $college->image = $storageUrl;
        }
    }

    /**
     * Handle the College "deleting" event.
     */
    public function deleting(College $college): void
    {
        $this->deleteImage($college->image);
    }
}
