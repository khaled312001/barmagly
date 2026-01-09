<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Frontend;
use Modules\Page\App\Models\Footer;
use Modules\Page\App\Models\ContactUs;
use Modules\Page\App\Models\ContactUsTranslation;
use Modules\Listing\Entities\Listing;
use Modules\Listing\Entities\ListingTranslation;
use Modules\Blog\App\Models\Blog;
use Modules\Blog\App\Models\BlogTranslation;
use Modules\Blog\App\Models\BlogCategory;
use Modules\Blog\App\Models\BlogCategoryTranslation;
use Modules\Project\App\Models\Project;
use Modules\Project\App\Models\ProjectTranslation;
use App\Models\Team;
use App\Models\TeamTranslation;
use Modules\Testimonial\App\Models\Testimonial;
use Modules\Testimonial\App\Models\TestimonialTrasnlation;
use Modules\Category\Entities\Category;
use Modules\FAQ\App\Models\Faq;
use Modules\FAQ\App\Models\FaqTranslation;
use App\Models\Slider;
use App\Models\SliderTranslation;
use Illuminate\Support\Facades\DB;

class CompleteBarmaglyHomepageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting complete Barmagly homepage rewrite...');
        
        $this->updateContactInfo();
        $this->updateFooter();
        $this->updateHeroSection();
        $this->updateServicesSection();
        $this->updateAboutUsSection();
        $this->updatePricingSection();
        $this->updateServices();
        $this->updateProjects();
        $this->updateBlogs();
        $this->updateTeams();
        $this->updateTestimonials();
        $this->updateFAQs();
        $this->updateSliders();
        $this->updateBlogSection();
        $this->updateFAQSection();
        
        $this->command->info('✅ Complete Barmagly homepage rewrite finished!');
    }

    /**
     * Update Contact Information
     */
    private function updateContactInfo(): void
    {
        $this->command->info('📝 Updating Contact Information...');
        
        $contactUs = ContactUs::first();
        if (!$contactUs) {
            $contactUs = new ContactUs();
            $contactUs->email = 'info@barmagly.com';
            $contactUs->email2 = 'info@barmagly.com';
            $contactUs->phone = '+201010254819';
            $contactUs->phone2 = '+201010254819';
            $contactUs->map_code = '';
            $contactUs->save();
        } else {
            $contactUs->email = 'info@barmagly.com';
            $contactUs->email2 = 'info@barmagly.com';
            $contactUs->phone = '+201010254819';
            $contactUs->phone2 = '+201010254819';
            $contactUs->save();
        }

        // Update English translation
        $transEn = ContactUsTranslation::where('contact_us_id', $contactUs->id)
            ->where('lang_code', 'en')
            ->first();
        
        if (!$transEn) {
            $transEn = new ContactUsTranslation();
            $transEn->contact_us_id = $contactUs->id;
            $transEn->lang_code = 'en';
        }
        
        $transEn->title = 'Contact Us';
        $transEn->description = 'Get in touch with Barmagly for professional web development, design, and UI/UX services.';
        $transEn->address = 'Qena-Egypt';
        $transEn->contact_description = 'We are here to help you transform your digital presence with our expert programming, website design, and UI/UX services.';
        $transEn->save();

        // Update Arabic translation
        $transAr = ContactUsTranslation::where('contact_us_id', $contactUs->id)
            ->where('lang_code', 'ar')
            ->first();
        
        if (!$transAr) {
            $transAr = new ContactUsTranslation();
            $transAr->contact_us_id = $contactUs->id;
            $transAr->lang_code = 'ar';
        }
        
        $transAr->title = 'اتصل بنا';
        $transAr->description = 'تواصل مع برمجلي للحصول على خدمات تطوير المواقع والتصميم وUI/UX الاحترافية.';
        $transAr->address = 'قنا-مصر';
        $transAr->contact_description = 'نحن هنا لمساعدتك في تحويل وجودك الرقمي بخدماتنا المتخصصة في البرمجة وتصميم المواقع وUI/UX.';
        $transAr->save();

        $this->command->info('✅ Contact Information updated!');
    }

    /**
     * Update Footer
     */
    private function updateFooter(): void
    {
        $this->command->info('📝 Updating Footer...');
        
        $footer = Footer::first();
        if (!$footer) {
            $footer = new Footer();
        }
        
        $footer->address = 'Qena-Egypt';
        $footer->phone = '+201010254819';
        $footer->email = 'info@barmagly.com';
        $footer->copyright = 'Copyright 2026, Barmagly. All Rights Reserved.';
        $footer->facebook = 'https://www.facebook.com/BarmaglyOfficial';
        $footer->save();

        $this->command->info('✅ Footer updated!');
    }

    /**
     * Update Hero Section
     */
    private function updateHeroSection(): void
    {
        $this->command->info('📝 Updating Hero Section...');
        
        $this->updateContent('startup_home_hero_section.content', [
            'heading' => [
                'en' => 'Barmagly - Your Digital Solutions Partner',
                'ar' => 'برمجلي - شريكك في الحلول الرقمية'
            ],
            'description' => [
                'en' => 'We specialize in professional web development, website design, and UI/UX services. Transform your business with cutting-edge digital solutions.',
                'ar' => 'نحن متخصصون في تطوير المواقع الاحترافية وتصميمها وخدمات UI/UX. حول أعمالك بحلول رقمية متطورة.'
            ],
            'small_description' => [
                'en' => 'Expert programming, innovative design, and exceptional user experiences',
                'ar' => 'برمجة خبيرة، تصميم مبتكر، وتجارب مستخدم استثنائية'
            ],
            'left_button_text' => [
                'en' => 'Our Services',
                'ar' => 'خدماتنا'
            ],
            'left_button_url' => '/services',
            'right_button_text' => [
                'en' => 'Get Started',
                'ar' => 'ابدأ الآن'
            ],
            'right_button_url' => '/contact-us',
        ]);

        $this->command->info('✅ Hero Section updated!');
    }

    /**
     * Update Services Section
     */
    private function updateServicesSection(): void
    {
        $this->command->info('📝 Updating Services Section...');
        
        $this->updateContent('main_demo_service_section.content', [
            'heading' => [
                'en' => 'Our Professional Services',
                'ar' => 'خدماتنا الاحترافية'
            ],
        ]);

        $this->command->info('✅ Services Section updated!');
    }

    /**
     * Update About Us Section
     */
    private function updateAboutUsSection(): void
    {
        $this->command->info('📝 Updating About Us Section...');
        
        $this->updateContent('startup_home_about_us.content', [
            'heading' => [
                'en' => 'About Barmagly',
                'ar' => 'عن برمجلي'
            ],
            'sub_heading' => [
                'en' => 'Your Trusted Technology Partner',
                'ar' => 'شريكك الموثوق في التكنولوجيا'
            ],
            'description' => [
                'en' => 'Barmagly is a leading digital solutions company specializing in web development, website design, and UI/UX services. With a team of skilled developers and designers, we help businesses transform their digital presence and achieve their goals through innovative technology solutions.',
                'ar' => 'برمجلي هي شركة رائدة في الحلول الرقمية متخصصة في تطوير المواقع وتصميمها وخدمات UI/UX. مع فريق من المطورين والمصممين المهرة، نساعد الشركات على تحويل وجودها الرقمي وتحقيق أهدافها من خلال حلول تكنولوجية مبتكرة.'
            ],
            'left_text' => [
                'en' => 'Completed Projects',
                'ar' => 'مشروع مكتمل'
            ],
            'right_text' => [
                'en' => 'Satisfied Clients',
                'ar' => 'عميل راضٍ'
            ],
        ]);

        $this->command->info('✅ About Us Section updated!');
    }

    /**
     * Update Pricing Section with complete package information
     */
    private function updatePricingSection(): void
    {
        $this->command->info('📝 Updating Pricing Section...');
        
        $frontend = Frontend::where('data_keys', 'it_solutions_pricing_section.content')->first();

        if (!$frontend) {
            $frontend = new Frontend();
            $frontend->data_keys = 'it_solutions_pricing_section.content';
        }

        // English package information - Website Development Plans
        $packageInformationEn = [
            'package_1' => [
                'title' => 'Custom Programming',
                'description' => 'Fully customized website development using modern technologies like Laravel, Vue.js, React, and more. Perfect for businesses that need unique solutions tailored to their specific requirements.',
                'price' => '999',
                'features' => [
                    'feature_1' => 'Custom Web Development (Laravel/Vue.js/React)',
                    'feature_2' => 'Fully Responsive Design',
                    'feature_3' => 'Custom Features & Functionality',
                    'feature_4' => 'Database Design & Integration',
                    'feature_5' => 'API Development & Integration',
                    'feature_6' => '6 Months Technical Support',
                ],
            ],
            'package_2' => [
                'title' => 'WordPress Development',
                'description' => 'Professional WordPress website development with custom themes and plugins. Ideal for businesses that want a powerful CMS with flexibility and ease of use.',
                'price' => '499',
                'features' => [
                    'feature_1' => 'Custom WordPress Theme Development',
                    'feature_2' => 'Custom Plugin Development',
                    'feature_3' => 'WooCommerce E-commerce Setup',
                    'feature_4' => 'SEO Optimization & Setup',
                    'feature_5' => 'Performance Optimization',
                    'feature_6' => '3 Months Support & Updates',
                ],
            ],
            'package_3' => [
                'title' => 'Odoo Development',
                'description' => 'Complete Odoo ERP system development and customization. Perfect for businesses that need integrated business management solutions.',
                'price' => '1499',
                'features' => [
                    'feature_1' => 'Odoo System Installation & Setup',
                    'feature_2' => 'Custom Module Development',
                    'feature_3' => 'ERP Integration & Configuration',
                    'feature_4' => 'Custom Reports & Dashboards',
                    'feature_5' => 'User Training & Documentation',
                    'feature_6' => '12 Months Support & Maintenance',
                ],
            ],
        ];

        // Arabic package information - Website Development Plans
        $packageInformationAr = [
            'package_1' => [
                'title' => 'البرمجة المخصصة',
                'description' => 'تطوير مواقع مخصص بالكامل باستخدام تقنيات حديثة مثل Laravel و Vue.js و React والمزيد. مثالي للشركات التي تحتاج حلول فريدة مصممة خصيصاً لمتطلباتها.',
                'price' => '999',
                'features' => [
                    'feature_1' => 'تطوير مواقع مخصص (Laravel/Vue.js/React)',
                    'feature_2' => 'تصميم متجاوب بالكامل',
                    'feature_3' => 'ميزات ووظائف مخصصة',
                    'feature_4' => 'تصميم وتكامل قاعدة البيانات',
                    'feature_5' => 'تطوير وتكامل API',
                    'feature_6' => 'دعم فني لمدة 6 أشهر',
                ],
            ],
            'package_2' => [
                'title' => 'تطوير ووردبريس',
                'description' => 'تطوير مواقع ووردبريس احترافية مع قوالب وإضافات مخصصة. مثالي للشركات التي تريد نظام إدارة محتوى قوي مع المرونة وسهولة الاستخدام.',
                'price' => '499',
                'features' => [
                    'feature_1' => 'تطوير قالب ووردبريس مخصص',
                    'feature_2' => 'تطوير إضافة مخصصة',
                    'feature_3' => 'إعداد متجر WooCommerce',
                    'feature_4' => 'تحسين وإعداد SEO',
                    'feature_5' => 'تحسين الأداء',
                    'feature_6' => 'دعم وتحديثات لمدة 3 أشهر',
                ],
            ],
            'package_3' => [
                'title' => 'تطوير أودو',
                'description' => 'تطوير وتخصيص نظام Odoo ERP كامل. مثالي للشركات التي تحتاج حلول إدارة أعمال متكاملة.',
                'price' => '1499',
                'features' => [
                    'feature_1' => 'تثبيت وإعداد نظام Odoo',
                    'feature_2' => 'تطوير وحدة مخصصة',
                    'feature_3' => 'تكامل وتكوين ERP',
                    'feature_4' => 'تقارير ولوحات تحكم مخصصة',
                    'feature_5' => 'تدريب المستخدمين والتوثيق',
                    'feature_6' => 'دعم وصيانة لمدة 12 شهراً',
                ],
            ],
        ];

        $dataValues = [
            'heading' => 'Explore Our Website Development Plans',
            'package_information' => $packageInformationEn,
        ];

        $translations = [
            [
                'language_code' => 'ar',
                'values' => [
                    'heading' => 'استكشف خطط تطوير المواقع لدينا',
                    'package_information' => $packageInformationAr,
                ],
            ],
        ];

        $frontend->data_values = $dataValues;
        $frontend->data_translations = json_encode($translations);
        $frontend->save();

        $this->command->info('✅ Pricing Section updated!');
    }

    /**
     * Update Services
     */
    private function updateServices(): void
    {
        $this->command->info('📝 Updating All Services...');
        
        $category = Category::where('status', 'enable')->first();
        if (!$category) {
            $category = new Category();
            $category->status = 'enable';
            $category->save();
        }

        $services = [
            [
                'title_en' => 'Web Development',
                'title_ar' => 'تطوير المواقع',
                'description_en' => 'Professional web development services using the latest technologies including Laravel, Vue.js, React, Node.js, and more. We build scalable, secure, and high-performance web applications tailored to your business needs. Our team specializes in creating custom solutions that drive growth and enhance your digital presence.',
                'description_ar' => 'خدمات تطوير المواقع الاحترافية باستخدام أحدث التقنيات بما في ذلك Laravel و Vue.js و React و Node.js والمزيد. نبني تطبيقات ويب قابلة للتوسع وآمنة وعالية الأداء مصممة خصيصاً لاحتياجات عملك. فريقنا متخصص في إنشاء حلول مخصصة تدفع النمو وتعزز وجودك الرقمي.',
                'short_description_en' => 'Professional web development with modern technologies',
                'short_description_ar' => 'تطوير مواقع احترافي بأحدث التقنيات',
            ],
            [
                'title_en' => 'Website Design',
                'title_ar' => 'تصميم المواقع',
                'description_en' => 'Creative and responsive website designs that engage your audience and drive conversions. We focus on user experience, visual appeal, and modern design trends to create stunning websites. Our designs are mobile-first, SEO-friendly, and optimized for performance to ensure your website stands out in the digital landscape.',
                'description_ar' => 'تصاميم مواقع إبداعية ومتجاوبة تجذب جمهورك وتزيد المبيعات. نركز على تجربة المستخدم والجاذبية البصرية واتجاهات التصميم الحديثة لإنشاء مواقع مذهلة. تصاميمنا تركز على الهاتف المحمول أولاً، صديقة لمحركات البحث ومحسنة للأداء لضمان تميز موقعك في المشهد الرقمي.',
                'short_description_en' => 'Beautiful, responsive website designs',
                'short_description_ar' => 'تصاميم مواقع جميلة ومتجاوبة',
            ],
            [
                'title_en' => 'UI/UX Design',
                'title_ar' => 'تصميم UI/UX',
                'description_en' => 'User-centered design approach that creates intuitive and delightful user experiences. We design interfaces that users love to interact with, improving engagement and satisfaction. Our UI/UX services include user research, wireframing, prototyping, and usability testing to ensure your product meets user needs and exceeds expectations.',
                'description_ar' => 'نهج تصميم يركز على المستخدم لخلق تجارب مستخدم سهلة وممتعة. نصمم واجهات يحب المستخدمون التفاعل معها، مما يحسن المشاركة والرضا. تشمل خدمات UI/UX لدينا البحث عن المستخدم وإنشاء الإطارات السلكية والنماذج الأولية واختبار سهولة الاستخدام لضمان تلبية منتجك لاحتياجات المستخدم وتجاوز التوقعات.',
                'short_description_en' => 'User-centered design for better experiences',
                'short_description_ar' => 'تصميم يركز على المستخدم لتجارب أفضل',
            ],
            [
                'title_en' => 'Mobile App Development',
                'title_ar' => 'تطوير تطبيقات الهاتف',
                'description_en' => 'Native and cross-platform mobile app development for iOS and Android. We create apps that provide seamless user experiences and deliver exceptional performance. Whether you need a native iOS app, Android app, or a cross-platform solution using React Native or Flutter, we have the expertise to bring your mobile vision to life.',
                'description_ar' => 'تطوير تطبيقات الهاتف الأصلية والمتعددة المنصات لـ iOS و Android. ننشئ تطبيقات توفر تجارب مستخدم سلسة وتقدم أداءً استثنائياً. سواء كنت بحاجة إلى تطبيق iOS أصلي أو تطبيق Android أو حل متعدد المنصات باستخدام React Native أو Flutter، لدينا الخبرة لإحياء رؤيتك للهاتف المحمول.',
                'short_description_en' => 'iOS and Android app development',
                'short_description_ar' => 'تطوير تطبيقات iOS و Android',
            ],
            [
                'title_en' => 'E-commerce Development',
                'title_ar' => 'تطوير المتاجر الإلكترونية',
                'description_en' => 'Complete e-commerce solutions from design to implementation. We build secure, scalable online stores that drive sales and provide excellent shopping experiences. Our e-commerce platforms include payment gateway integration, inventory management, order tracking, and analytics to help you manage and grow your online business effectively.',
                'description_ar' => 'حلول متاجر إلكترونية كاملة من التصميم إلى التنفيذ. نبني متاجر إلكترونية آمنة وقابلة للتوسع تزيد المبيعات وتوفر تجارب تسوق ممتازة. تشمل منصات المتاجر الإلكترونية لدينا تكامل بوابات الدفع وإدارة المخزون وتتبع الطلبات والتحليلات لمساعدتك على إدارة ونمو أعمالك عبر الإنترنت بشكل فعال.',
                'short_description_en' => 'Complete e-commerce solutions',
                'short_description_ar' => 'حلول متاجر إلكترونية كاملة',
            ],
            [
                'title_en' => 'Website Maintenance & Support',
                'title_ar' => 'صيانة المواقع والدعم',
                'description_en' => 'Ongoing website maintenance and support services to keep your website running smoothly. We provide regular updates, security patches, performance optimization, and technical support to ensure your website remains secure, fast, and up-to-date with the latest technologies.',
                'description_ar' => 'خدمات صيانة المواقع والدعم المستمرة للحفاظ على تشغيل موقعك بسلاسة. نقدم تحديثات منتظمة وترقيعات الأمان وتحسين الأداء والدعم التقني لضمان بقاء موقعك آمناً وسريعاً ومحدثاً بأحدث التقنيات.',
                'short_description_en' => 'Ongoing maintenance and support',
                'short_description_ar' => 'صيانة ودعم مستمر',
            ],
        ];

        // Get all existing listings or create new ones
        $existingListings = Listing::all();
        
        foreach ($services as $index => $service) {
            $listing = $existingListings->get($index);
            
            if (!$listing) {
                $listing = new Listing();
                $listing->category_id = $category->id;
                $listing->sub_category_id = 0;
                $listing->thumb_image = 'default/service.jpg';
                $listing->slug = \Illuminate\Support\Str::slug($service['title_en']);
                
                // Set price fields only if they exist
                if (DB::getSchemaBuilder()->hasColumn('listings', 'regular_price')) {
                    $listing->regular_price = 0;
                }
                if (DB::getSchemaBuilder()->hasColumn('listings', 'offer_price')) {
                    $listing->offer_price = null;
                }
                
                $listing->status = 'enable';
                $listing->save();
            } else {
                // Update slug if needed
                if (empty($listing->slug) || $listing->slug !== \Illuminate\Support\Str::slug($service['title_en'])) {
                    $listing->slug = \Illuminate\Support\Str::slug($service['title_en']);
                    $listing->save();
                }
            }

            // Update English translation
            $transEn = ListingTranslation::where('listing_id', $listing->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$transEn) {
                $transEn = new ListingTranslation();
                $transEn->listing_id = $listing->id;
                $transEn->lang_code = 'en';
            }
            
            $transEn->title = $service['title_en'];
            $transEn->description = $service['description_en'];
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'address')) {
                $transEn->address = $service['short_description_en'] ?? $service['description_en'];
            }
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'seo_title')) {
                $transEn->seo_title = $service['title_en'] . ' - Barmagly';
            }
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'seo_description')) {
                $transEn->seo_description = $service['short_description_en'] ?? substr($service['description_en'], 0, 160);
            }
            $transEn->save();

            // Update Arabic translation
            $transAr = ListingTranslation::where('listing_id', $listing->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$transAr) {
                $transAr = new ListingTranslation();
                $transAr->listing_id = $listing->id;
                $transAr->lang_code = 'ar';
            }
            
            $transAr->title = $service['title_ar'];
            $transAr->description = $service['description_ar'];
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'address')) {
                $transAr->address = $service['short_description_ar'] ?? $service['description_ar'];
            }
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'seo_title')) {
                $transAr->seo_title = $service['title_ar'] . ' - برمجلي';
            }
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'seo_description')) {
                $transAr->seo_description = $service['short_description_ar'] ?? mb_substr($service['description_ar'], 0, 160);
            }
            $transAr->save();
        }

        $this->command->info('✅ All Services updated!');
    }

    /**
     * Update Projects
     */
    private function updateProjects(): void
    {
        $this->command->info('📝 Updating Projects...');
        
        $projects = [
            [
                'title_en' => 'E-commerce Platform Development',
                'title_ar' => 'تطوير منصة متجر إلكتروني',
                'description_en' => 'Complete e-commerce platform with modern design, advanced features, and seamless user experience. Built with Laravel and Vue.js for optimal performance.',
                'description_ar' => 'منصة متجر إلكتروني كاملة بتصميم حديث وميزات متقدمة وتجربة مستخدم سلسة. مبني بـ Laravel و Vue.js لأداء مثالي.',
                'client_name_en' => 'Tech Solutions Inc.',
                'client_name_ar' => 'شركة حلول تقنية',
            ],
            [
                'title_en' => 'Corporate Website Redesign',
                'title_ar' => 'إعادة تصميم موقع شركة',
                'description_en' => 'Complete redesign of corporate website with focus on user experience and modern UI/UX principles. Responsive design for all devices.',
                'description_ar' => 'إعادة تصميم كاملة لموقع شركة مع التركيز على تجربة المستخدم ومبادئ UI/UX الحديثة. تصميم متجاوب لجميع الأجهزة.',
                'client_name_en' => 'Business Corp',
                'client_name_ar' => 'شركة الأعمال',
            ],
            [
                'title_en' => 'Mobile App UI/UX Design',
                'title_ar' => 'تصميم UI/UX لتطبيق الهاتف',
                'description_en' => 'User interface design for mobile application with focus on usability and visual appeal. Created intuitive navigation and engaging user experience.',
                'description_ar' => 'تصميم واجهة مستخدم لتطبيق الهاتف مع التركيز على سهولة الاستخدام والجاذبية البصرية. تم إنشاء تنقل بديهي وتجربة مستخدم جذابة.',
                'client_name_en' => 'Mobile Solutions',
                'client_name_ar' => 'حلول الهاتف',
            ],
            [
                'title_en' => 'Content Management System',
                'title_ar' => 'نظام إدارة المحتوى',
                'description_en' => 'Custom CMS solution for content management with intuitive admin panel and flexible content structure.',
                'description_ar' => 'حل CMS مخصص لإدارة المحتوى مع لوحة تحكم سهلة وبنية محتوى مرنة.',
                'client_name_en' => 'Content Solutions',
                'client_name_ar' => 'حلول المحتوى',
            ],
            [
                'title_en' => 'Digital Marketing Platform',
                'title_ar' => 'منصة التسويق الرقمي',
                'description_en' => 'Digital marketing platform development with analytics, campaign management, and reporting features.',
                'description_ar' => 'تطوير منصة تسويق رقمي مع تحليلات وإدارة الحملات وميزات التقارير.',
                'client_name_en' => 'Marketing Agency',
                'client_name_ar' => 'وكالة تسويق',
            ],
            [
                'title_en' => 'Cybersecurity Solutions',
                'title_ar' => 'حلول الأمن السيبراني',
                'description_en' => 'Comprehensive cybersecurity analysis and solutions implementation for enterprise-level security.',
                'description_ar' => 'تحليل وحلول أمن سيبراني شاملة لتنفيذ الأمان على مستوى المؤسسة.',
                'client_name_en' => 'Security Solutions',
                'client_name_ar' => 'حلول الأمان',
            ],
        ];

        foreach ($projects as $index => $project) {
            $projectModel = Project::skip($index)->first();
            
            if (!$projectModel) {
                $projectModel = new Project();
                $projectModel->status = 'enable';
                $projectModel->save();
            }

            // Update English
            $transEn = ProjectTranslation::where('project_id', $projectModel->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$transEn) {
                $transEn = new ProjectTranslation();
                $transEn->project_id = $projectModel->id;
                $transEn->lang_code = 'en';
            }
            
            $transEn->title = $project['title_en'];
            $transEn->description = $project['description_en'];
            $transEn->client_name = $project['client_name_en'];
            $transEn->save();

            // Update Arabic
            $transAr = ProjectTranslation::where('project_id', $projectModel->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$transAr) {
                $transAr = new ProjectTranslation();
                $transAr->project_id = $projectModel->id;
                $transAr->lang_code = 'ar';
            }
            
            $transAr->title = $project['title_ar'];
            $transAr->description = $project['description_ar'];
            $transAr->client_name = $project['client_name_ar'];
            $transAr->save();
        }

        $this->command->info('✅ Projects updated!');
    }

    /**
     * Update Blogs
     */
    private function updateBlogs(): void
    {
        $this->command->info('📝 Updating Blogs...');
        
        $blogCategory = BlogCategory::where('status', 1)->first();
        if (!$blogCategory) {
            $blogCategory = new BlogCategory();
            $blogCategory->status = 1;
            $blogCategory->save();
            
            $catTransEn = new BlogCategoryTranslation();
            $catTransEn->blog_category_id = $blogCategory->id;
            $catTransEn->lang_code = 'en';
            $catTransEn->name = 'Technology';
            $catTransEn->save();
            
            $catTransAr = new BlogCategoryTranslation();
            $catTransAr->blog_category_id = $blogCategory->id;
            $catTransAr->lang_code = 'ar';
            $catTransAr->name = 'التكنولوجيا';
            $catTransAr->save();
        }

        $blogs = [
            [
                'title_en' => 'Best Practices for Modern Web Development in 2026',
                'title_ar' => 'أفضل الممارسات لتطوير المواقع الحديثة في 2026',
                'description_en' => 'Discover the latest trends and best practices in web development. Learn about modern frameworks like Laravel and Vue.js, performance optimization techniques, security measures, and how to build scalable web applications that meet today\'s business needs.',
                'description_ar' => 'اكتشف أحدث الاتجاهات وأفضل الممارسات في تطوير المواقع. تعرف على الأطر الحديثة مثل Laravel و Vue.js وتقنيات تحسين الأداء وإجراءات الأمان وكيفية بناء تطبيقات ويب قابلة للتوسع تلبي احتياجات الأعمال اليوم.',
            ],
            [
                'title_en' => 'UI/UX Design Principles for Better User Experience',
                'title_ar' => 'مبادئ تصميم UI/UX لتجربة مستخدم أفضل',
                'description_en' => 'Learn the fundamental principles of UI/UX design that help create intuitive and engaging user interfaces. Understand user psychology, design patterns, wireframing techniques, and how to conduct usability testing to ensure your designs meet user expectations and drive conversions.',
                'description_ar' => 'تعلم المبادئ الأساسية لتصميم UI/UX التي تساعد في إنشاء واجهات مستخدم سهلة وجذابة. افهم نفسية المستخدم وأنماط التصميم وتقنيات إنشاء الإطارات السلكية وكيفية إجراء اختبارات سهولة الاستخدام لضمان تلبية تصاميمك لتوقعات المستخدم وزيادة التحويلات.',
            ],
            [
                'title_en' => 'How to Choose the Right Technology Stack for Your Web Project',
                'title_ar' => 'كيف تختار التقنيات المناسبة لمشروعك على الويب',
                'description_en' => 'A comprehensive guide to choosing the right technology stack for your web development project. Compare different frameworks and tools, understand when to use Laravel vs React, and learn how to make informed decisions that align with your project requirements and long-term goals.',
                'description_ar' => 'دليل شامل لاختيار التقنيات المناسبة لمشروع تطوير المواقع. قارن بين الأطر والأدوات المختلفة، افهم متى تستخدم Laravel مقابل React، وتعلم كيفية اتخاذ قرارات مستنيرة تتماشى مع متطلبات مشروعك والأهداف طويلة المدى.',
            ],
            [
                'title_en' => 'Mobile App Development: Native vs Cross-Platform Solutions',
                'title_ar' => 'تطوير تطبيقات الهاتف: الحلول الأصلية مقابل متعددة المنصات',
                'description_en' => 'Explore the differences between native and cross-platform mobile app development. Learn about React Native, Flutter, and when to choose each approach. Understand the pros and cons to make the best decision for your mobile app project.',
                'description_ar' => 'استكشف الفروقات بين تطوير تطبيقات الهاتف الأصلية ومتعددة المنصات. تعرف على React Native و Flutter ومتى تختار كل نهج. افهم الإيجابيات والسلبيات لاتخاذ أفضل قرار لمشروع تطبيق الهاتف الخاص بك.',
            ],
            [
                'title_en' => 'E-commerce Development: Building Successful Online Stores',
                'title_ar' => 'تطوير المتاجر الإلكترونية: بناء متاجر إلكترونية ناجحة',
                'description_en' => 'Learn how to build secure and scalable e-commerce platforms. Discover best practices for payment integration, inventory management, order processing, and creating shopping experiences that convert visitors into customers.',
                'description_ar' => 'تعلم كيفية بناء منصات متاجر إلكترونية آمنة وقابلة للتوسع. اكتشف أفضل الممارسات لتكامل الدفع وإدارة المخزون ومعالجة الطلبات وإنشاء تجارب تسوق تحول الزوار إلى عملاء.',
            ],
            [
                'title_en' => 'Website Performance Optimization: Speed Up Your Site',
                'title_ar' => 'تحسين أداء المواقع: سرّع موقعك',
                'description_en' => 'Essential techniques for optimizing website performance and loading speed. Learn about image optimization, code minification, caching strategies, and how to improve Core Web Vitals to enhance user experience and SEO rankings.',
                'description_ar' => 'تقنيات أساسية لتحسين أداء المواقع وسرعة التحميل. تعرف على تحسين الصور وتقليل حجم الكود واستراتيجيات التخزين المؤقت وكيفية تحسين Core Web Vitals لتعزيز تجربة المستخدم وترتيب SEO.',
            ],
        ];

        foreach ($blogs as $index => $blog) {
            $blogModel = Blog::skip($index)->first();
            
            if (!$blogModel) {
                $blogModel = new Blog();
                $blogModel->slug = \Illuminate\Support\Str::slug($blog['title_en']);
                $blogModel->image = 'default/blog.jpg';
                $blogModel->blog_category_id = $blogCategory->id;
                $blogModel->status = 1;
                $blogModel->save();
            }

            // Update English
            $transEn = BlogTranslation::where('blog_id', $blogModel->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$transEn) {
                $transEn = new BlogTranslation();
                $transEn->blog_id = $blogModel->id;
                $transEn->lang_code = 'en';
            }
            
            $transEn->title = $blog['title_en'];
            $transEn->description = $blog['description_en'];
            $transEn->save();

            // Update Arabic
            $transAr = BlogTranslation::where('blog_id', $blogModel->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$transAr) {
                $transAr = new BlogTranslation();
                $transAr->blog_id = $blogModel->id;
                $transAr->lang_code = 'ar';
            }
            
            $transAr->title = $blog['title_ar'];
            $transAr->description = $blog['description_ar'];
            $transAr->save();
        }

        $this->command->info('✅ Blogs updated!');
    }

    /**
     * Update Teams
     */
    private function updateTeams(): void
    {
        $this->command->info('📝 Updating Teams...');
        
        $teams = [
            [
                'name_en' => 'Alvantan Khan',
                'name_ar' => 'ألفانتان خان',
                'designation_en' => 'Lead Developer',
                'designation_ar' => 'مطور رئيسي',
                'description_en' => 'Expert in web development with extensive experience in modern technologies. Specialized in Laravel, Vue.js, and full-stack development.',
                'description_ar' => 'خبير في تطوير المواقع مع خبرة واسعة في التقنيات الحديثة. متخصص في Laravel و Vue.js والتطوير Full-Stack.',
            ],
            [
                'name_en' => 'David Richard',
                'name_ar' => 'ديفيد ريتشارد',
                'designation_en' => 'Lead Developer',
                'designation_ar' => 'مطور رئيسي',
                'description_en' => 'Specialized in backend development and system architecture. Expert in building scalable and secure applications.',
                'description_ar' => 'متخصص في تطوير الواجهة الخلفية وهندسة الأنظمة. خبير في بناء التطبيقات القابلة للتوسع والآمنة.',
            ],
            [
                'name_en' => 'Junaid Siddik',
                'name_ar' => 'جنيد صديق',
                'designation_en' => 'UI/UX Designer',
                'designation_ar' => 'مصمم UI/UX',
                'description_en' => 'Creative UI/UX designer with passion for user-centered design. Expert in creating intuitive and beautiful interfaces.',
                'description_ar' => 'مصمم UI/UX إبداعي شغوف بالتصميم المرتكز على المستخدم. خبير في إنشاء واجهات سهلة وجميلة.',
            ],
            [
                'name_en' => 'Marvin McKinney',
                'name_ar' => 'مارفن ماكيني',
                'designation_en' => 'CEO & Founder',
                'designation_ar' => 'الرئيس التنفيذي والمؤسس',
                'description_en' => 'Visionary leader with passion for technology and innovation. Driving Barmagly to deliver exceptional digital solutions.',
                'description_ar' => 'قائد رؤيوي شغوف بالتكنولوجيا والابتكار. يقود برمجلي لتقديم حلول رقمية استثنائية.',
            ],
        ];

        foreach ($teams as $index => $team) {
            $teamModel = Team::skip($index)->first();
            
            if (!$teamModel) {
                $teamModel = new Team();
                $teamModel->status = 'enable';
                $teamModel->save();
            }

            // Update English
            $transEn = TeamTranslation::where('team_id', $teamModel->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$transEn) {
                $transEn = new TeamTranslation();
                $transEn->team_id = $teamModel->id;
                $transEn->lang_code = 'en';
            }
            
            $transEn->name = $team['name_en'];
            $transEn->designation = $team['designation_en'];
            $transEn->description = $team['description_en'];
            $transEn->save();

            // Update Arabic
            $transAr = TeamTranslation::where('team_id', $teamModel->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$transAr) {
                $transAr = new TeamTranslation();
                $transAr->team_id = $teamModel->id;
                $transAr->lang_code = 'ar';
            }
            
            $transAr->name = $team['name_ar'];
            $transAr->designation = $team['designation_ar'];
            $transAr->description = $team['description_ar'];
            $transAr->save();
        }

        $this->command->info('✅ Teams updated!');
    }

    /**
     * Update Testimonials
     */
    private function updateTestimonials(): void
    {
        $this->command->info('📝 Updating Testimonials...');
        
        $testimonials = [
            [
                'name_en' => 'Omar Khaled',
                'name_ar' => 'عمر خالد',
                'designation_en' => 'CEO, Tech Startup',
                'designation_ar' => 'الرئيس التنفيذي، شركة تقنية ناشئة',
                'comment_en' => 'Barmagly delivered an exceptional website for our company. Their attention to detail and professional approach exceeded our expectations. The team was responsive, knowledgeable, and delivered on time.',
                'comment_ar' => 'قدمت برمجلي موقعاً استثنائياً لشركتنا. انتباههم للتفاصيل ونهجهم الاحترافي تجاوز توقعاتنا. الفريق كان متجاوباً ومطلعاً وسلم في الوقت المحدد.',
            ],
            [
                'name_en' => 'Layla Ahmed',
                'name_ar' => 'ليلى أحمد',
                'designation_en' => 'Marketing Director',
                'designation_ar' => 'مديرة التسويق',
                'comment_en' => 'The UI/UX design work by Barmagly transformed our user experience. Our conversion rates increased significantly after the redesign. Highly recommended for any business looking to improve their digital presence.',
                'comment_ar' => 'عمل تصميم UI/UX من برمجلي حول تجربة مستخدمنا. زادت معدلات التحويل لدينا بشكل كبير بعد إعادة التصميم. أنصح بهم بشدة لأي شركة تسعى لتحسين وجودها الرقمي.',
            ],
            [
                'name_en' => 'Youssef Mahmoud',
                'name_ar' => 'يوسف محمود',
                'designation_en' => 'Business Owner',
                'designation_ar' => 'صاحب عمل',
                'comment_en' => 'Professional web development services from Barmagly. The team understood our requirements perfectly and delivered a solution that exceeded our expectations. Great experience overall!',
                'comment_ar' => 'خدمات تطوير مواقع احترافية من برمجلي. الفريق فهم متطلباتنا بشكل مثالي وسلم حلاً تجاوز توقعاتنا. تجربة رائعة بشكل عام!',
            ],
        ];

        foreach ($testimonials as $index => $testimonial) {
            $testimonialModel = Testimonial::skip($index)->first();
            
            if (!$testimonialModel) {
                $testimonialModel = new Testimonial();
                $testimonialModel->status = 'active';
                $testimonialModel->save();
            }

            // Update English
            $transEn = TestimonialTrasnlation::where('testimonial_id', $testimonialModel->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$transEn) {
                $transEn = new TestimonialTrasnlation();
                $transEn->testimonial_id = $testimonialModel->id;
                $transEn->lang_code = 'en';
            }
            
            $transEn->name = $testimonial['name_en'];
            $transEn->designation = $testimonial['designation_en'];
            $transEn->comment = $testimonial['comment_en'];
            $transEn->save();

            // Update Arabic
            $transAr = TestimonialTrasnlation::where('testimonial_id', $testimonialModel->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$transAr) {
                $transAr = new TestimonialTrasnlation();
                $transAr->testimonial_id = $testimonialModel->id;
                $transAr->lang_code = 'ar';
            }
            
            $transAr->name = $testimonial['name_ar'];
            $transAr->designation = $testimonial['designation_ar'];
            $transAr->comment = $testimonial['comment_ar'];
            $transAr->save();
        }

        $this->command->info('✅ Testimonials updated!');
    }

    /**
     * Update FAQs
     */
    private function updateFAQs(): void
    {
        $this->command->info('📝 Updating FAQs...');
        
        $faqs = [
            [
                'question_en' => 'What services does Barmagly provide?',
                'question_ar' => 'ما هي الخدمات التي تقدمها برمجلي؟',
                'answer_en' => 'Barmagly specializes in professional web development, website design, UI/UX design, mobile app development, and e-commerce solutions. We focus exclusively on programming, design, and digital solutions to help businesses transform their online presence.',
                'answer_ar' => 'برمجلي متخصصة في تطوير المواقع الاحترافية وتصميمها وتصميم UI/UX وتطوير تطبيقات الهاتف وحلول المتاجر الإلكترونية. نركز حصرياً على البرمجة والتصميم والحلول الرقمية لمساعدة الشركات على تحويل وجودها عبر الإنترنت.',
            ],
            [
                'question_en' => 'What technologies does Barmagly use for web development?',
                'question_ar' => 'ما هي التقنيات التي تستخدمها برمجلي في تطوير المواقع؟',
                'answer_en' => 'We use the latest and most modern technologies including Laravel, Vue.js, React, Node.js, PHP, JavaScript, and more. Our team stays updated with the latest industry standards to deliver high-performance, secure, and scalable web applications.',
                'answer_ar' => 'نستخدم أحدث التقنيات وأكثرها حداثة بما في ذلك Laravel و Vue.js و React و Node.js و PHP و JavaScript والمزيد. فريقنا يواكب أحدث معايير الصناعة لتقديم تطبيقات ويب عالية الأداء وآمنة وقابلة للتوسع.',
            ],
            [
                'question_en' => 'How long does it take to develop a website?',
                'question_ar' => 'كم من الوقت يستغرق تطوير موقع ويب؟',
                'answer_en' => 'The timeline depends on the project complexity and requirements. A simple website typically takes 2-4 weeks, a business website with custom features takes 4-8 weeks, and complex web applications may take 2-6 months. We provide detailed project timelines during our initial consultation.',
                'answer_ar' => 'يعتمد الجدول الزمني على تعقيد المشروع والمتطلبات. عادة ما يستغرق الموقع البسيط من 2-4 أسابيع، والموقع التجاري بميزات مخصصة يستغرق من 4-8 أسابيع، والتطبيقات الويب المعقدة قد تستغرق من 2-6 أشهر. نقدم جداول زمنية مفصلة للمشروع أثناء استشارتنا الأولية.',
            ],
            [
                'question_en' => 'Do you provide website maintenance and support services?',
                'question_ar' => 'هل تقدمون خدمات صيانة المواقع والدعم؟',
                'answer_en' => 'Yes, we offer comprehensive website maintenance and support services. This includes regular updates, security patches, performance optimization, bug fixes, content updates, and 24/7 technical support. We have flexible support packages to meet your needs.',
                'answer_ar' => 'نعم، نقدم خدمات صيانة المواقع والدعم الشاملة. يشمل ذلك التحديثات المنتظمة وترقيعات الأمان وتحسين الأداء وإصلاح الأخطاء وتحديثات المحتوى والدعم التقني على مدار الساعة. لدينا حزم دعم مرنة لتلبية احتياجاتك.',
            ],
            [
                'question_en' => 'Can Barmagly redesign an existing website?',
                'question_ar' => 'هل يمكن لبرمجلي إعادة تصميم موقع موجود؟',
                'answer_en' => 'Absolutely! We can work with your existing website to improve its design, functionality, and user experience. Whether you need a complete redesign or specific improvements, our team will analyze your current site and provide recommendations to enhance its performance and appearance.',
                'answer_ar' => 'بالتأكيد! يمكننا العمل مع موقعك الحالي لتحسين تصميمه ووظائفه وتجربة المستخدم. سواء كنت بحاجة إلى إعادة تصميم كاملة أو تحسينات محددة، سيقوم فريقنا بتحليل موقعك الحالي وتقديم التوصيات لتحسين أدائه ومظهره.',
            ],
            [
                'question_en' => 'What is included in your UI/UX design service?',
                'question_ar' => 'ما الذي يشمله خدمة تصميم UI/UX لديكم؟',
                'answer_en' => 'Our UI/UX design service includes user research, wireframing, prototyping, visual design, usability testing, and design system creation. We focus on creating intuitive, user-friendly interfaces that improve engagement and conversion rates.',
                'answer_ar' => 'تشمل خدمة تصميم UI/UX لدينا البحث عن المستخدم وإنشاء الإطارات السلكية والنماذج الأولية والتصميم البصري واختبار سهولة الاستخدام وإنشاء نظام التصميم. نركز على إنشاء واجهات سهلة وبديهية تحسن المشاركة ومعدلات التحويل.',
            ],
            [
                'question_en' => 'How much does a website development project cost?',
                'question_ar' => 'كم تكلفة مشروع تطوير موقع ويب؟',
                'answer_en' => 'Project costs vary based on complexity, features, and requirements. We offer flexible pricing plans starting from $99/month for basic websites to custom enterprise solutions. Contact us for a free consultation and detailed quote tailored to your specific needs.',
                'answer_ar' => 'تختلف تكاليف المشروع بناءً على التعقيد والميزات والمتطلبات. نقدم خطط أسعار مرنة تبدأ من 99 دولاراً شهرياً للمواقع الأساسية إلى حلول المؤسسات المخصصة. تواصل معنا للحصول على استشارة مجانية وعرض أسعار مفصل مصمم خصيصاً لاحتياجاتك.',
            ],
            [
                'question_en' => 'Do you provide mobile app development for both iOS and Android?',
                'question_ar' => 'هل تقدمون تطوير تطبيقات الهاتف لكل من iOS و Android؟',
                'answer_en' => 'Yes, we develop mobile applications for both iOS and Android platforms. We can create native apps for each platform or use cross-platform frameworks like React Native and Flutter to develop apps that work on both platforms, saving time and cost.',
                'answer_ar' => 'نعم، نطور تطبيقات الهاتف لكل من منصات iOS و Android. يمكننا إنشاء تطبيقات أصلية لكل منصة أو استخدام أطر متعددة المنصات مثل React Native و Flutter لتطوير تطبيقات تعمل على كلا المنصتين، مما يوفر الوقت والتكلفة.',
            ],
            [
                'question_en' => 'What makes Barmagly different from other web development companies?',
                'question_ar' => 'ما الذي يميز برمجلي عن شركات تطوير المواقع الأخرى؟',
                'answer_en' => 'Barmagly focuses exclusively on programming, website design, and UI/UX services. We combine technical expertise with creative design to deliver solutions that are both functional and visually appealing. Our team is dedicated to understanding your business needs and providing personalized service throughout the project lifecycle.',
                'answer_ar' => 'تركز برمجلي حصرياً على البرمجة وتصميم المواقع وخدمات UI/UX. نجمع بين الخبرة التقنية والتصميم الإبداعي لتقديم حلول تكون وظيفية وجذابة بصرياً. فريقنا ملتزم بفهم احتياجات عملك وتقديم خدمة مخصصة طوال دورة حياة المشروع.',
            ],
            [
                'question_en' => 'How can I get started with Barmagly?',
                'question_ar' => 'كيف يمكنني البدء مع برمجلي؟',
                'answer_en' => 'Getting started is easy! Simply contact us through our website, email (info@barmagly.com), or phone (+201010254819). We offer a free consultation to discuss your project requirements, provide recommendations, and create a customized plan that fits your budget and timeline.',
                'answer_ar' => 'البدء سهل! ببساطة تواصل معنا عبر موقعنا أو البريد الإلكتروني (info@barmagly.com) أو الهاتف (+201010254819). نقدم استشارة مجانية لمناقشة متطلبات مشروعك وتقديم التوصيات وإنشاء خطة مخصصة تناسب ميزانيتك والجدول الزمني.',
            ],
        ];

        foreach ($faqs as $index => $faq) {
            $faqModel = Faq::skip($index)->first();
            
            if (!$faqModel) {
                $faqModel = new Faq();
                // Only set status if column exists
                if (DB::getSchemaBuilder()->hasColumn('faqs', 'status')) {
                    $faqModel->status = 'active';
                }
                $faqModel->save();
            }

            // Update English
            $transEn = FaqTranslation::where('faq_id', $faqModel->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$transEn) {
                $transEn = new FaqTranslation();
                $transEn->faq_id = $faqModel->id;
                $transEn->lang_code = 'en';
            }
            
            $transEn->question = $faq['question_en'];
            $transEn->answer = $faq['answer_en'];
            $transEn->save();

            // Update Arabic
            $transAr = FaqTranslation::where('faq_id', $faqModel->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$transAr) {
                $transAr = new FaqTranslation();
                $transAr->faq_id = $faqModel->id;
                $transAr->lang_code = 'ar';
            }
            
            $transAr->question = $faq['question_ar'];
            $transAr->answer = $faq['answer_ar'];
            $transAr->save();
        }

        $this->command->info('✅ FAQs updated!');
    }

    /**
     * Update Sliders
     */
    private function updateSliders(): void
    {
        $this->command->info('📝 Updating Sliders...');
        
        $sliders = Slider::all();

        if ($sliders->isEmpty()) {
            // Create new sliders
            $slider1 = Slider::create([
                'image' => 'uploads/slider/slider1.jpg',
                'url' => '/services'
            ]);

            $this->createSliderTranslation($slider1->id, 'en', [
                'title' => 'Barmagly - Professional Digital Solutions',
                'small_text' => 'Transform your business with expert web development and design services',
                'button_text' => 'Get Started'
            ]);

            $this->createSliderTranslation($slider1->id, 'ar', [
                'title' => 'برمجلي - حلول رقمية احترافية',
                'small_text' => 'حول أعمالك بخدمات تطوير المواقع والتصميم الخبيرة',
                'button_text' => 'ابدأ الآن'
            ]);

            $slider2 = Slider::create([
                'image' => 'uploads/slider/slider2.jpg',
                'url' => '/portfolio'
            ]);

            $this->createSliderTranslation($slider2->id, 'en', [
                'title' => 'Innovative Technology Solutions',
                'small_text' => 'We deliver exceptional results through our expertise in programming, design, and user experience',
                'button_text' => 'View Portfolio'
            ]);

            $this->createSliderTranslation($slider2->id, 'ar', [
                'title' => 'حلول تكنولوجية مبتكرة',
                'small_text' => 'نقدم نتائج استثنائية من خلال خبرتنا في البرمجة والتصميم وتجربة المستخدم',
                'button_text' => 'عرض المحفظة'
            ]);
        } else {
            // Update existing sliders
            foreach ($sliders as $index => $slider) {
                $translations = [
                    'en' => [
                        'title' => $index === 0
                            ? 'Barmagly - Professional Digital Solutions'
                            : 'Innovative Technology Solutions',
                        'small_text' => $index === 0
                            ? 'Transform your business with expert web development and design services'
                            : 'We deliver exceptional results through our expertise in programming, design, and user experience',
                        'button_text' => $index === 0
                            ? 'Get Started'
                            : 'View Portfolio'
                    ],
                    'ar' => [
                        'title' => $index === 0
                            ? 'برمجلي - حلول رقمية احترافية'
                            : 'حلول تكنولوجية مبتكرة',
                        'small_text' => $index === 0
                            ? 'حول أعمالك بخدمات تطوير المواقع والتصميم الخبيرة'
                            : 'نقدم نتائج استثنائية من خلال خبرتنا في البرمجة والتصميم وتجربة المستخدم',
                        'button_text' => $index === 0
                            ? 'ابدأ الآن'
                            : 'عرض المحفظة'
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

        $this->command->info('✅ Sliders updated!');
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

    /**
     * Update Blog Section
     */
    private function updateBlogSection(): void
    {
        $this->command->info('📝 Updating Blog Section...');
        
        $this->updateContent('main_demo_blog_section.content', [
            'heading' => [
                'en' => 'Latest Technology Insights & News',
                'ar' => 'أحدث الرؤى والأخبار التكنولوجية'
            ],
            'button_text' => [
                'en' => 'View All Blogs',
                'ar' => 'عرض جميع المدونات'
            ],
        ]);

        $this->command->info('✅ Blog Section updated!');
    }

    /**
     * Update FAQ Section
     */
    private function updateFAQSection(): void
    {
        $this->updateContent('digital_agency_faqs.content', [
            'heading' => [
                'en' => 'Frequently Asked Questions',
                'ar' => 'الأسئلة الشائعة'
            ],
            'description' => [
                'en' => 'Find answers to common questions about our web development, design, and digital services.',
                'ar' => 'ابحث عن إجابات للأسئلة الشائعة حول خدمات تطوير المواقع والتصميم والخدمات الرقمية لدينا.'
            ],
            'button_text' => [
                'en' => 'View All FAQs',
                'ar' => 'عرض جميع الأسئلة'
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
                $dataValues[$key] = $value['en'];
                // Check if translation for Arabic already exists
                $arTranslationFound = false;
                foreach ($translations as &$trans) {
                    if (isset($trans['language_code']) && $trans['language_code'] === 'ar') {
                        if (!isset($trans['values'])) {
                            $trans['values'] = [];
                        }
                        $trans['values'][$key] = $value['ar'];
                        $arTranslationFound = true;
                        break;
                    }
                }
                if (!$arTranslationFound) {
                    $translations[] = [
                        'language_code' => 'ar',
                        'values' => [$key => $value['ar']]
                    ];
                }
            } else {
                $dataValues[$key] = $value;
            }
        }

        if ($frontend->data_values && isset($frontend->data_values['images'])) {
            $dataValues['images'] = $frontend->data_values['images'];
        }

        $frontend->data_values = $dataValues;
        
        $existingTranslations = json_decode($frontend->data_translations, true) ?? [];
        foreach ($translations as $translation) {
            $found = false;
            foreach ($existingTranslations as &$existing) {
                if (isset($existing['language_code']) && $existing['language_code'] === $translation['language_code']) {
                    if (!isset($existing['values'])) {
                        $existing['values'] = [];
                    }
                    $existing['values'] = array_merge($existing['values'], $translation['values'] ?? []);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $existingTranslations[] = $translation;
            }
        }

        $frontend->data_translations = json_encode($existingTranslations);
        $frontend->save();
    }
}

