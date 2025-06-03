<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateAllDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-all-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates colleges, questionnaires, and answers from their respective data files stored in "database" folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call(UpdateCollegesDb::class);
        $this->call(UpdateQuestionnairesDb::class);
        $this->call(UpdateAnswersDb::class);
    }
}
