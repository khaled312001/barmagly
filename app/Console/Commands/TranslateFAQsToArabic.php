<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\FAQ\App\Models\Faq;
use Modules\FAQ\App\Models\FaqTranslation;

class TranslateFAQsToArabic extends Command
{
    protected $signature = 'translate:faqs-arabic';
    protected $description = 'Translate all FAQs to Arabic';

    public function handle()
    {
        $this->info('Starting FAQs translation to Arabic...');

        $faqs = Faq::all();
        
        $translated = 0;
        $skipped = 0;

        $translations = [
            'Can I make bank payment ?' => 'هل يمكنني الدفع عبر البنك؟',
            'What precautions should I take to avoid scams?' => 'ما هي الاحتياطات التي يجب أن أتخذها لتجنب عمليات الاحتيال؟',
            'What should I do if I encounter issues with a client or project?' => 'ماذا يجب أن أفعل إذا واجهت مشاكل مع عميل أو مشروع؟',
            'Are there any fees associated with using the freelance marketplace?' => 'هل هناك أي رسوم مرتبطة باستخدام سوق العمل الحر؟',
        ];

        foreach ($faqs as $faq) {
            // Get English translation
            $englishTranslation = FaqTranslation::where('faq_id', $faq->id)
                ->where('lang_code', 'en')
                ->first();

            if (!$englishTranslation) {
                $skipped++;
                $this->warn("Skipping FAQ ID {$faq->id} - no English translation found");
                continue;
            }

            // Check if Arabic translation already exists
            $arabicTranslation = FaqTranslation::where('faq_id', $faq->id)
                ->where('lang_code', 'ar')
                ->first();

            if ($arabicTranslation) {
                // Update existing
                $arabicTranslation->question = $translations[$englishTranslation->question] ?? $englishTranslation->question;
                // Keep answer same for now, can be translated later
                $arabicTranslation->save();
            } else {
                // Create new
                $arabicTranslation = new FaqTranslation();
                $arabicTranslation->faq_id = $faq->id;
                $arabicTranslation->lang_code = 'ar';
                $arabicTranslation->question = $translations[$englishTranslation->question] ?? $englishTranslation->question;
                $arabicTranslation->answer = $englishTranslation->answer; // Keep same for now
                $arabicTranslation->save();
            }

            $translated++;
            $this->info("Translated: {$englishTranslation->question} -> {$arabicTranslation->question}");
        }

        $this->info("\nTranslation completed!");
        $this->info("Translated: {$translated} FAQs");
        $this->info("Skipped: {$skipped} FAQs");
        
        return 0;
    }
}

