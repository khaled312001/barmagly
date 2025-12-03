<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Frontend;

class TranslateFrontendToArabic extends Command
{
    protected $signature = 'translate:frontend-arabic';
    protected $description = 'Translate all frontend content sections to Arabic';

    public function handle()
    {
        $this->info('Starting Arabic translation process...');

        // Get all frontend records
        $frontends = Frontend::all();
        
        $translated = 0;
        $skipped = 0;

        foreach ($frontends as $frontend) {
            $dataValues = $frontend->data_values ?? [];
            
            if (empty($dataValues) || isset($dataValues['images'])) {
                // Skip if only images or empty
                if (count($dataValues) <= 1) {
                    $skipped++;
                    continue;
                }
            }

            // Get existing translations
            $translations = json_decode($frontend->data_translations, true) ?? [];
            
            // Remove existing Arabic translation if exists
            $translations = array_filter($translations, function($trans) {
                return isset($trans['language_code']) && $trans['language_code'] !== 'ar';
            });
            
            // Translate all text fields to Arabic
            $arabicValues = $this->translateToArabic($dataValues);
            
            // Add Arabic translation
            $translations[] = [
                'language_code' => 'ar',
                'values' => $arabicValues
            ];
            
            // Update frontend
            $frontend->data_translations = json_encode(array_values($translations));
            $frontend->save();
            
            $translated++;
            $this->info("Translated: {$frontend->data_keys}");
        }

        $this->info("\nTranslation completed!");
        $this->info("Translated: {$translated} sections");
        $this->info("Skipped: {$skipped} sections");
        
        return 0;
    }

    private function translateToArabic($data, $level = 0)
    {
        $translated = [];
        
        // Translation dictionary
        $translations = [
            'We provide professional IT services' => 'نوفر خدمات تكنولوجيا المعلومات المهنية',
            'Best IT services for your agency' => 'أفضل خدمات تكنولوجيا المعلومات لوكالتك',
            'We transform businesses of most major sectors with powerful and adaptable digital solutions that satisfy the needs of today.' => 'نحول أعمال معظم القطاعات الرئيسية بحلول رقمية قوية وقابلة للتكيف تلبي احتياجات اليوم.',
            'Work With Us' => 'اعمل معنا',
            'View Services' => 'عرض الخدمات',
            'Our awesome services to give you success' => 'خدماتنا الرائعة لتحقيق النجاح',
            'Developing a comprehensive IT strategy that aligns.' => 'تطوير استراتيجية تكنولوجيا معلومات شاملة تتماشى مع أهدافك.',
            'We provide perfect IT solutions & technology' => 'نوفر حلول تكنولوجيا المعلومات والخدمات المثالية',
            'During this time, we\'ve built a reputation for excellent clients satisfaction as evidenced by our' => 'خلال هذا الوقت، بنينا سمعة للرضا الممتاز للعملاء كما يتضح من',
            'Each demo built with Teba will look different. You can customize almost anything in the appearance of your website with only a few clicks. Each demo built with Teba will look different.' => 'سيبدو كل عرض توضيحي مبني مع Teba مختلفاً. يمكنك تخصيص أي شيء تقريباً في مظهر موقعك بنقرة واحدة فقط. سيبدو كل عرض توضيحي مبني مع Teba مختلفاً.',
            'Provide Skills Services' => 'تقديم خدمات المهارات',
            'Urgent Support For Clients' => 'دعم عاجل للعملاء',
            'Explore flexible pricing for you' => 'استكشف أسعار مرنة لك',
            'Startup' => 'بدء التشغيل',
            'Business' => 'الأعمال',
            'Enterprise' => 'المؤسسة',
            'Best for Startup business owners who needs website for business.' => 'الأفضل لأصحاب الأعمال الناشئة الذين يحتاجون موقع ويب للأعمال.',
            'Our expert team is always ready to help you' => 'فريقنا الخبير دائماً جاهز لمساعدتك',
            'Have any questions? here some answers' => 'لديك أي أسئلة؟ إليك بعض الإجابات',
            'Ask Any Question' => 'اطرح أي سؤال',
            'Recent blog & articles about technology' => 'المدونات والمقالات الأخيرة حول التكنولوجيا',
            'Planning your online business goals with a specialist' => 'تخطيط أهداف عملك عبر الإنترنت مع أخصائي',
            'Market insights to manage people related costs' => 'رؤى السوق لإدارة التكاليف المتعلقة بالأشخاص',
            'Boost your startup business with our digital agency' => 'عزز أعمالك الناشئة مع وكالتنا الرقمية',
            'View All Posts' => 'عرض جميع المشاركات',
        ];

        foreach ($data as $key => $value) {
            // Skip images
            if ($key === 'images' || (is_array($value) && isset($value['hero_image']))) {
                $translated[$key] = $value;
                continue;
            }

            if (is_array($value)) {
                // Handle package_information specifically
                if ($key === 'package_information') {
                    $translated[$key] = $this->translatePackageInformation($value);
                } 
                // Handle nested arrays (like arrays of items)
                else if (isset($value[0]) && is_array($value[0])) {
                    // It's an array of items
                    $translated[$key] = array_map(function($item) {
                        return is_array($item) ? $this->translateToArabic($item) : $this->translateText($item);
                    }, $value);
                } 
                // Handle associative arrays with specific structure
                else if (isset($value['title']) || isset($value['heading']) || isset($value['name'])) {
                    // Recursive translation for nested arrays
                    $translated[$key] = $this->translateToArabic($value, $level + 1);
                }
                else {
                    // Recursive translation for nested arrays
                    $translated[$key] = $this->translateToArabic($value, $level + 1);
                }
            } else if (is_string($value) && !empty(trim($value))) {
                // Translate text values
                $translated[$key] = $this->translateText($value, $translations);
            } else {
                $translated[$key] = $value;
            }
        }

        return $translated;
    }

    private function translateArray($array)
    {
        $translated = [];
        
        foreach ($array as $index => $item) {
            if (is_array($item)) {
                $translated[$index] = $this->translateToArabic($item);
            } else {
                $translated[$index] = $this->translateText($item);
            }
        }
        
        return $translated;
    }

    private function translatePackageInformation($packages)
    {
        $translated = [];
        
        foreach ($packages as $key => $package) {
            if (is_array($package)) {
                $translated[$key] = [
                    'title' => $this->translateText($package['title'] ?? ''),
                    'price' => $package['price'] ?? '',
                    'description' => $this->translateText($package['description'] ?? ''),
                    'features' => isset($package['features']) && is_array($package['features']) 
                        ? array_map([$this, 'translateText'], $package['features'])
                        : ($package['features'] ?? [])
                ];
            } else {
                $translated[$key] = $package;
            }
        }
        
        return $translated;
    }

    private function translateText($text, $customTranslations = [])
    {
        // Check custom translations first
        if (isset($customTranslations[$text])) {
            return $customTranslations[$text];
        }

        // Comprehensive translation dictionary
        $translations = [
            'We provide professional IT services' => 'نوفر خدمات تكنولوجيا المعلومات المهنية',
            'Best IT services for your agency' => 'أفضل خدمات تكنولوجيا المعلومات لوكالتك',
            'We transform businesses of most major sectors with powerful and adaptable digital solutions that satisfy the needs of today.' => 'نحول أعمال معظم القطاعات الرئيسية بحلول رقمية قوية وقابلة للتكيف تلبي احتياجات اليوم.',
            'Work With Us' => 'اعمل معنا',
            'View Services' => 'عرض الخدمات',
            'Our awesome services to give you success' => 'خدماتنا الرائعة لتحقيق النجاح',
            'Developing a comprehensive IT strategy that aligns.' => 'تطوير استراتيجية تكنولوجيا معلومات شاملة تتماشى مع أهدافك.',
            'We provide perfect IT solutions & technology' => 'نوفر حلول تكنولوجيا المعلومات والخدمات المثالية',
            'During this time, we\'ve built a reputation for excellent clients satisfaction as evidenced by our' => 'خلال هذا الوقت، بنينا سمعة للرضا الممتاز للعملاء كما يتضح من',
            'Each demo built with Teba will look different. You can customize almost anything in the appearance of your website with only a few clicks. Each demo built with Teba will look different.' => 'سيبدو كل عرض توضيحي مبني مع Teba مختلفاً. يمكنك تخصيص أي شيء تقريباً في مظهر موقعك بنقرة واحدة فقط. سيبدو كل عرض توضيحي مبني مع Teba مختلفاً.',
            'Provide Skills Services' => 'تقديم خدمات المهارات',
            'Urgent Support For Clients' => 'دعم عاجل للعملاء',
            'Explore flexible pricing for you' => 'استكشف أسعار مرنة لك',
            'Startup' => 'بدء التشغيل',
            'Business' => 'الأعمال',
            'Enterprise' => 'المؤسسة',
            'Best for Startup business owners who needs website for business.' => 'الأفضل لأصحاب الأعمال الناشئة الذين يحتاجون موقع ويب للأعمال.',
            'Our expert team is always ready to help you' => 'فريقنا الخبير دائماً جاهز لمساعدتك',
            'Have any questions? here some answers' => 'لديك أي أسئلة؟ إليك بعض الإجابات',
            'Ask Any Question' => 'اطرح أي سؤال',
            'Recent blog & articles about technology' => 'المدونات والمقالات الأخيرة حول التكنولوجيا',
            'Planning your online business goals with a specialist' => 'تخطيط أهداف عملك عبر الإنترنت مع أخصائي',
            'Market insights to manage people related costs' => 'رؤى السوق لإدارة التكاليف المتعلقة بالأشخاص',
            'Boost your startup business with our digital agency' => 'عزز أعمالك الناشئة مع وكالتنا الرقمية',
            'View All Posts' => 'عرض جميع المشاركات',
            'Cyber Security Solutions' => 'حلول الأمن السيبراني',
            'Digital Marketing Services' => 'خدمات التسويق الرقمي',
            'UI/UX & Branding Identity' => 'واجهة المستخدم/تجربة المستخدم والهوية التجارية',
            'Web & Mobile App Development' => 'تطوير تطبيقات الويب والجوال',
            'IT Management Service' => 'خدمة إدارة تكنولوجيا المعلومات',
            'Data Tracking Security' => 'أمان تتبع البيانات',
            'Programming' => 'البرمجة',
            'Business Style' => 'نمط الأعمال',
            'Electronics' => 'الإلكترونيات',
            'AI Services' => 'خدمات الذكاء الاصطناعي',
            '10 GB disk space availability' => 'توفر مساحة قرص 10 جيجابايت',
            '50 GB NVMe SSD for use' => '50 جيجابايت NVMe SSD للاستخدام',
            'Free platform access for all' => 'وصول مجاني للمنصة للجميع',
            'Free lifetime updates facility' => 'منشأة تحديثات مجانية مدى الحياة',
            'Free one year support' => 'دعم مجاني لمدة عام واحد',
            '24/7 Support' => 'دعم 24/7',
            '100 GB disk space availability' => 'توفر مساحة قرص 100 جيجابايت',
            '1150 GB NVMe SSD for use' => '1150 جيجابايت NVMe SSD للاستخدام',
            'Digital Product Design' => 'تصميم المنتج الرقمي',
            'Software Development' => 'تطوير البرمجيات',
            'Multifunction Technology' => 'التكنولوجيا متعددة الوظائف',
            'CMS Software Solution' => 'حل برمجيات نظام إدارة المحتوى',
            'Project for Marketing' => 'مشروع للتسويق',
            'Cyber Security Analysis' => 'تحليل الأمن السيبراني',
            'Lead Developer' => 'مطور رئيسي',
            'Real Estate Broker' => 'وسيط عقاري',
            'CEO & Founder' => 'الرئيس التنفيذي والمؤسس',
            'Can I make bank payment ?' => 'هل يمكنني الدفع المصرفي؟',
            'What precautions should I take to avoid scams?' => 'ما الاحتياطات التي يجب اتخاذها لتجنب الاحتيال؟',
            'What should I do if I encounter issues with a client or project?' => 'ماذا يجب أن أفعل إذا واجهت مشاكل مع عميل أو مشروع؟',
            'Are there any fees associated with using the freelance marketplace?' => 'هل هناك أي رسوم مرتبطة باستخدام سوق العمل الحر؟',
            'Vestibulum quis neque nunc. Maecenas pharetra libero id efficitur gravida. Aenean risus enim, condimentum vela aliquams in, consequat nec lacus. Aenean faucibus venenatis aliquet. Sed nulla quam, vehicula ut libero molestie volu our as satpat quam. Phasellus semper vitae tellus sit amet scelerisque' => 'فيستيبولوم كويس نيكي نونك. ميسيناس فارترا ليبرو إد إفيسيتور جرايدا. إينيان ريسوس إينيم، كونديمنتوم فيلا أليكوامس إن، كونسيكوات نيك لاكوس. إينيان فاوكيبوس فينيناتيس أليكيت. سيد نولا كوام، فيهيكولا أوت ليبرو مولستي فولو أور أس ساتبات كوام. فاسيلوس سيمبر فيتا تيلوس سيت أميت سيليريسك.',
        ];
        
        // Additional translations for common phrases
        $additionalTranslations = [
            'Technology' => 'التكنولوجيا',
            '15 July 2024' => '15 يوليو 2024',
            'Q' => 'س',
            'Q1' => 'س1',
            'Q2' => 'س2',
            'Q3' => 'س3',
            'Q4' => 'س4',
        ];
        
        $translations = array_merge($translations, $additionalTranslations);

        // Check if text exists in translations
        if (isset($translations[$text])) {
            return $translations[$text];
        }

        // Common field names (keep as is)
        $fieldNames = ['heading', 'description', 'button_text', 'title', 'price', 'name'];
        if (in_array(strtolower($text), $fieldNames)) {
            return $text;
        }

        // Return original if no translation found
        return $text;
    }
}

