<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Frontend;
use App\Models\Slider;
use App\Models\SliderTranslation;
use Illuminate\Support\Facades\DB;

class UpdateContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->updateFrontendContent();
        $this->updateSliders();
    }

    /**
     * Update frontend dynamic content
     */
    private function updateFrontendContent(): void
    {
        // Hero Section - Main Demo
        $this->updateContent('main_demo_hero.content', [
            'heading' => [
                'en' => 'Professional Web Development & UI/UX Design Services',
                'ar' => 'خدمات تطوير المواقع الاحترافية وتصميم UI/UX'
            ],
            'description' => [
                'en' => 'We specialize in programming, website design, and UI/UX services. Transform your ideas into stunning digital experiences.',
                'ar' => 'نحن متخصصون في البرمجة وتصميم المواقع وخدمات UI/UX. حول أفكارك إلى تجارب رقمية مذهلة.'
            ],
            'small_description' => [
                'en' => 'Custom web solutions tailored to your business needs',
                'ar' => 'حلول ويب مخصصة مصممة خصيصاً لاحتياجات عملك'
            ],
            'left_button_text' => [
                'en' => 'Our Services',
                'ar' => 'خدماتنا'
            ],
            'left_button_url' => '/services',
            'right_button_text' => [
                'en' => 'Get Free Consultation',
                'ar' => 'احصل على استشارة مجانية'
            ],
            'right_button_url' => '/contact-us',
        ]);

        // Key Features Section
        $this->updateContent('key_feature.content', [
            'title' => [
                'en' => 'Our Expertise',
                'ar' => 'خبراتنا'
            ],
            'heading_1' => [
                'en' => 'Web Development',
                'ar' => 'تطوير المواقع'
            ],
            'description_1' => [
                'en' => 'Custom web applications built with modern technologies and best practices.',
                'ar' => 'تطبيقات ويب مخصصة مبنية بأحدث التقنيات وأفضل الممارسات.'
            ],
            'service_url_1' => '/services',
            'heading_2' => [
                'en' => 'Website Design',
                'ar' => 'تصميم المواقع'
            ],
            'description_2' => [
                'en' => 'Beautiful, responsive designs that engage users and drive conversions.',
                'ar' => 'تصاميم جميلة ومتجاوبة تجذب المستخدمين وتزيد المبيعات.'
            ],
            'service_url_2' => '/services',
            'heading_3' => [
                'en' => 'UI/UX Design',
                'ar' => 'تصميم UI/UX'
            ],
            'description_3' => [
                'en' => 'User-centered design that creates intuitive and delightful experiences.',
                'ar' => 'تصميم يركز على المستخدم لخلق تجارب سهلة وممتعة.'
            ],
            'service_url_3' => '/services',
        ]);

        // About Us Section
        $this->updateContent('main_demo_about_us.content', [
            'heading' => [
                'en' => 'About Barmagly',
                'ar' => 'عن برمجلي'
            ],
            'sub_heading' => [
                'en' => 'Your Trusted Development Partner',
                'ar' => 'شريكك الموثوق في التطوير'
            ],
            'description' => [
                'en' => 'We are a team of skilled developers and designers specializing in web development, website design, and UI/UX services. With years of experience, we help businesses transform their digital presence through innovative solutions.',
                'ar' => 'نحن فريق من المطورين والمصممين المهرة المتخصصين في تطوير المواقع وتصميمها وخدمات UI/UX. بخبرة سنوات، نساعد الشركات على تحويل وجودها الرقمي من خلال حلول مبتكرة.'
            ],
            'button_text' => [
                'en' => 'Learn More',
                'ar' => 'اعرف المزيد'
            ],
            'button_link' => '/about-us',
            'left_text' => [
                'en' => 'Projects Completed',
                'ar' => 'مشروع مكتمل'
            ],
            'left_counter' => '100+',
            'right_text' => [
                'en' => 'Happy Clients',
                'ar' => 'عميل سعيد'
            ],
            'right_counter' => '50+',
        ]);

        // Service Section
        $this->updateContent('main_demo_service_section.content', [
            'heading' => [
                'en' => 'Our Services',
                'ar' => 'خدماتنا'
            ],
        ]);

        // Service Highlight Section
        $this->updateContent('main_demo_service_highlight.content', [
            'heading' => [
                'en' => 'Why Choose Us',
                'ar' => 'لماذا تختارنا'
            ],
            'description' => [
                'en' => 'We deliver exceptional results through our expertise in programming, design, and user experience.',
                'ar' => 'نقدم نتائج استثنائية من خلال خبرتنا في البرمجة والتصميم وتجربة المستخدم.'
            ],
            'about_1' => [
                'en' => 'Web Development',
                'ar' => 'تطوير المواقع'
            ],
            'percentage_1' => '95',
            'about_2' => [
                'en' => 'UI/UX Design',
                'ar' => 'تصميم UI/UX'
            ],
            'percentage_2' => '98',
            'about_3' => [
                'en' => 'Client Satisfaction',
                'ar' => 'رضا العملاء'
            ],
            'percentage_3' => '100',
        ]);

        // CTA Section
        $this->updateContent('main_demo_cta_section.content', [
            'heading' => [
                'en' => 'Let\'s work together',
                'ar' => 'دعنا نعمل معاً'
            ],
            'description' => [
                'en' => 'Each demo built with Teba will look different. You can customize anything appearance of your website with only a few clicks',
                'ar' => 'سيبدو كل عرض توضيحي مبني مع Teba مختلفاً. يمكنك تخصيص أي شيء تقريباً في مظهر موقعك بنقرة واحدة فقط'
            ],
            'button_text' => [
                'en' => 'Let\'s Start a Project',
                'ar' => 'دعنا نبدأ مشروعاً'
            ],
            'button_link' => 'contact-us',
        ]);

        // Services Section
        $this->updateContent('main_demo_services_section.content', [
            'heading' => [
                'en' => 'Our amazing services to achieve success',
                'ar' => 'خدماتنا الرائعة لتحقيق النجاح'
            ],
            'description' => [
                'en' => 'Increasing business success with technology',
                'ar' => 'زيادة نجاح الأعمال بالتكنولوجيا'
            ],
            'service_1_title' => [
                'en' => 'Cyber Security Solutions',
                'ar' => 'حلول الأمن السيبراني'
            ],
            'service_1_description' => [
                'en' => 'Protect your business with advanced cybersecurity solutions',
                'ar' => 'احمِ أعمالك بحلول الأمن السيبراني المتقدمة'
            ],
            'service_2_title' => [
                'en' => 'Digital Marketing Services',
                'ar' => 'خدمات التسويق الرقمي'
            ],
            'service_2_description' => [
                'en' => 'Grow your online presence with our digital marketing expertise',
                'ar' => 'نمِ وجودك عبر الإنترنت بخبرتنا في التسويق الرقمي'
            ],
            'service_3_title' => [
                'en' => 'UI/UX & Branding Identity',
                'ar' => 'UI/UX وهوية العلامة التجارية'
            ],
            'service_3_description' => [
                'en' => 'Create stunning designs that engage your audience',
                'ar' => 'أنشئ تصاميم مذهلة تجذب جمهورك'
            ],
            'service_4_title' => [
                'en' => 'Web & Mobile App Development',
                'ar' => 'تطوير الويب وتطبيقات الهاتف المحمول'
            ],
            'service_4_description' => [
                'en' => 'Build powerful web and mobile applications',
                'ar' => 'بنِ تطبيقات ويب وهاتف محمول قوية'
            ],
            'service_5_title' => [
                'en' => 'IT Management Service',
                'ar' => 'خدمة إدارة تقنية المعلومات'
            ],
            'service_5_description' => [
                'en' => 'Comprehensive IT management and support services',
                'ar' => 'خدمات إدارة ودعم تقنية المعلومات شاملة'
            ],
        ]);

        // Portfolio Section
        $this->updateContent('main_demo_portfolio_section.content', [
            'heading' => [
                'en' => 'Explore our recent projects',
                'ar' => 'استكشف مشاريعنا الأخيرة'
            ],
            'project_1_title' => [
                'en' => 'Digital Product Design',
                'ar' => 'تصميم المنتج الرقمي'
            ],
            'project_1_category' => [
                'en' => 'Programming',
                'ar' => 'البرمجة'
            ],
            'project_2_title' => [
                'en' => 'Software Development',
                'ar' => 'تطوير البرمجيات'
            ],
            'project_2_category' => [
                'en' => 'Business Style',
                'ar' => 'نمط الأعمال'
            ],
            'project_3_title' => [
                'en' => 'Multi-functional Technology',
                'ar' => 'التكنولوجيا متعددة الوظائف'
            ],
            'project_3_category' => [
                'en' => 'Business Style',
                'ar' => 'نمط الأعمال'
            ],
            'project_4_title' => [
                'en' => 'Content Management System Software Solution',
                'ar' => 'حل برمجيات نظام إدارة المحتوى'
            ],
            'project_4_category' => [
                'en' => 'Electronics',
                'ar' => 'الإلكترونيات'
            ],
        ]);

        // Team Section
        $this->updateContent('main_demo_team_section.content', [
            'heading' => [
                'en' => 'Our expert team is always ready to help you',
                'ar' => 'فريقنا الخبير دائماً جاهز لمساعدتك'
            ],
            'member_1_name' => [
                'en' => 'Alvantan Khan',
                'ar' => 'ألفانتان خان'
            ],
            'member_1_position' => [
                'en' => 'Lead Developer',
                'ar' => 'مطور رئيسي'
            ],
            'member_2_name' => [
                'en' => 'David Richard',
                'ar' => 'ديفيد ريتشارد'
            ],
            'member_2_position' => [
                'en' => 'Lead Developer',
                'ar' => 'مطور رئيسي'
            ],
            'member_3_name' => [
                'en' => 'Junaid Siddik',
                'ar' => 'جنيد صديق'
            ],
            'member_3_position' => [
                'en' => 'Real Estate Broker',
                'ar' => 'وسيط عقاري'
            ],
            'member_4_name' => [
                'en' => 'Marvin McKinney',
                'ar' => 'مارفن ماكيني'
            ],
            'member_4_position' => [
                'en' => 'CEO & Founder',
                'ar' => 'الرئيس التنفيذي والمؤسس'
            ],
        ]);

        // Blog Section
        $this->updateContent('main_demo_blog_section.content', [
            'heading' => [
                'en' => 'Latest blogs and articles about technology',
                'ar' => 'المدونات والمقالات الأخيرة حول التكنولوجيا'
            ],
            'post_1_title' => [
                'en' => 'Planning your online business goals with an expert',
                'ar' => 'تخطيط أهداف عملك عبر الإنترنت مع أخصائي'
            ],
            'post_1_excerpt' => [
                'en' => 'Learn how to effectively plan your online business goals...',
                'ar' => 'تعلم كيف تخطط أهداف أعمالك عبر الإنترنت بشكل فعال...'
            ],
            'post_2_title' => [
                'en' => 'Market insights for managing people-related costs',
                'ar' => 'رؤى السوق لإدارة التكاليف المتعلقة بالأشخاص'
            ],
            'post_2_excerpt' => [
                'en' => 'Understanding market trends for better cost management...',
                'ar' => 'فهم اتجاهات السوق لإدارة أفضل للتكاليف...'
            ],
            'post_3_title' => [
                'en' => 'Boost your startup with our digital agency',
                'ar' => 'عزز عملك الناشئ مع وكالتنا الرقمية'
            ],
            'post_3_excerpt' => [
                'en' => 'Discover how our digital agency can accelerate your startup growth...',
                'ar' => 'اكتشف كيف يمكن لوكالتنا الرقمية تسريع نمو شركتك الناشئة...'
            ],
        ]);

        // Footer Section
        $this->updateContent('main_demo_footer.content', [
            'company_name' => 'Jovero',
            'company_description' => [
                'en' => 'We provide professional IT services and digital solutions for your business.',
                'ar' => 'نحن نقدم خدمات تقنية المعلومات المهنية وحلول رقمية لأعمالك.'
            ],
            'address' => [
                'en' => '1791 Yorkshire Circle Kitty Hawk',
                'ar' => '1791 يوركشاير سيركل كيتي هوك'
            ],
            'phone' => '123-343-4444',
            'email' => 'no-reply@Jovero.com',
            'copyright' => [
                'en' => 'Copyright 2025, Jovero. All Rights Reserved.',
                'ar' => 'حقوق النشر 2025، Jovero. جميع الحقوق محفوظة.'
            ],
        ]);

        // Process Section
        $this->updateContent('main_demo_process_section.content', [
            'title' => [
                'en' => 'Our Process',
                'ar' => 'عملنا'
            ],
            'heading' => [
                'en' => 'How We Work',
                'ar' => 'كيف نعمل'
            ],
            'description' => [
                'en' => 'A proven process that delivers results',
                'ar' => 'عملية مثبتة تقدم نتائج'
            ],
            'heading_1' => [
                'en' => 'Discovery',
                'ar' => 'الاكتشاف'
            ],
            'description_1' => [
                'en' => 'We understand your needs and goals',
                'ar' => 'نفهم احتياجاتك وأهدافك'
            ],
            'heading_2' => [
                'en' => 'Design & Development',
                'ar' => 'التصميم والتطوير'
            ],
            'description_2' => [
                'en' => 'We create and build your solution',
                'ar' => 'نصمم ونبني حلولك'
            ],
            'heading_3' => [
                'en' => 'Launch & Support',
                'ar' => 'الإطلاق والدعم'
            ],
            'description_3' => [
                'en' => 'We launch and maintain your project',
                'ar' => 'نطلق ونحافظ على مشروعك'
            ],
        ]);
    }

    /**
     * Update content helper
     */
    private function updateContent(string $dataKey, array $data): void
    {
        $frontend = Frontend::where('data_keys', $dataKey)->first();

        if (!$frontend) {
            $frontend = new Frontend();
            $frontend->data_keys = $dataKey;
        }

        $dataValues = [];
        $translations = [];

        foreach ($data as $key => $value) {
            if (is_array($value) && isset($value['en']) && isset($value['ar'])) {
                // Bilingual content
                $dataValues[$key] = $value['en'];
                $translations[] = [
                    'language_code' => 'ar',
                    'data' => [$key => $value['ar']]
                ];
            } else {
                // Single value (like URLs)
                $dataValues[$key] = $value;
            }
        }

        // Preserve existing images if any
        if ($frontend->data_values && isset($frontend->data_values['images'])) {
            $dataValues['images'] = $frontend->data_values['images'];
        }

        $frontend->data_values = $dataValues;
        
        // Merge with existing translations
        $existingTranslations = json_decode($frontend->data_translations, true) ?? [];
        $mergedTranslations = $this->mergeTranslations($existingTranslations, $translations);
        $frontend->data_translations = json_encode($mergedTranslations);
        
        $frontend->save();
    }

    /**
     * Merge translations
     */
    private function mergeTranslations(array $existing, array $new): array
    {
        foreach ($new as $newTranslation) {
            $found = false;
            foreach ($existing as &$existingTranslation) {
                if ($existingTranslation['language_code'] === $newTranslation['language_code']) {
                    $existingTranslation['data'] = array_merge(
                        $existingTranslation['data'] ?? [],
                        $newTranslation['data']
                    );
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $existing[] = $newTranslation;
            }
        }
        return $existing;
    }

    /**
     * Update sliders
     */
    private function updateSliders(): void
    {
        // Get existing sliders or create new ones
        $sliders = Slider::all();

        if ($sliders->isEmpty()) {
            // Create sample sliders if none exist
            $slider1 = Slider::create([
                'image' => 'uploads/slider/slider1.jpg',
                'url' => '/services'
            ]);

            $this->createSliderTranslation($slider1->id, 'en', [
                'title' => 'We provide professional IT services',
                'small_text' => 'Delivering tech solutions for your startups',
                'button_text' => 'Work with us'
            ]);

            $this->createSliderTranslation($slider1->id, 'ar', [
                'title' => 'نوفر خدمات تكنولوجيا المعلومات المهنية',
                'small_text' => 'تقديم حلول تقنية للشركات الناشئة',
                'button_text' => 'اعمل معنا'
            ]);

            $slider2 = Slider::create([
                'image' => 'uploads/slider/slider2.jpg',
                'url' => '/portfolio'
            ]);

            $this->createSliderTranslation($slider2->id, 'en', [
                'title' => 'Exclusive technology to provide IT solutions',
                'small_text' => 'During this time, we\'ve built a reputation for excellent clients satisfaction',
                'button_text' => 'View Services'
            ]);

            $this->createSliderTranslation($slider2->id, 'ar', [
                'title' => 'تقنية حصرية لتقديم حلول تقنية المعلومات',
                'small_text' => 'خلال هذه الفترة، بنينا سمعة لرضا العملاء الممتاز',
                'button_text' => 'عرض الخدمات'
            ]);
        } else {
            // Update existing sliders
            foreach ($sliders as $index => $slider) {
                $translations = [
                    'en' => [
                        'title' => $index === 0
                            ? 'We provide professional IT services'
                            : 'Exclusive technology to provide IT solutions',
                        'small_text' => $index === 0
                            ? 'Delivering tech solutions for your startups'
                            : 'During this time, we\'ve built a reputation for excellent clients satisfaction',
                        'button_text' => $index === 0
                            ? 'Work with us'
                            : 'View Services'
                    ],
                    'ar' => [
                        'title' => $index === 0
                            ? 'نوفر خدمات تكنولوجيا المعلومات المهنية'
                            : 'تقنية حصرية لتقديم حلول تقنية المعلومات',
                        'small_text' => $index === 0
                            ? 'تقديم حلول تقنية للشركات الناشئة'
                            : 'خلال هذه الفترة، بنينا سمعة لرضا العملاء الممتاز',
                        'button_text' => $index === 0
                            ? 'اعمل معنا'
                            : 'عرض الخدمات'
                    ]
                ];

                foreach ($translations as $lang => $data) {
                    $translation = SliderTranslation::where('slider_id', $slider->id)
                        ->where('lang_code', $lang)
                        ->first();

                    if ($translation) {
                        $translation->update($data);
                    } else {
                        $this->createSliderTranslation($slider->id, $lang, $data);
                    }
                }
            }
        }
    }

    /**
     * Create slider translation
     */
    private function createSliderTranslation(int $sliderId, string $langCode, array $data): void
    {
        SliderTranslation::create([
            'slider_id' => $sliderId,
            'lang_code' => $langCode,
            'title' => $data['title'],
            'small_text' => $data['small_text'],
            'button_text' => $data['button_text'],
        ]);
    }
}

