<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Listing\Entities\Listing;
use Modules\Listing\Entities\ListingTranslation;
use Illuminate\Support\Facades\Session;

class FixServiceTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix service translations by updating English values';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting service translation fix...');

        // Map of Arabic Text -> English Translation
        $corrections = [
            'برمجة وتصميم مواقع' => 'Web Design & Development',
            'موبايل' => 'Mobile Applications',
            'تسويق' => 'Digital Marketing',
            'سيلز' => 'Sales',
            'استضافة مواقع ودومينات' => 'Web Hosting & Domains',
            'SEO' => 'SEO',
            'استشارات تقنية' => 'Tech Consulting',
            'برمجة' => 'Programming',
            'تصميم' => 'Design',
        ];

        // 1. Get all listings
        $listings = Listing::all();
        $this->info('Found ' . $listings->count() . ' listings.');

        foreach($listings as $listing) {
            // Find English translation specifically
            $enTrans = ListingTranslation::where('listing_id', $listing->id)
                        ->where('lang_code', 'en')
                        ->first();

            if ($enTrans) {
                // Check if the current title is in our Arabic list
                $currentTitle = trim($enTrans->title);
                
                // Flexible matching (contains)
                $newTitle = null;
                foreach($corrections as $arabic => $english) {
                    if (str_contains($currentTitle, $arabic)) {
                        $newTitle = $english;
                        break;
                    }
                }

                if ($newTitle) {
                    $this->info("Updating Listing #{$listing->id}: '{$currentTitle}' -> '{$newTitle}'");
                    $enTrans->title = $newTitle;
                    // Optionally update slug if you want, but might break links. safely skipping slug for now unless critical.
                    $enTrans->save();
                } else {
                    $this->line("Skipping Listing #{$listing->id} ('{$currentTitle}'): No Arabic match found or already English.");
                }
            } else {
                $this->warn("Listing #{$listing->id} has no English translation.");
                // Create one? 
                // Maybe better to wait.
            }
        }

        $this->info('Fix complete.');
    }
}
