<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class KnnServerStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'knn:start
        {--t|retrain : Regenerate training data}
        {--i|force-install : Force install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the KNN Server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $knnServerPath = realpath('./knn-server');

        if (PHP_OS_FAMILY == 'Windows') {
            $pythonPath = 'python.exe';
        } else {
            $pythonPath = 'python3';
        }

        $installPkgs = $this->option('force-install');

        if (! file_exists($knnServerPath . '/.venv')) {
            $this->error('Virtual environment not found. Creating one...');
            $result = Process::run([$pythonPath, '-m', 'venv', $knnServerPath . '/.venv']);
            if ($result->failed()) {
                $this->fail("Error creating .venv file: {$result->errorOutput()}");
            }
            $installPkgs = true;
        }

        if (PHP_OS_FAMILY == 'Windows') {
            $pythonPath = $knnServerPath . '/.venv/Scripts/python.exe';
        } else {
            $pythonPath = $knnServerPath . '/.venv/bin/python3';
        }

        if ($installPkgs) {
            $this->info('Installing necessary Python packages...');
            $result = Process::forever()
                ->run([$pythonPath, '-m', 'pip', 'install', '-r', $knnServerPath . '/requirements.txt']);
            if ($result->failed()) {
                $this->fail("Error installing packages: {$result->errorOutput()}");
            }
        }

        if ($this->option('retrain')) {
            $result = Process::path($knnServerPath)
                ->forever()
                ->run([$pythonPath, $knnServerPath . '/train.py'],
                    function (string $type, string $output) {
                        echo $output;
                    }
                );
            if ($result->failed()) {
                return 1;
            }
        }

        $this->info('Running the KNN Server');
        retry(5, function () use ($knnServerPath, $pythonPath) {
            $process = Process::path($knnServerPath . '/..')
                ->forever()
                ->env(['HOST' => config('knn.host'), 'PORT' => config('knn.port')])
                ->run([$pythonPath, '-m', 'knn-server'],
                    function (string $type, string $output) {
                        echo $output;
                    }
                );
            $process->throw();
        });
    }
}
