<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run PHPUnit with code coverage and generate HTML report';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('Running PHPUnit with code coverage and generating HTML report...');

        system('vendor/bin/phpunit --coverage-html coverage-report', $resultCode);

        if ($resultCode === 0) {
            $this->info('Test report generated successfully.');
        } else {
            $this->error('Error generating test report.');
        }

        return $resultCode;
    }
}
