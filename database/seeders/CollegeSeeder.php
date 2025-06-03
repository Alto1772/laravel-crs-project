<?php

namespace Database\Seeders;

use App\Services\CollegeService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(CollegeService $collegeService): void
    {
        Permission::create(['name' => 'create colleges']);
        Permission::create(['name' => 'update colleges']);
        Permission::create(['name' => 'delete colleges']);

        // TODO move this somewhere else
        Permission::create(['name' => 'view all questionnaires']);
        Permission::create(['name' => 'create questionnaires']);
        Permission::create(['name' => 'update questionnaires']);
        Permission::create(['name' => 'delete questionnaires']);

        $collegeService->importFromJson();
    }
}
