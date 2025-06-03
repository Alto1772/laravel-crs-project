<?php

namespace Database\Seeders;

use App\Services\AnswerService;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(AnswerService $questionService): void
    {
        $questionService->importAnswersFromDatabaseFolder();
    }
}
