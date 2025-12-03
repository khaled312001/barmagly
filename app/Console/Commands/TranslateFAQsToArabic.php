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
            'How do I create a freelance profile on the marketplace?' => 'كيف يمكنني إنشاء ملف تعريفي للعمل الحر في السوق؟',
            'What steps are involved in submitting a proposal for a job?' => 'ما هي الخطوات المتضمنة في تقديم عرض عمل؟',
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

            // Translation for answers based on question
            $answerTranslations = [
                'Can I make bank payment ?' => '<p>نعم، يمكنك الدفع عبر البنك بسهولة. نحن نقدم خيارات دفع متعددة وآمنة تشمل التحويلات البنكية المباشرة. تأكد من استخدام قنوات الدفع الرسمية فقط وتجنب أي طرق دفع غير معتمدة.</p>',
                'What precautions should I take to avoid scams?' => '<p>لتجنب عمليات الاحتيال، تأكد من التحقق من هوية العملاء، استخدم منصات موثوقة، اقرأ التقييمات والمراجعات، وتواصل فقط من خلال القنوات الرسمية. لا تشارك معلوماتك المصرفية الحساسة مع أي شخص.</p>',
                'What should I do if I encounter issues with a client or project?' => '<p>إذا واجهت مشاكل مع عميل أو مشروع، تواصل مع فريق الدعم لدينا فوراً. نحن هنا لمساعدتك في حل أي نزاعات أو مشاكل قد تنشأ. يمكنك أيضاً مراجعة سياسة حل النزاعات لدينا للحصول على مزيد من المعلومات.</p>',
                'Are there any fees associated with using the freelance marketplace?' => '<p>نعم، هناك رسوم بسيطة مرتبطة باستخدام منصة العمل الحر. تختلف الرسوم حسب نوع الخدمة والمستوى الذي تختاره. يمكنك الاطلاع على صفحة الأسعار للحصول على تفاصيل كاملة حول الرسوم والخطط المتاحة.</p>',
                'How do I create a freelance profile on the marketplace?' => '<p>لإنشاء ملف تعريفي للعمل الحر، سجل حساباً جديداً، أكمل معلوماتك الشخصية والمهنية، أضف معرض أعمالك، وحدد مهاراتك. تأكد من إضافة صورة احترافية ووصف واضح لخدماتك.</p>',
                'What steps are involved in submitting a proposal for a job?' => '<p>لتقديم عرض عمل، ابحث عن المشروع المناسب، اقرأ متطلبات المشروع بعناية، اكتب عرضاً مفصلاً يوضح كيف ستقوم بالمشروع، حدد السعر والوقت المطلوب، ثم أرسل العرض. تأكد من تخصيص كل عرض حسب متطلبات المشروع.</p>',
            ];
            
            // Get answer translation based on question
            $arabicAnswer = $answerTranslations[$englishTranslation->question] ?? $englishTranslation->answer;
            
            // If answer still contains Lorem ipsum or Vestibulum, replace with generic Arabic answer
            $englishAnswerText = strip_tags($englishTranslation->answer);
            if (strpos($englishAnswerText, 'Vestibulum') !== false || strpos($englishAnswerText, 'Maecenas') !== false) {
                if (!isset($answerTranslations[$englishTranslation->question])) {
                    $arabicAnswer = '<p>يمكنك الدفع عبر البنك بسهولة. نحن نقدم خيارات دفع متعددة وآمنة تشمل التحويلات البنكية المباشرة. تأكد من استخدام قنوات الدفع الرسمية فقط وتجنب أي طرق دفع غير معتمدة.</p>';
                }
            } elseif (strpos($englishAnswerText, 'Lorem ipsum') !== false || strpos($englishAnswerText, 'nibh saperet') !== false) {
                if (!isset($answerTranslations[$englishTranslation->question])) {
                    $arabicAnswer = '<p>لتجنب عمليات الاحتيال، تأكد من التحقق من هوية العملاء، استخدم منصات موثوقة، اقرأ التقييمات والمراجعات، وتواصل فقط من خلال القنوات الرسمية. لا تشارك معلوماتك المصرفية الحساسة مع أي شخص.</p>';
                }
            }
            
            if ($arabicTranslation) {
                // Update existing
                $arabicTranslation->question = $translations[$englishTranslation->question] ?? $englishTranslation->question;
                $arabicTranslation->answer = $arabicAnswer;
                $arabicTranslation->save();
            } else {
                // Create new
                $arabicTranslation = new FaqTranslation();
                $arabicTranslation->faq_id = $faq->id;
                $arabicTranslation->lang_code = 'ar';
                $arabicTranslation->question = $translations[$englishTranslation->question] ?? $englishTranslation->question;
                $arabicTranslation->answer = $arabicAnswer;
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

