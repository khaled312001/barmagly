<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Project\App\Models\Project;
use Modules\Project\App\Models\ProjectTranslation;

class TranslateProjectsToArabic extends Command
{
    protected $signature = 'translate:projects-arabic';
    protected $description = 'Translate all projects to Arabic';

    public function handle()
    {
        $this->info('Starting projects translation to Arabic...');

        $projects = Project::all();
        
        $translated = 0;
        $skipped = 0;

        $translations = [
            'Digital Product Design' => 'تصميم المنتج الرقمي',
            'Programming' => 'البرمجة',
            'Software Development' => 'تطوير البرمجيات',
            'Business Style' => 'نمط الأعمال',
            'Multifunction Technology' => 'التكنولوجيا متعددة الوظائف',
            'CMS Software Solution' => 'حل برمجيات نظام إدارة المحتوى',
            'Electronics' => 'الإلكترونيات',
            'Project for Marketing' => 'مشروع للتسويق',
            'Cyber Security Analysis' => 'تحليل الأمن السيبراني',
            'AI Services' => 'خدمات الذكاء الاصطناعي',
        ];

        foreach ($projects as $project) {
            // Get English translation
            $englishTranslation = ProjectTranslation::where('project_id', $project->id)
                ->where('lang_code', 'en')
                ->first();

            if (!$englishTranslation) {
                $skipped++;
                $this->warn("Skipping project ID {$project->id} - no English translation found");
                continue;
            }

            // Check if Arabic translation already exists
            $arabicTranslation = ProjectTranslation::where('project_id', $project->id)
                ->where('lang_code', 'ar')
                ->first();

            if ($arabicTranslation) {
                // Update existing
                $arabicTranslation->title = $translations[$englishTranslation->title] ?? $englishTranslation->title;
                $arabicTranslation->description = $englishTranslation->description; // Keep same for now
                $arabicTranslation->client_name = $englishTranslation->client_name;
                $arabicTranslation->save();
            } else {
                // Create new
                $arabicTranslation = new ProjectTranslation();
                $arabicTranslation->project_id = $project->id;
                $arabicTranslation->lang_code = 'ar';
                $arabicTranslation->title = $translations[$englishTranslation->title] ?? $englishTranslation->title;
                $arabicTranslation->description = $englishTranslation->description; // Keep same for now
                $arabicTranslation->client_name = $englishTranslation->client_name;
                $arabicTranslation->save();
            }

            $translated++;
            $this->info("Translated: {$englishTranslation->title} -> {$arabicTranslation->title}");
        }

        $this->info("\nTranslation completed!");
        $this->info("Translated: {$translated} projects");
        $this->info("Skipped: {$skipped} projects");
        
        return 0;
    }
}

