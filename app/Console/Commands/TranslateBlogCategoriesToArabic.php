<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Blog\App\Models\BlogCategory;
use Modules\Blog\App\Models\BlogCategoryTranslation;

class TranslateBlogCategoriesToArabic extends Command
{
    protected $signature = 'translate:blog-categories-arabic';
    protected $description = 'Translate all blog categories to Arabic';

    public function handle()
    {
        $this->info('Starting blog categories translation to Arabic...');

        $categories = BlogCategory::all();
        
        $translated = 0;
        $skipped = 0;

        $translations = [
            'Technology' => 'التكنولوجيا',
            'Web Design' => 'تصميم الويب',
            'Flutter Apps' => 'تطبيقات Flutter',
            'Marketing' => 'التسويق',
            'Business' => 'الأعمال',
            'Consulting' => 'الاستشارات',
            'Cyber Security' => 'الأمن السيبراني',
            'Uncategorized' => 'غير مصنف',
        ];

        foreach ($categories as $category) {
            // Get English translation
            $englishTranslation = BlogCategoryTranslation::where('blog_category_id', $category->id)
                ->where('lang_code', 'en')
                ->first();

            if (!$englishTranslation) {
                $skipped++;
                $this->warn("Skipping blog category ID {$category->id} - no English translation found");
                continue;
            }

            // Check if Arabic translation already exists
            $arabicTranslation = BlogCategoryTranslation::where('blog_category_id', $category->id)
                ->where('lang_code', 'ar')
                ->first();

            if ($arabicTranslation) {
                // Update existing
                $arabicTranslation->name = $translations[$englishTranslation->name] ?? $englishTranslation->name;
                $arabicTranslation->save();
            } else {
                // Create new
                $arabicTranslation = new BlogCategoryTranslation();
                $arabicTranslation->blog_category_id = $category->id;
                $arabicTranslation->lang_code = 'ar';
                $arabicTranslation->name = $translations[$englishTranslation->name] ?? $englishTranslation->name;
                $arabicTranslation->save();
            }

            $translated++;
            $this->info("Translated: {$englishTranslation->name} -> {$arabicTranslation->name}");
        }

        $this->info("\nTranslation completed!");
        $this->info("Translated: {$translated} blog categories");
        $this->info("Skipped: {$skipped} blog categories");
        
        return 0;
    }
}

