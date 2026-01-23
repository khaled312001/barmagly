<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\UpdateBarmaglyContentSeeder;

class RunBarmaglyContentSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'barmagly:seed-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run UpdateBarmaglyContentSeeder to update all Barmagly content';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting Barmagly Content Seeder...');
        $this->newLine();

        try {
            $seeder = new UpdateBarmaglyContentSeeder();
            $seeder->setCommand($this);
            $seeder->run();

            $this->newLine();
            $this->info('✅ Barmagly Content Seeder completed successfully!');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error running seeder: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            
            return Command::FAILURE;
        }
    }
}
