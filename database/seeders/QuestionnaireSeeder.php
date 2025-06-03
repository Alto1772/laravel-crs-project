<?php

namespace Database\Seeders;

use App\Services\QuestionnaireService;
use Illuminate\Database\Seeder;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(QuestionnaireService $questionnaireService): void
    {
        $questionnaireService->importFromDatabaseFolder();
    }
}
