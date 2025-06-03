<?php

namespace App\Livewire\Pages;

use App\Models\College;
use App\Services\CollegeService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Create College')]
class CollegeForm extends Component
{
    use WithFileUploads;

    public College $college;

    public string $name;

    public string $long_name;

    public string $description;

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile */
    public $image;

    public string $imagePreview;

    public array $programs;

    public function rules(): array
    {
        $rules = [
            'long_name' => 'required',
            'description' => 'required',
            'name' => $this->college->exists ?
                ['required', 'max:8', Rule::unique(College::class)->ignore($this->college)] :
                ['required', 'max:8', Rule::unique(College::class)],
            'image' => $this->college->exists ?
                'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:5120' :
                'required|image|mimes:jpg,png,jpeg,gif,svg|max:5120',
            'programs' => 'required|array',
            'programs.*.name' => 'required',
            'programs.*.long_name' => 'required',
        ];

        return $rules;
    }

    public function mount(College $college)
    {
        $this->college = $college;

        if ($college->exists) {
            $this->name = $college->name;
            $this->long_name = $college->long_name;
            $this->description = $college->description;
            $this->imagePreview = asset($college->image);
            $this->programs = $college->board_programs->map(fn ($item) => [
                'id' => $item->id,
                'name' => $item->name,
                'long_name' => $item->long_name,
                'edited' => false,
                'deleted' => false,
            ])->toArray();
        }
    }

    public function render(): View
    {
        return view('livewire.pages.college-form');
    }

    public function save(CollegeService $collegeService)
    {
        $this->validate();
        $data = $this->except('college', 'image', 'imagePreview');

        if ($this->college->exists) {
            $collegeService->update($this->college, $data, $this->image);
            session()->flash('success', 'College entry updated successfully!');
        } else {
            $collegeService->create($data, $this->image);
            session()->flash('success', 'College entry created successfully!');
        }

        $this->redirectRoute('admin.colleges');
    }
}
