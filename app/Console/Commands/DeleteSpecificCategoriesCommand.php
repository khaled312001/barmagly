<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\DeleteSpecificCategoriesSeeder;

class DeleteSpecificCategoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'barmagly:delete-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete specific categories (الأجهزة المنزلية, البرمجة, نمط الأعمال, الإلكترونيات)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🗑️  Starting deletion of specific categories...');
        $this->newLine();

        try {
            $seeder = new DeleteSpecificCategoriesSeeder();
            $seeder->setCommand($this);
            $seeder->run();

            $this->newLine();
            $this->info('✅ Categories deletion completed successfully!');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error deleting categories: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            
            return Command::FAILURE;
        }
    }
}
