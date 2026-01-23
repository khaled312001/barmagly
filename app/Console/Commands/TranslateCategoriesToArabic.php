<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\CategoryTranslation;

class TranslateCategoriesToArabic extends Command
{
    protected $signature = 'translate:categories-arabic';
    protected $description = 'Translate all categories to Arabic';

    public function handle()
    {
        $this->info('Starting categories translation to Arabic...');

        $categories = Category::all();
        
        $translated = 0;
        $skipped = 0;

        $translations = [
            'Programming' => 'البرمجة',
            'Business Style' => 'نمط الأعمال',
            'AI Services' => 'خدمات الذكاء الاصطناعي',
            'Electronics' => 'الإلكترونيات',
            'Home Appliances' => 'تطبيقات الهاتف',
            'Fashion' => 'الموضة',
            'Personal Care' => 'العناية الشخصية',
        ];

        foreach ($categories as $category) {
            // Get English translation
            $englishTranslation = CategoryTranslation::where('category_id', $category->id)
                ->where('lang_code', 'en')
                ->first();

            if (!$englishTranslation) {
                $skipped++;
                $this->warn("Skipping category ID {$category->id} - no English translation found");
                continue;
            }

            // Check if Arabic translation already exists
            $arabicTranslation = CategoryTranslation::where('category_id', $category->id)
                ->where('lang_code', 'ar')
                ->first();

            if ($arabicTranslation) {
                // Update existing
                $arabicTranslation->name = $translations[$englishTranslation->name] ?? $englishTranslation->name;
                $arabicTranslation->save();
            } else {
                // Create new
                $arabicTranslation = new CategoryTranslation();
                $arabicTranslation->category_id = $category->id;
                $arabicTranslation->lang_code = 'ar';
                $arabicTranslation->name = $translations[$englishTranslation->name] ?? $englishTranslation->name;
                $arabicTranslation->save();
            }

            $translated++;
            $this->info("Translated: {$englishTranslation->name} -> {$arabicTranslation->name}");
        }

        $this->info("\nTranslation completed!");
        $this->info("Translated: {$translated} categories");
        $this->info("Skipped: {$skipped} categories");
        
        return 0;
    }
}

