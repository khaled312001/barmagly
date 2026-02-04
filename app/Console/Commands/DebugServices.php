<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Listing\Entities\Listing;
use Modules\Listing\Entities\ListingTranslation;
use Illuminate\Support\Facades\Session;

class DebugServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug service translations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Simulate English Environment
        Session::put('front_lang', 'en');
        app()->setLocale('en');

        $this->info('Environment set to English (en)');

        $services = Listing::where('status', 'enable')
                    ->with('front_translate')
                    ->latest()
                    ->take(5)
                    ->get();
        
        $this->info('Found ' . $services->count() . ' services.');

        foreach($services as $service) {
            $this->info("Service ID: " . $service->id);
            if ($service->front_translate) {
                $this->info("  Loaded Title (via relation): " . $service->front_translate->title);
                $this->info("  Loaded Lang Code: " . $service->front_translate->lang_code);
            } else {
                $this->error("  No translation found for 'en' via relation.");
            }

            // Direct DB check
            $translations = ListingTranslation::where('listing_id', $service->id)->get();
            $this->info("  All DB Translations:");
            foreach($translations as $trans) {
                $this->line("    Lang: " . $trans->lang_code . " | Title: " . $trans->title);
            }
            $this->newLine();
        }
    }
}
