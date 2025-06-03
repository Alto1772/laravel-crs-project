<?php

namespace App\Console\Commands;

use App\Models\Questionnaire;
use App\Services\QuestionnaireService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class UpdateQuestionnairesDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-questionnaires-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(QuestionnaireService $questionnaireService)
    {
        $this->info('Deleting all records from the questionnaires table...');
        Questionnaire::query()->delete();

        $this->info('Populating the new records from the database/questionnaires folder...');
        // Model::unguard();
        if ($questionnaireService->importFromDatabaseFolder()) {
            $this->info('Successfully imported all new fresh records.');
        } else {
            $this->fail('Error importing some questionnaires data. Please check laravel.log for details.');
        }
    }
}
