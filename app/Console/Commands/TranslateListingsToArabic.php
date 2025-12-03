<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Listing\Entities\Listing;
use Modules\Listing\Entities\ListingTranslation;

class TranslateListingsToArabic extends Command
{
    protected $signature = 'translate:listings-arabic';
    protected $description = 'Translate all listings/services to Arabic';

    public function handle()
    {
        $this->info('Starting listings translation to Arabic...');

        $listings = Listing::where('status', 'enable')->get();
        
        $translated = 0;
        $skipped = 0;

        $translations = [
            'Cyber Security Solutions' => 'حلول الأمن السيبراني',
            'Digital Marketing Services' => 'خدمات التسويق الرقمي',
            'UI/UX & Branding Identity' => 'واجهة المستخدم/تجربة المستخدم والهوية التجارية',
            'Web & Mobile App Development' => 'تطوير تطبيقات الويب والجوال',
            'IT Management Service' => 'خدمة إدارة تكنولوجيا المعلومات',
            'Data Tracking Security' => 'أمان تتبع البيانات',
            'Developing a comprehensive IT strategy that aligns.' => 'تطوير استراتيجية تكنولوجيا معلومات شاملة تتماشى مع أهدافك.',
        ];

        foreach ($listings as $listing) {
            // Get English translation
            $englishTranslation = ListingTranslation::where('listing_id', $listing->id)
                ->where('lang_code', 'en')
                ->first();

            if (!$englishTranslation) {
                $skipped++;
                $this->warn("Skipping listing ID {$listing->id} - no English translation found");
                continue;
            }

            // Check if Arabic translation already exists
            $arabicTranslation = ListingTranslation::where('listing_id', $listing->id)
                ->where('lang_code', 'ar')
                ->first();

            if ($arabicTranslation) {
                // Update existing
                $arabicTranslation->title = $translations[$englishTranslation->title] ?? $englishTranslation->title;
                $arabicTranslation->short_description = $translations[$englishTranslation->short_description] ?? $englishTranslation->short_description;
                $arabicTranslation->description = $englishTranslation->description; // Keep same for now, can be translated later
                $arabicTranslation->save();
            } else {
                // Create new
                $arabicTranslation = new ListingTranslation();
                $arabicTranslation->listing_id = $listing->id;
                $arabicTranslation->lang_code = 'ar';
                $arabicTranslation->title = $translations[$englishTranslation->title] ?? $englishTranslation->title;
                $arabicTranslation->short_description = $translations[$englishTranslation->short_description] ?? $englishTranslation->short_description;
                $arabicTranslation->description = $englishTranslation->description; // Keep same for now
                $arabicTranslation->save();
            }

            $translated++;
            $this->info("Translated: {$englishTranslation->title} -> {$arabicTranslation->title}");
        }

        $this->info("\nTranslation completed!");
        $this->info("Translated: {$translated} listings");
        $this->info("Skipped: {$skipped} listings");
        
        return 0;
    }
}

