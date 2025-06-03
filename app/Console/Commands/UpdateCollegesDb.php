<?php

namespace App\Console\Commands;

use App\Models\College;
use App\Services\CollegeService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class UpdateCollegesDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-colleges-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs the college table with colleges.json file in the database, deleting all records from the table';

    /**
     * Execute the console command.
     */
    public function handle(CollegeService $collegeService)
    {
        $this->info('Deleting all records from the college table...');
        College::query()->delete();

        $this->info('Populating the new records from the colleges.json file...');
        Model::unguard();
        $collegeService->importFromJson();
    }
}
