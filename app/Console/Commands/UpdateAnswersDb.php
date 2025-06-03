<?php

namespace App\Console\Commands;

use App\Models\Answer;
use App\Services\AnswerService;
use Illuminate\Console\Command;

class UpdateAnswersDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-answers-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(AnswerService $questionService)
    {
        $this->info('Deleting all records from the answers table...');
        Answer::query()->delete();

        $this->info('Populating the new records from the database/raw-datasets folder...');
        // Model::unguard();
        // TODO: There should be a status error here. Mabye construct an error message or something
        $questionService->importAnswersFromDatabaseFolder();
        $this->info('Successfully imported all new fresh records.');
        // $this->fail('Error importing some answers data. Please check laravel.log for details.');
    }
}
