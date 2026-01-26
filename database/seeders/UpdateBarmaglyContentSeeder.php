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

class UpdateBarmaglyContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting Barmagly content update...');
        
        $this->updateContactInfo();
        $this->updateFooter();
        $this->updateAllFrontendSections();
        $this->updateSliders();
        $this->updateServices();
        $this->updateProjects();
        $this->updateBlogs();
        $this->updateTeams();
        $this->updateTestimonials();
        $this->updateFAQs();
        
        $this->command->info('✅ Barmagly content update finished!');
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
            $contactUs->email = 'info@barmagly.tech';
            $contactUs->email2 = 'info@barmagly.tech';
            $contactUs->phone = '+201010254819';
            $contactUs->phone2 = '+201010254819';
            $contactUs->map_code = '';
            $contactUs->save();
        } else {
            $contactUs->email = 'info@barmagly.tech';
            $contactUs->email2 = 'info@barmagly.tech';
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
        $transEn->description = 'Get in touch with us for your web development and design needs.';
        $transEn->address = 'Cairo-Egypt';
        $transEn->contact_description = 'We are here to help you with your programming, website design, and UI/UX needs.';
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
        $transAr->description = 'تواصل معنا لاحتياجاتك في تطوير المواقع والتصميم.';
        $transAr->address = 'قنا-مصر';
        $transAr->contact_description = 'نحن هنا لمساعدتك في احتياجاتك من البرمجة وتصميم المواقع وUI/UX.';
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
        
        $footer->address = 'Cairo-Egypt';
        $footer->phone = '+201010254819';
        $footer->email = 'info@barmagly.tech';
        $footer->copyright = 'Copyright 2026, Barmagly. All Rights Reserved.';
        $footer->facebook = 'https://www.facebook.com/BarmaglyOfficial';
        $footer->save();

        $this->command->info('✅ Footer updated!');
    }

    /**
     * Update All Frontend Sections
     */
    private function updateAllFrontendSections(): void
    {
        $this->command->info('📝 Updating All Frontend Sections...');
        
        // Hero Sections
        $this->updateContent('main_demo_hero.content', [
            'heading' => [
                'en' => 'We provide professional IT services',
                'ar' => 'نوفر خدمات تكنولوجيا المعلومات المهنية'
            ],
            'description' => [
                'en' => 'Best IT services for your agency. We transform businesses across major sectors with powerful and adaptive digital solutions that meet today\'s needs.',
                'ar' => 'أفضل خدمات تكنولوجيا المعلومات لوكالتك. نحول أعمال معظم القطاعات الرئيسية بحلول رقمية قوية وقابلة للتكيف تلبي احتياجات اليوم.'
            ],
            'small_description' => [
                'en' => 'Professional programming, website design, and UI/UX services',
                'ar' => 'خدمات البرمجة وتصميم المواقع وUI/UX الاحترافية'
            ],
            'left_button_text' => [
                'en' => 'Work with us',
                'ar' => 'اعمل معنا'
            ],
            'left_button_url' => '/services',
            'right_button_text' => [
                'en' => 'View Services',
                'ar' => 'عرض الخدمات'
            ],
            'right_button_url' => '/services',
        ]);

        $this->updateContent('startup_home_hero_section.content', [
            'heading' => [
                'en' => 'We provide professional IT services',
                'ar' => 'نوفر خدمات تكنولوجيا المعلومات المهنية'
            ],
            'description' => [
                'en' => 'Best IT services for your agency. We transform businesses across major sectors with powerful and adaptive digital solutions.',
                'ar' => 'أفضل خدمات تكنولوجيا المعلومات لوكالتك. نحول أعمال معظم القطاعات الرئيسية بحلول رقمية قوية وقابلة للتكيف.'
            ],
            'small_description' => [
                'en' => 'Professional programming, website design, and UI/UX services',
                'ar' => 'خدمات البرمجة وتصميم المواقع وUI/UX الاحترافية'
            ],
            'left_button_text' => [
                'en' => 'Work with us',
                'ar' => 'اعمل معنا'
            ],
            'left_button_url' => '/services',
            'right_button_text' => [
                'en' => 'View Services',
                'ar' => 'عرض الخدمات'
            ],
            'right_button_url' => '/services',
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

        // About Us Sections
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

        $this->updateContent('startup_home_about_us.content', [
            'heading' => [
                'en' => 'About Barmagly',
                'ar' => 'عن برمجلي'
            ],
            'sub_heading' => [
                'en' => 'Your Trusted Development Partner',
                'ar' => 'شريكك الموثوق في التطوير'
            ],
            'description' => [
                'en' => 'We are a team of skilled developers and designers specializing in web development, website design, and UI/UX services.',
                'ar' => 'نحن فريق من المطورين والمصممين المهرة المتخصصين في تطوير المواقع وتصميمها وخدمات UI/UX.'
            ],
            'left_text' => [
                'en' => 'Projects Completed',
                'ar' => 'مشروع مكتمل'
            ],
            'right_text' => [
                'en' => 'Happy Clients',
                'ar' => 'عميل سعيد'
            ],
        ]);

        // IT Solutions Hero Section
        $this->updateContent('it_solutions_hero_section.content', [
            'heading' => [
                'en' => 'The Next Step to Enhance Your Business',
                'ar' => 'الخطوة التالية لتعزيز نشاطك التجاري'
            ],
            'description' => [
                'en' => 'Enhance your presence with Barmagly',
                'ar' => 'عزز تواجدك مع برمجلي'
            ],
            'button_text' => [
                'en' => 'Get Started Now',
                'ar' => 'إبدأ الآن'
            ],
        ]);

        // IT Solutions About Us Section
        $this->updateContent('it_solutions_about_us.content', [
            'heading' => [
                'en' => 'We provide perfect IT solutions & technology',
                'ar' => 'نقدم حلول تكنولوجيا المعلومات والتكنولوجيا المثالية'
            ],
            'description' => [
                'en' => 'During this time, we\'ve built a reputation for excellent customer satisfaction as evidenced by our quality services and professional team.',
                'ar' => 'خلال هذه الفترة، بنينا سمعة لرضا العملاء الممتاز كما يتضح من خدماتنا عالية الجودة وفريقنا المحترف.'
            ],
            'feature_text_1' => [
                'en' => 'Providing skill services',
                'ar' => 'تقديم خدمات المهارات'
            ],
            'feature_text_2' => [
                'en' => 'Urgent customer support',
                'ar' => 'دعم العملاء العاجل'
            ],
            'feature_text_3' => [
                'en' => 'Advanced information technology solutions',
                'ar' => 'حلول تكنولوجيا المعلومات المتقدمة'
            ],
            'button_text' => [
                'en' => 'More About Us',
                'ar' => 'المزيد عنا'
            ],
        ]);

        // Service Sections
        $this->updateContent('main_demo_service_section.content', [
            'heading' => [
                'en' => 'Our Services',
                'ar' => 'خدماتنا'
            ],
        ]);

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

        // CTA Sections
        $this->updateContent('main_demo_cta_section.content', [
            'heading' => [
                'en' => 'Let\'s work together',
                'ar' => 'دعنا نعمل معاً'
            ],
            'description' => [
                'en' => 'Ready to transform your digital presence? Contact us today for a free consultation.',
                'ar' => 'جاهز لتحويل وجودك الرقمي؟ تواصل معنا اليوم للحصول على استشارة مجانية.'
            ],
            'button_text' => [
                'en' => 'Let\'s Start a Project',
                'ar' => 'دعنا نبدأ مشروعاً'
            ],
            'button_link' => 'contact-us',
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
            'step_1' => [
                'en' => 'Discovery',
                'ar' => 'الاكتشاف'
            ],
            'description_1' => [
                'en' => 'We understand your needs and goals',
                'ar' => 'نفهم احتياجاتك وأهدافك'
            ],
            'step_2' => [
                'en' => 'Design & Development',
                'ar' => 'التصميم والتطوير'
            ],
            'description_2' => [
                'en' => 'We create and build your solution',
                'ar' => 'نصمم ونبني حلولك'
            ],
            'step_3' => [
                'en' => 'Launch & Support',
                'ar' => 'الإطلاق والدعم'
            ],
            'description_3' => [
                'en' => 'We launch and maintain your project',
                'ar' => 'نطلق ونحافظ على مشروعك'
            ],
        ]);

        // Blog Section
        $this->updateContent('main_demo_blog_section.content', [
            'heading' => [
                'en' => 'Latest blogs and articles about technology',
                'ar' => 'المدونات والمقالات الأخيرة حول التكنولوجيا'
            ],
            'button_text' => [
                'en' => 'View All Blogs',
                'ar' => 'عرض جميع المدونات'
            ],
        ]);

        // Testimonial Section
        $this->updateContent('main_demo_testimonial_section.content', [
            'heading' => [
                'en' => 'What Our Clients Say',
                'ar' => 'ماذا يقول عملاؤنا'
            ],
        ]);

        // FAQ Sections
        $this->updateContent('digital_agency_faqs.content', [
            'heading' => [
                'en' => 'Frequently Asked Questions',
                'ar' => 'الأسئلة الشائعة'
            ],
            'description' => [
                'en' => 'Find answers to common questions about our services.',
                'ar' => 'ابحث عن إجابات للأسئلة الشائعة حول خدماتنا.'
            ],
            'button_text' => [
                'en' => 'View All FAQs',
                'ar' => 'عرض جميع الأسئلة'
            ],
        ]);

        $this->updateContent('faq_section.content', [
            'heading' => [
                'en' => 'Frequently Asked Questions',
                'ar' => 'الأسئلة الشائعة'
            ],
            'description' => [
                'en' => 'Find answers to common questions about our services.',
                'ar' => 'ابحث عن إجابات للأسئلة الشائعة حول خدماتنا.'
            ],
            'button_text' => [
                'en' => 'View All FAQs',
                'ar' => 'عرض جميع الأسئلة'
            ],
        ]);

        // Pricing Section
        $this->updateContent('it_solutions_pricing_section.content', [
            'heading' => [
                'en' => 'Explore flexible pricing for you',
                'ar' => 'استكشف أسعار مرنة لك'
            ],
        ]);

        // Contact Form Section
        $this->updateContent('contact_form_section.content', [
            'heading' => [
                'en' => 'Get In Touch',
                'ar' => 'تواصل معنا'
            ],
            'description' => [
                'en' => 'Fill out the form below and we\'ll get back to you as soon as possible.',
                'ar' => 'املأ النموذج أدناه وسنعود إليك في أقرب وقت ممكن.'
            ],
            'button_text' => [
                'en' => 'Send Message',
                'ar' => 'إرسال الرسالة'
            ],
        ]);

        // Contact Info Section
        $this->updateContent('contact_info_section.content', [
            'heading' => [
                'en' => 'Contact Information',
                'ar' => 'معلومات الاتصال'
            ],
            'description' => [
                'en' => 'We are here to help you with your programming, website design, and UI/UX needs.',
                'ar' => 'نحن هنا لمساعدتك في احتياجاتك من البرمجة وتصميم المواقع وUI/UX.'
            ],
            'office_hours' => [
                'en' => 'Monday - Friday: 9:00 AM - 6:00 PM',
                'ar' => 'الاثنين - الجمعة: 9:00 صباحاً - 6:00 مساءً'
            ],
        ]);

        // Counter Sections
        $this->updateContent('it_consulting_counter_section.content', [
            'counter_1' => '100+',
            'title_1' => [
                'en' => 'Projects Completed',
                'ar' => 'مشروع مكتمل'
            ],
            'counter_2' => '50+',
            'title_2' => [
                'en' => 'Happy Clients',
                'ar' => 'عميل سعيد'
            ],
            'counter_3' => '10+',
            'title_3' => [
                'en' => 'Years Experience',
                'ar' => 'سنة خبرة'
            ],
            'counter_4' => '20+',
            'title_4' => [
                'en' => 'Team Members',
                'ar' => 'عضو فريق'
            ],
        ]);

        $this->updateContent('about_us_counter_section.content', [
            'counter_1' => '100+',
            'title_1' => [
                'en' => 'Projects Completed',
                'ar' => 'مشروع مكتمل'
            ],
            'counter_2' => '50+',
            'title_2' => [
                'en' => 'Happy Clients',
                'ar' => 'عميل سعيد'
            ],
            'counter_3' => '10+',
            'title_3' => [
                'en' => 'Years Experience',
                'ar' => 'سنة خبرة'
            ],
            'counter_4' => '20+',
            'title_4' => [
                'en' => 'Team Members',
                'ar' => 'عضو فريق'
            ],
        ]);

        $this->command->info('✅ All Frontend Sections updated!');
    }

    /**
     * Update Services
     */
    private function updateServices(): void
    {
        $this->command->info('📝 Updating Services...');
        
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
                'description_en' => 'Professional web development with the latest technologies',
                'description_ar' => 'تطوير مواقع احترافي بأحدث التقنيات',
            ],
            [
                'title_en' => 'Website Design',
                'title_ar' => 'تصميم المواقع',
                'description_en' => 'Beautiful, responsive website designs',
                'description_ar' => 'تصاميم مواقع جميلة ومتجاوبة',
            ],
            [
                'title_en' => 'UI/UX Design',
                'title_ar' => 'تصميم UI/UX',
                'description_en' => 'User-centered design for better experiences',
                'description_ar' => 'تصميم يركز على المستخدم لتجارب أفضل',
            ],
            [
                'title_en' => 'Mobile App Development',
                'title_ar' => 'تطوير تطبيقات الهاتف',
                'description_en' => 'iOS and Android app development',
                'description_ar' => 'تطوير تطبيقات iOS و Android',
            ],
            [
                'title_en' => 'E-commerce Development',
                'title_ar' => 'تطوير المتاجر الإلكترونية',
                'description_en' => 'Complete e-commerce solutions',
                'description_ar' => 'حلول متاجر إلكترونية كاملة',
            ],
            [
                'title_en' => 'Data Security Tracking',
                'title_ar' => 'أمان تتبع البيانات',
                'description_en' => 'Develop a comprehensive IT strategy aligned with your goals.',
                'description_ar' => 'تطوير استراتيجية تكنولوجيا معلومات شاملة تتماشى مع أهدافك.',
            ],
        ];

        foreach ($services as $index => $service) {
            $listing = Listing::skip($index)->first();
            
            if (!$listing) {
                $listing = new Listing();
                $listing->category_id = $category->id;
                $listing->sub_category_id = 0;
                $listing->thumb_image = 'default/service.jpg';
                $listing->slug = \Illuminate\Support\Str::slug($service['title_en']);
                $listing->regular_price = 0;
                $listing->offer_price = null;
                $listing->status = 'enable';
                $listing->save();
            }

            // Update English
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
                $transEn->address = $service['description_en'];
            }
            $transEn->save();

            // Update Arabic
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
                $transAr->address = $service['description_ar'];
            }
            $transAr->save();
        }

        $this->command->info('✅ Services updated!');
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
                'description_en' => 'Complete e-commerce platform with modern design and advanced features.',
                'description_ar' => 'منصة متجر إلكتروني كاملة بتصميم حديث وميزات متقدمة.',
                'client_name_en' => 'Tech Solutions',
                'client_name_ar' => 'حلول تقنية',
                'category_en' => 'Programming',
                'category_ar' => 'البرمجة',
            ],
            [
                'title_en' => 'Corporate Website Redesign',
                'title_ar' => 'إعادة تصميم موقع شركة',
                'description_en' => 'Complete redesign of corporate website with focus on user experience.',
                'description_ar' => 'إعادة تصميم كاملة لموقع شركة مع التركيز على تجربة المستخدم.',
                'client_name_en' => 'Business Corp',
                'client_name_ar' => 'شركة الأعمال',
                'category_en' => 'Business Style',
                'category_ar' => 'نمط الأعمال',
            ],
            [
                'title_en' => 'Mobile App UI/UX Design',
                'title_ar' => 'تصميم UI/UX لتطبيق الهاتف',
                'description_en' => 'User interface design for mobile application with focus on usability.',
                'description_ar' => 'تصميم واجهة مستخدم لتطبيق الهاتف مع التركيز على سهولة الاستخدام.',
                'client_name_en' => 'Mobile Solutions',
                'client_name_ar' => 'حلول الهاتف',
                'category_en' => 'Business Style',
                'category_ar' => 'نمط الأعمال',
            ],
            [
                'title_en' => 'Content Management System Solution',
                'title_ar' => 'حل برمجيات نظام إدارة المحتوى',
                'description_en' => 'Custom CMS solution for content management.',
                'description_ar' => 'حل CMS مخصص لإدارة المحتوى.',
                'client_name_en' => 'Content Solutions',
                'client_name_ar' => 'حلول المحتوى',
                'category_en' => 'Electronics',
                'category_ar' => 'الإلكترونيات',
            ],
            [
                'title_en' => 'Marketing Project',
                'title_ar' => 'مشروع للتسويق',
                'description_en' => 'Digital marketing platform development.',
                'description_ar' => 'تطوير منصة تسويق رقمي.',
                'client_name_en' => 'Marketing Agency',
                'client_name_ar' => 'وكالة تسويق',
                'category_en' => 'Electronics',
                'category_ar' => 'الإلكترونيات',
            ],
            [
                'title_en' => 'Cyber Security Analysis',
                'title_ar' => 'تحليل الأمن السيبراني',
                'description_en' => 'Comprehensive cybersecurity analysis and solutions.',
                'description_ar' => 'تحليل وحلول أمن سيبراني شاملة.',
                'client_name_en' => 'Security Solutions',
                'client_name_ar' => 'حلول الأمان',
                'category_en' => 'AI Services',
                'category_ar' => 'خدمات الذكاء الاصطناعي',
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
                'title_en' => 'Planning your online business goals with an expert',
                'title_ar' => 'تخطيط أهداف عملك عبر الإنترنت مع أخصائي',
                'description_en' => 'Learn how to effectively plan your online business goals with expert guidance.',
                'description_ar' => 'تعلم كيف تخطط أهداف أعمالك عبر الإنترنت بشكل فعال مع إرشادات الخبراء.',
            ],
            [
                'title_en' => 'Market insights for managing people-related costs',
                'title_ar' => 'رؤى السوق لإدارة التكاليف المتعلقة بالأشخاص',
                'description_en' => 'Understanding market trends for better cost management and business optimization.',
                'description_ar' => 'فهم اتجاهات السوق لإدارة أفضل للتكاليف وتحسين الأعمال.',
            ],
            [
                'title_en' => 'Boost your startup with our digital agency',
                'title_ar' => 'عزز عملك الناشئ مع وكالتنا الرقمية',
                'description_en' => 'Discover how our digital agency can accelerate your startup growth and success.',
                'description_ar' => 'اكتشف كيف يمكن لوكالتنا الرقمية تسريع نمو ونجاح شركتك الناشئة.',
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
                'description_en' => 'Expert in web development with extensive experience in modern technologies.',
                'description_ar' => 'خبير في تطوير المواقع مع خبرة واسعة في التقنيات الحديثة.',
            ],
            [
                'name_en' => 'David Richard',
                'name_ar' => 'ديفيد ريتشارد',
                'designation_en' => 'Lead Developer',
                'designation_ar' => 'مطور رئيسي',
                'description_en' => 'Specialized in backend development and system architecture.',
                'description_ar' => 'متخصص في تطوير الواجهة الخلفية وهندسة الأنظمة.',
            ],
            [
                'name_en' => 'Junaid Siddik',
                'name_ar' => 'جنيد صديق',
                'designation_en' => 'Real Estate Broker',
                'designation_ar' => 'وسيط عقاري',
                'description_en' => 'Business development and client relations specialist.',
                'description_ar' => 'متخصص في تطوير الأعمال وعلاقات العملاء.',
            ],
            [
                'name_en' => 'Marvin McKinney',
                'name_ar' => 'مارفن ماكيني',
                'designation_en' => 'CEO & Founder',
                'designation_ar' => 'الرئيس التنفيذي والمؤسس',
                'description_en' => 'Visionary leader with passion for technology and innovation.',
                'description_ar' => 'قائد رؤيوي شغوف بالتكنولوجيا والابتكار.',
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
                'comment_en' => 'Barmagly delivered an exceptional website for our company. Their attention to detail and professional approach exceeded our expectations.',
                'comment_ar' => 'قدمت برمجلي موقعاً استثنائياً لشركتنا. انتباههم للتفاصيل ونهجهم الاحترافي تجاوز توقعاتنا.',
            ],
            [
                'name_en' => 'Layla Ahmed',
                'name_ar' => 'ليلى أحمد',
                'designation_en' => 'Marketing Director',
                'designation_ar' => 'مديرة التسويق',
                'comment_en' => 'The UI/UX design work by Barmagly transformed our user experience. Our conversion rates increased significantly after the redesign.',
                'comment_ar' => 'عمل تصميم UI/UX من برمجلي حول تجربة مستخدمنا. زادت معدلات التحويل لدينا بشكل كبير بعد إعادة التصميم.',
            ],
            [
                'name_en' => 'Youssef Mahmoud',
                'name_ar' => 'يوسف محمود',
                'designation_en' => 'Business Owner',
                'designation_ar' => 'صاحب عمل',
                'comment_en' => 'Professional web development services. The team was responsive, knowledgeable, and delivered on time.',
                'comment_ar' => 'خدمات تطوير مواقع احترافية. الفريق كان متجاوباً ومطلعاً وسلم في الوقت المحدد.',
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
                'question_en' => 'Can I pay through the bank?',
                'question_ar' => 'هل يمكنني الدفع عبر البنك؟',
                'answer_en' => 'Yes, you can pay through the bank easily. We offer multiple secure payment options including direct bank transfers. Make sure to use official payment channels only and avoid any unauthorized payment methods.',
                'answer_ar' => 'نعم، يمكنك الدفع عبر البنك بسهولة. نحن نقدم خيارات دفع متعددة وآمنة تشمل التحويلات البنكية المباشرة. تأكد من استخدام قنوات الدفع الرسمية فقط وتجنب أي طرق دفع غير معتمدة.',
            ],
            [
                'question_en' => 'What precautions should I take to avoid fraud?',
                'question_ar' => 'ما هي الاحتياطات التي يجب أن أتخذها لتجنب عمليات الاحتيال؟',
                'answer_en' => 'Always verify payment details, use official communication channels, and never share sensitive information through unsecured platforms.',
                'answer_ar' => 'تحقق دائماً من تفاصيل الدفع، استخدم قنوات الاتصال الرسمية، ولا تشارك المعلومات الحساسة عبر منصات غير آمنة.',
            ],
            [
                'question_en' => 'What should I do if I encounter problems with a client or project?',
                'question_ar' => 'ماذا يجب أن أفعل إذا واجهت مشاكل مع عميل أو مشروع؟',
                'answer_en' => 'Contact our support team immediately. We provide 24/7 customer support to help resolve any issues quickly and efficiently.',
                'answer_ar' => 'اتصل بفريق الدعم لدينا فوراً. نقدم دعم عملاء 24/7 لمساعدتك في حل أي مشاكل بسرعة وكفاءة.',
            ],
            [
                'question_en' => 'Are there any fees associated with using the freelance marketplace?',
                'question_ar' => 'هل هناك أي رسوم مرتبطة باستخدام سوق العمل الحر؟',
                'answer_en' => 'Our pricing is transparent. Contact us for detailed information about our service packages and pricing plans.',
                'answer_ar' => 'أسعارنا شفافة. تواصل معنا للحصول على معلومات مفصلة عن حزم الخدمات وخطط الأسعار.',
            ],
        ];

        foreach ($faqs as $index => $faq) {
            $faqModel = Faq::skip($index)->first();
            
            if (!$faqModel) {
                $faqModel = new Faq();
                $faqModel->status = 'active';
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
            // Create new sliders if none exist
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

