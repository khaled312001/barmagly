<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Blog\App\Models\Blog;
use Modules\Blog\App\Models\BlogTranslation;

class TranslateBlogsToArabic extends Command
{
    protected $signature = 'translate:blogs-arabic';
    protected $description = 'Translate all blog posts to Arabic';

    public function handle()
    {
        $this->info('Starting blogs translation to Arabic...');

        $blogs = Blog::all();
        
        $translated = 0;
        $skipped = 0;

        $translations = [
            'Planning your online business goals with a specialist' => 'تخطيط أهداف عملك عبر الإنترنت مع أخصائي',
            'Market insights to manage people related costs' => 'رؤى السوق لإدارة التكاليف المتعلقة بالأشخاص',
            'Boost your startup business with our digital agency' => 'عزز عملك الناشئ مع وكالتنا الرقمية',
        ];

        foreach ($blogs as $blog) {
            // Get English translation
            $englishTranslation = BlogTranslation::where('blog_id', $blog->id)
                ->where('lang_code', 'en')
                ->first();

            if (!$englishTranslation) {
                $skipped++;
                $this->warn("Skipping blog ID {$blog->id} - no English translation found");
                continue;
            }

            // Check if Arabic translation already exists
            $arabicTranslation = BlogTranslation::where('blog_id', $blog->id)
                ->where('lang_code', 'ar')
                ->first();

            if ($arabicTranslation) {
                // Update existing
                $arabicTranslation->title = $translations[$englishTranslation->title] ?? $englishTranslation->title;
                $arabicTranslation->description = $englishTranslation->description; // Keep same for now
                $arabicTranslation->save();
            } else {
                // Create new
                $arabicTranslation = new BlogTranslation();
                $arabicTranslation->blog_id = $blog->id;
                $arabicTranslation->lang_code = 'ar';
                $arabicTranslation->title = $translations[$englishTranslation->title] ?? $englishTranslation->title;
                $arabicTranslation->description = $englishTranslation->description; // Keep same for now
                $arabicTranslation->seo_title = $englishTranslation->seo_title;
                $arabicTranslation->seo_description = $englishTranslation->seo_description;
                $arabicTranslation->save();
            }

            $translated++;
            $this->info("Translated: {$englishTranslation->title} -> {$arabicTranslation->title}");
        }

        $this->info("\nTranslation completed!");
        $this->info("Translated: {$translated} blogs");
        $this->info("Skipped: {$skipped} blogs");
        
        return 0;
    }
}

