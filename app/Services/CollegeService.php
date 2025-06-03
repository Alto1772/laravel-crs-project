<?php

namespace App\Services;

use App\Http\Resources\CollegeResource;
use App\Models\College;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CollegeService
{
    public function index(): AnonymousResourceCollection|JsonResponse
    {
        $colleges = College::with('board_programs')->get();

        return CollegeResource::collection($colleges);
    }

    public function create(array $data, UploadedFile $image): void
    {
        DB::transaction(function () use ($data, $image) {
            $data['image'] = $image;

            $college = College::create($data);
            $college->board_programs()->createMany($data['programs'] ?? []);
        });

        // Cache::forget('colleges');
    }

    public function importFromData(array $data)
    {
        foreach ($data as $college) {
            $collegeModel = \App\Models\College::create([
                'name' => $college['name'],
                'long_name' => $college['long_name'],
                'description' => $college['description'],
                'image' => $college['image_url'],
            ]);

            // foreach ($college['board_programs'] ?? [] as $boardProgram) {
            //     $collegeModel->board_programs()->createMany([
            //         'name' => $boardProgram['name'],
            //         'long_name' => $boardProgram['long_name'],
            //         'college_id' => $collegeModel->id,
            //     ]);
            // }
            $collegeModel->board_programs()->createMany($college['board_programs']);
        }
    }

    public function importFromJson(): void
    {
        $data = json_decode(file_get_contents(database_path('colleges.json')), true);

        $this->importFromData($data);
    }

    public function update(College $college, array $newData, ?UploadedFile $newImage = null)
    {
        DB::transaction(function () use ($college, $newData, $newImage) {
            if ($newImage !== null) {
                $newData['image'] = $newImage;
            }
            $college->update($newData);

            $programIds = [];
            foreach ($newData['programs'] as $program) {
                if ($program['edited']) {
                    $college->board_programs()->updateOrCreate([
                        'id' => $program['id'],
                    ], [
                        'name' => $program['name'],
                        'long_name' => $program['long_name'],
                    ]);
                }
                $programIds[] = $program['id'];
            }

            $college->board_programs()->whereNotIn('id', $programIds)->delete();
        });

        // Cache::forget('colleges');
    }
}
