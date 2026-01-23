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
        $transEn->description = 'Get in touch with us for your web development and design needs.';
        $transEn->address = 'Qena-Egypt';
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
        
        $footer->address = 'Qena-Egypt';
        $footer->phone = '+201010254819';
        $footer->email = 'info@barmagly.com';
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
                'ar' => 'الأحد - الجمعة: 9:00 صباحاً - 6:00 مساءً'
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
        
        // Delete all existing blogs first
        $this->command->info('🗑️ Deleting existing blogs...');
        BlogTranslation::query()->delete();
        Blog::query()->delete();
        
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
                'title_en' => 'Professional Web Development Services by Barmagly: Transform Your Business Online',
                'title_ar' => 'خدمات تطوير المواقع الاحترافية من برمجلي: حول عملك إلى الإنترنت',
                'description_en' => '<p>In today\'s digital age, having a professional website is essential for any business. <a href="https://barmagly.com" target="_blank">Barmagly</a> offers comprehensive web development services that help businesses establish a strong online presence. Our team of expert developers at <a href="https://barmagly.com" target="_blank">Barmagly</a> specializes in creating custom web applications using the latest technologies and best practices.</p>
                
                <p>When you choose <a href="https://barmagly.com" target="_blank">Barmagly</a> for your web development needs, you get access to cutting-edge solutions that are scalable, secure, and user-friendly. Whether you need a simple business website or a complex web application, <a href="https://barmagly.com/services" target="_blank">Barmagly\'s web development services</a> are designed to meet your specific requirements.</p>
                
                <p>At <a href="https://barmagly.com" target="_blank">Barmagly</a>, we understand that every business is unique. That\'s why we take a personalized approach to web development, ensuring that your website reflects your brand identity and serves your business goals. Visit <a href="https://barmagly.com" target="_blank">barmagly.com</a> to learn more about our web development expertise and how we can help transform your digital presence.</p>
                
                <p>Our <a href="https://barmagly.com" target="_blank">Barmagly</a> development team uses modern frameworks and technologies to build responsive, fast-loading websites that provide an excellent user experience. With <a href="https://barmagly.com" target="_blank">Barmagly</a>, you can trust that your web development project will be completed on time and within budget. Contact <a href="https://barmagly.com" target="_blank">Barmagly</a> today to discuss your web development needs!</p>',
                'description_ar' => '<p>في العصر الرقمي الحالي، أصبح وجود موقع ويب احترافي ضرورياً لأي عمل تجاري. تقدم <a href="https://barmagly.com" target="_blank">برمجلي</a> خدمات تطوير مواقع شاملة تساعد الشركات على إنشاء وجود قوي على الإنترنت. فريق المطورين الخبراء لدينا في <a href="https://barmagly.com" target="_blank">برمجلي</a> متخصص في إنشاء تطبيقات ويب مخصصة باستخدام أحدث التقنيات وأفضل الممارسات.</p>
                
                <p>عندما تختار <a href="https://barmagly.com" target="_blank">برمجلي</a> لاحتياجات تطوير المواقع الخاصة بك، تحصل على حلول متطورة قابلة للتوسع وآمنة وسهلة الاستخدام. سواء كنت بحاجة إلى موقع شركة بسيط أو تطبيق ويب معقد، تم تصميم <a href="https://barmagly.com/services" target="_blank">خدمات تطوير المواقع من برمجلي</a> لتلبية متطلباتك المحددة.</p>
                
                <p>في <a href="https://barmagly.com" target="_blank">برمجلي</a>، نفهم أن كل عمل تجاري فريد من نوعه. لهذا السبب نتبع نهجاً شخصياً في تطوير المواقع، مما يضمن أن موقعك يعكس هوية علامتك التجارية ويلبي أهداف عملك. زر <a href="https://barmagly.com" target="_blank">barmagly.com</a> لمعرفة المزيد عن خبرتنا في تطوير المواقع وكيف يمكننا المساعدة في تحويل وجودك الرقمي.</p>
                
                <p>يستخدم فريق التطوير لدينا في <a href="https://barmagly.com" target="_blank">برمجلي</a> أطر عمل وتقنيات حديثة لبناء مواقع متجاوبة وسريعة التحميل توفر تجربة مستخدم ممتازة. مع <a href="https://barmagly.com" target="_blank">برمجلي</a>، يمكنك الوثوق بأن مشروع تطوير موقعك سيتم إنجازه في الوقت المحدد وفي حدود الميزانية. اتصل بـ <a href="https://barmagly.com" target="_blank">برمجلي</a> اليوم لمناقشة احتياجات تطوير المواقع الخاصة بك!</p>',
            ],
            [
                'title_en' => 'Expert Website Design Services from Barmagly: Create Stunning Online Experiences',
                'title_ar' => 'خدمات تصميم المواقع الاحترافية من برمجلي: أنشئ تجارب رقمية مذهلة',
                'description_en' => '<p>First impressions matter, especially in the digital world. <a href="https://barmagly.com" target="_blank">Barmagly</a> provides exceptional website design services that create beautiful, responsive websites that engage visitors and drive conversions. Our talented designers at <a href="https://barmagly.com" target="_blank">Barmagly</a> combine creativity with functionality to deliver designs that not only look great but also perform exceptionally well.</p>
                
                <p>With <a href="https://barmagly.com" target="_blank">Barmagly\'s website design services</a>, you can expect modern, clean designs that are optimized for all devices. Whether your audience uses desktops, tablets, or smartphones, <a href="https://barmagly.com" target="_blank">Barmagly</a> ensures your website looks perfect on every screen size. Visit <a href="https://barmagly.com" target="_blank">barmagly.com</a> to see examples of our stunning website designs.</p>
                
                <p>At <a href="https://barmagly.com" target="_blank">Barmagly</a>, we believe that great website design goes beyond aesthetics. Our team focuses on creating user-friendly interfaces that guide visitors toward your business goals. When you work with <a href="https://barmagly.com" target="_blank">Barmagly</a>, you get a website that is both visually appealing and strategically designed to convert visitors into customers.</p>
                
                <p>The <a href="https://barmagly.com" target="_blank">Barmagly</a> design process involves thorough research, creative brainstorming, and meticulous attention to detail. We work closely with our clients to understand their vision and bring it to life through exceptional design. Discover how <a href="https://barmagly.com" target="_blank">Barmagly</a> can transform your online presence with our professional website design services. Contact <a href="https://barmagly.com" target="_blank">Barmagly</a> today!</p>',
                'description_ar' => '<p>الانطباعات الأولى مهمة، خاصة في العالم الرقمي. تقدم <a href="https://barmagly.com" target="_blank">برمجلي</a> خدمات تصميم مواقع استثنائية تنشئ مواقع جميلة ومتجاوبة تجذب الزوار وتزيد المبيعات. يجمع مصممونا الموهوبون في <a href="https://barmagly.com" target="_blank">برمجلي</a> بين الإبداع والوظائف لتقديم تصاميم لا تبدو رائعة فحسب، بل تؤدي أيضاً بشكل استثنائي.</p>
                
                <p>مع <a href="https://barmagly.com" target="_blank">خدمات تصميم المواقع من برمجلي</a>، يمكنك توقع تصاميم حديثة ونظيفة محسّنة لجميع الأجهزة. سواء كان جمهورك يستخدم أجهزة الكمبيوتر المكتبية أو الأجهزة اللوحية أو الهواتف الذكية، تضمن <a href="https://barmagly.com" target="_blank">برمجلي</a> أن موقعك يبدو مثالياً على كل حجم شاشة. زر <a href="https://barmagly.com" target="_blank">barmagly.com</a> لرؤية أمثلة على تصاميم مواقعنا المذهلة.</p>
                
                <p>في <a href="https://barmagly.com" target="_blank">برمجلي</a>، نؤمن بأن تصميم المواقع الرائع يتجاوز الجماليات. يركز فريقنا على إنشاء واجهات سهلة الاستخدام توجه الزوار نحو أهداف عملك. عندما تعمل مع <a href="https://barmagly.com" target="_blank">برمجلي</a>، تحصل على موقع جذاب بصرياً ومصمم استراتيجياً لتحويل الزوار إلى عملاء.</p>
                
                <p>تتضمن عملية التصميم في <a href="https://barmagly.com" target="_blank">برمجلي</a> بحثاً شاملاً وعصفاً ذهنياً إبداعياً واهتماماً دقيقاً بالتفاصيل. نعمل بشكل وثيق مع عملائنا لفهم رؤيتهم وتحويلها إلى واقع من خلال التصميم الاستثنائي. اكتشف كيف يمكن لـ <a href="https://barmagly.com" target="_blank">برمجلي</a> تحويل وجودك الرقمي من خلال خدمات تصميم المواقع الاحترافية. اتصل بـ <a href="https://barmagly.com" target="_blank">برمجلي</a> اليوم!</p>',
            ],
            [
                'title_en' => 'UI/UX Design Excellence with Barmagly: Enhance User Experience and Engagement',
                'title_ar' => 'التميز في تصميم UI/UX مع برمجلي: عزز تجربة المستخدم والتفاعل',
                'description_en' => '<p>User experience is at the heart of every successful digital product. <a href="https://barmagly.com" target="_blank">Barmagly</a> specializes in UI/UX design services that create intuitive, delightful user experiences. Our expert designers at <a href="https://barmagly.com" target="_blank">Barmagly</a> understand user behavior and design interfaces that are both beautiful and functional.</p>
                
                <p>When you partner with <a href="https://barmagly.com" target="_blank">Barmagly</a> for UI/UX design, you benefit from our user-centered design approach. We conduct thorough user research, create detailed wireframes, and develop prototypes that ensure your product meets user needs effectively. Visit <a href="https://barmagly.com" target="_blank">barmagly.com</a> to learn more about <a href="https://barmagly.com/services" target="_blank">Barmagly\'s UI/UX design services</a>.</p>
                
                <p>At <a href="https://barmagly.com" target="_blank">Barmagly</a>, we believe that great UI/UX design can significantly impact your business success. Our designs are not just visually appealing; they are strategically crafted to improve user engagement, reduce bounce rates, and increase conversions. With <a href="https://barmagly.com" target="_blank">Barmagly</a>, you get designs that users love to interact with.</p>
                
                <p>The <a href="https://barmagly.com" target="_blank">Barmagly</a> UI/UX team uses the latest design tools and methodologies to create seamless user experiences across all platforms. From mobile apps to web applications, <a href="https://barmagly.com" target="_blank">Barmagly</a> ensures consistent, high-quality design that enhances user satisfaction. Contact <a href="https://barmagly.com" target="_blank">Barmagly</a> today to elevate your product\'s user experience!</p>',
                'description_ar' => '<p>تجربة المستخدم هي في قلب كل منتج رقمي ناجح. تختص <a href="https://barmagly.com" target="_blank">برمجلي</a> في خدمات تصميم UI/UX التي تنشئ تجارب مستخدم سهلة وممتعة. يفهم مصممونا الخبراء في <a href="https://barmagly.com" target="_blank">برمجلي</a> سلوك المستخدم ويصممون واجهات جميلة ووظيفية.</p>
                
                <p>عندما تتشارك مع <a href="https://barmagly.com" target="_blank">برمجلي</a> لتصميم UI/UX، تستفيد من نهجنا في التصميم المرتكز على المستخدم. نجري بحثاً شاملاً عن المستخدمين، وننشئ مخططات تفصيلية، ونطور نماذج أولية تضمن أن منتجك يلبي احتياجات المستخدمين بفعالية. زر <a href="https://barmagly.com" target="_blank">barmagly.com</a> لمعرفة المزيد عن <a href="https://barmagly.com/services" target="_blank">خدمات تصميم UI/UX من برمجلي</a>.</p>
                
                <p>في <a href="https://barmagly.com" target="_blank">برمجلي</a>، نؤمن بأن تصميم UI/UX الرائع يمكن أن يؤثر بشكل كبير على نجاح عملك. تصاميمنا ليست جذابة بصرياً فحسب؛ بل هي مصممة استراتيجياً لتحسين تفاعل المستخدم وتقليل معدلات الارتداد وزيادة التحويلات. مع <a href="https://barmagly.com" target="_blank">برمجلي</a>، تحصل على تصاميم يحب المستخدمون التفاعل معها.</p>
                
                <p>يستخدم فريق UI/UX في <a href="https://barmagly.com" target="_blank">برمجلي</a> أحدث أدوات التصميم والمنهجيات لإنشاء تجارب مستخدم سلسة عبر جميع المنصات. من تطبيقات الهاتف إلى تطبيقات الويب، تضمن <a href="https://barmagly.com" target="_blank">برمجلي</a> تصميماً متسقاً وعالي الجودة يعزز رضا المستخدم. اتصل بـ <a href="https://barmagly.com" target="_blank">برمجلي</a> اليوم لرفع تجربة مستخدم منتجك!</p>',
            ],
            [
                'title_en' => 'Mobile App Development by Barmagly: Build Powerful iOS and Android Applications',
                'title_ar' => 'تطوير تطبيقات الهاتف من برمجلي: أنشئ تطبيقات iOS و Android قوية',
                'description_en' => '<p>Mobile apps have become essential for businesses looking to reach customers on the go. <a href="https://barmagly.com" target="_blank">Barmagly</a> offers comprehensive mobile app development services for both iOS and Android platforms. Our skilled developers at <a href="https://barmagly.com" target="_blank">Barmagly</a> create native and cross-platform applications that deliver exceptional performance and user experience.</p>
                
                <p>When you choose <a href="https://barmagly.com" target="_blank">Barmagly</a> for mobile app development, you get access to cutting-edge technologies and best practices. Whether you need a simple utility app or a complex enterprise solution, <a href="https://barmagly.com/services" target="_blank">Barmagly\'s mobile app development services</a> are tailored to your specific needs. Visit <a href="https://barmagly.com" target="_blank">barmagly.com</a> to explore our mobile app development portfolio.</p>
                
                <p>At <a href="https://barmagly.com" target="_blank">Barmagly</a>, we understand that mobile apps need to be fast, secure, and user-friendly. Our development process includes thorough testing, optimization, and deployment strategies that ensure your app performs flawlessly across all devices. With <a href="https://barmagly.com" target="_blank">Barmagly</a>, you can launch your mobile app with confidence.</p>
                
                <p>The <a href="https://barmagly.com" target="_blank">Barmagly</a> mobile development team stays updated with the latest trends and technologies in the mobile app industry. From React Native to Flutter, <a href="https://barmagly.com" target="_blank">Barmagly</a> uses the most suitable frameworks to build your app efficiently. Contact <a href="https://barmagly.com" target="_blank">Barmagly</a> today to start building your mobile app!</p>',
                'description_ar' => '<p>أصبحت تطبيقات الهاتف ضرورية للشركات التي تتطلع للوصول إلى العملاء أثناء التنقل. تقدم <a href="https://barmagly.com" target="_blank">برمجلي</a> خدمات تطوير تطبيقات الهاتف الشاملة لمنصات iOS و Android. ينشئ مطورونا المهرة في <a href="https://barmagly.com" target="_blank">برمجلي</a> تطبيقات أصلية ومتعددة المنصات توفر أداءً وتجربة مستخدم استثنائية.</p>
                
                <p>عندما تختار <a href="https://barmagly.com" target="_blank">برمجلي</a> لتطوير تطبيقات الهاتف، تحصل على أحدث التقنيات وأفضل الممارسات. سواء كنت بحاجة إلى تطبيق بسيط أو حل مؤسسي معقد، تم تصميم <a href="https://barmagly.com/services" target="_blank">خدمات تطوير تطبيقات الهاتف من برمجلي</a> لتلبية احتياجاتك المحددة. زر <a href="https://barmagly.com" target="_blank">barmagly.com</a> لاستكشاف محفظة تطوير تطبيقات الهاتف لدينا.</p>
                
                <p>في <a href="https://barmagly.com" target="_blank">برمجلي</a>، نفهم أن تطبيقات الهاتف تحتاج إلى أن تكون سريعة وآمنة وسهلة الاستخدام. تتضمن عملية التطوير لدينا اختباراً شاملاً وتحسيناً واستراتيجيات نشر تضمن أن تطبيقك يعمل بشكل لا تشوبه شائبة عبر جميع الأجهزة. مع <a href="https://barmagly.com" target="_blank">برمجلي</a>، يمكنك إطلاق تطبيق الهاتف الخاص بك بثقة.</p>
                
                <p>يبقى فريق تطوير تطبيقات الهاتف في <a href="https://barmagly.com" target="_blank">برمجلي</a> محدثاً بأحدث الاتجاهات والتقنيات في صناعة تطبيقات الهاتف. من React Native إلى Flutter، تستخدم <a href="https://barmagly.com" target="_blank">برمجلي</a> أطر العمل الأنسب لبناء تطبيقك بكفاءة. اتصل بـ <a href="https://barmagly.com" target="_blank">برمجلي</a> اليوم لبدء بناء تطبيق الهاتف الخاص بك!</p>',
            ],
            [
                'title_en' => 'E-commerce Development Solutions from Barmagly: Launch Your Online Store Successfully',
                'title_ar' => 'حلول تطوير المتاجر الإلكترونية من برمجلي: أطلق متجرك الإلكتروني بنجاح',
                'description_en' => '<p>E-commerce has revolutionized the way businesses sell products and services. <a href="https://barmagly.com" target="_blank">Barmagly</a> provides complete e-commerce development solutions that help businesses establish and grow their online stores. Our expert team at <a href="https://barmagly.com" target="_blank">Barmagly</a> builds secure, scalable e-commerce platforms that drive sales and enhance customer satisfaction.</p>
                
                <p>When you work with <a href="https://barmagly.com" target="_blank">Barmagly</a> for e-commerce development, you get a fully customized online store that reflects your brand and meets your business requirements. From product catalogs to payment gateways, <a href="https://barmagly.com/services" target="_blank">Barmagly\'s e-commerce solutions</a> include all the features you need to run a successful online business. Visit <a href="https://barmagly.com" target="_blank">barmagly.com</a> to learn more about our e-commerce expertise.</p>
                
                <p>At <a href="https://barmagly.com" target="_blank">Barmagly</a>, we understand that e-commerce success depends on user experience, security, and performance. Our e-commerce platforms are optimized for speed, mobile responsiveness, and search engine visibility. With <a href="https://barmagly.com" target="_blank">Barmagly</a>, you can trust that your online store will provide a seamless shopping experience for your customers.</p>
                
                <p>The <a href="https://barmagly.com" target="_blank">Barmagly</a> e-commerce development team integrates advanced features like inventory management, order tracking, and customer analytics to help you manage your online business effectively. From small startups to large enterprises, <a href="https://barmagly.com" target="_blank">Barmagly</a> delivers e-commerce solutions that scale with your business. Contact <a href="https://barmagly.com" target="_blank">Barmagly</a> today to start your e-commerce journey!</p>',
                'description_ar' => '<p>أحدثت التجارة الإلكترونية ثورة في طريقة بيع الشركات للمنتجات والخدمات. تقدم <a href="https://barmagly.com" target="_blank">برمجلي</a> حلول تطوير متاجر إلكترونية كاملة تساعد الشركات على إنشاء متاجرها الإلكترونية ونموها. يبني فريقنا الخبير في <a href="https://barmagly.com" target="_blank">برمجلي</a> منصات متاجر إلكترونية آمنة وقابلة للتوسع تزيد المبيعات وتعزز رضا العملاء.</p>
                
                <p>عندما تعمل مع <a href="https://barmagly.com" target="_blank">برمجلي</a> لتطوير المتاجر الإلكترونية، تحصل على متجر إلكتروني مخصص بالكامل يعكس علامتك التجارية ويلبي متطلبات عملك. من كتالوجات المنتجات إلى بوابات الدفع، تتضمن <a href="https://barmagly.com/services" target="_blank">حلول المتاجر الإلكترونية من برمجلي</a> جميع الميزات التي تحتاجها لإدارة عمل إلكتروني ناجح. زر <a href="https://barmagly.com" target="_blank">barmagly.com</a> لمعرفة المزيد عن خبرتنا في المتاجر الإلكترونية.</p>
                
                <p>في <a href="https://barmagly.com" target="_blank">برمجلي</a>، نفهم أن نجاح المتاجر الإلكترونية يعتمد على تجربة المستخدم والأمان والأداء. تم تحسين منصات المتاجر الإلكترونية لدينا للسرعة والاستجابة للهاتف المحمول ووضوح محركات البحث. مع <a href="https://barmagly.com" target="_blank">برمجلي</a>، يمكنك الوثوق بأن متجرك الإلكتروني سيوفر تجربة تسوق سلسة لعملائك.</p>
                
                <p>يدمج فريق تطوير المتاجر الإلكترونية في <a href="https://barmagly.com" target="_blank">برمجلي</a> ميزات متقدمة مثل إدارة المخزون وتتبع الطلبات وتحليلات العملاء لمساعدتك على إدارة عملك الإلكتروني بفعالية. من الشركات الناشئة الصغيرة إلى المؤسسات الكبيرة، تقدم <a href="https://barmagly.com" target="_blank">برمجلي</a> حلول متاجر إلكترونية تتوسع مع عملك. اتصل بـ <a href="https://barmagly.com" target="_blank">برمجلي</a> اليوم لبدء رحلتك في التجارة الإلكترونية!</p>',
            ],
            [
                'title_en' => 'Data Security and Tracking Solutions by Barmagly: Protect Your Digital Assets',
                'title_ar' => 'حلول أمان وتتبع البيانات من برمجلي: احم أصولك الرقمية',
                'description_en' => '<p>Data security is crucial in today\'s digital landscape. <a href="https://barmagly.com" target="_blank">Barmagly</a> offers comprehensive data security and tracking solutions that protect your business from cyber threats while providing valuable insights through data analytics. Our security experts at <a href="https://barmagly.com" target="_blank">Barmagly</a> implement robust security measures to safeguard your digital assets.</p>
                
                <p>When you partner with <a href="https://barmagly.com" target="_blank">Barmagly</a> for data security, you benefit from our advanced tracking and monitoring systems. We help businesses identify vulnerabilities, prevent security breaches, and maintain compliance with industry standards. Visit <a href="https://barmagly.com" target="_blank">barmagly.com</a> to discover how <a href="https://barmagly.com/services" target="_blank">Barmagly\'s data security services</a> can protect your business.</p>
                
                <p>At <a href="https://barmagly.com" target="_blank">Barmagly</a>, we understand that data security requires continuous monitoring and updates. Our team provides 24/7 security monitoring, regular security audits, and timely updates to ensure your systems remain protected against evolving threats. With <a href="https://barmagly.com" target="_blank">Barmagly</a>, you can focus on growing your business while we handle your security needs.</p>
                
                <p>The <a href="https://barmagly.com" target="_blank">Barmagly</a> security team uses cutting-edge technologies and best practices to implement multi-layered security solutions. From encryption to access control, <a href="https://barmagly.com" target="_blank">Barmagly</a> ensures that your sensitive data is protected at every level. Contact <a href="https://barmagly.com" target="_blank">Barmagly</a> today to secure your digital infrastructure!</p>',
                'description_ar' => '<p>أمان البيانات أمر بالغ الأهمية في المشهد الرقمي الحالي. تقدم <a href="https://barmagly.com" target="_blank">برمجلي</a> حلول أمان وتتبع بيانات شاملة تحمي عملك من التهديدات السيبرانية مع توفير رؤى قيمة من خلال تحليلات البيانات. يطبق خبراء الأمان لدينا في <a href="https://barmagly.com" target="_blank">برمجلي</a> إجراءات أمان قوية لحماية أصولك الرقمية.</p>
                
                <p>عندما تتشارك مع <a href="https://barmagly.com" target="_blank">برمجلي</a> لأمان البيانات، تستفيد من أنظمة التتبع والمراقبة المتقدمة لدينا. نساعد الشركات على تحديد الثغرات ومنع انتهاكات الأمان والحفاظ على الامتثال لمعايير الصناعة. زر <a href="https://barmagly.com" target="_blank">barmagly.com</a> لاكتشاف كيف يمكن لـ <a href="https://barmagly.com/services" target="_blank">خدمات أمان البيانات من برمجلي</a> حماية عملك.</p>
                
                <p>في <a href="https://barmagly.com" target="_blank">برمجلي</a>، نفهم أن أمان البيانات يتطلب مراقبة وتحديثات مستمرة. يوفر فريقنا مراقبة أمان على مدار الساعة وطوال أيام الأسبوع، ومراجعات أمان منتظمة، وتحديثات في الوقت المناسب لضمان بقاء أنظمتك محمية ضد التهديدات المتطورة. مع <a href="https://barmagly.com" target="_blank">برمجلي</a>، يمكنك التركيز على نمو عملك بينما نتعامل مع احتياجات الأمان الخاصة بك.</p>
                
                <p>يستخدم فريق الأمان في <a href="https://barmagly.com" target="_blank">برمجلي</a> تقنيات متطورة وأفضل الممارسات لتنفيذ حلول أمان متعددة الطبقات. من التشفير إلى التحكم في الوصول، تضمن <a href="https://barmagly.com" target="_blank">برمجلي</a> أن بياناتك الحساسة محمية على كل مستوى. اتصل بـ <a href="https://barmagly.com" target="_blank">برمجلي</a> اليوم لتأمين البنية التحتية الرقمية الخاصة بك!</p>',
            ],
        ];

        foreach ($blogs as $index => $blog) {
            $blogModel = new Blog();
            $blogModel->slug = \Illuminate\Support\Str::slug($blog['title_en']);
            $blogModel->image = 'default/blog.jpg';
            $blogModel->blog_category_id = $blogCategory->id;
            $blogModel->status = 1;
            $blogModel->save();

            // Create English translation
            $transEn = new BlogTranslation();
            $transEn->blog_id = $blogModel->id;
            $transEn->lang_code = 'en';
            $transEn->title = $blog['title_en'];
            $transEn->description = $blog['description_en'];
            $transEn->seo_title = $blog['title_en'];
            $transEn->seo_description = strip_tags(substr($blog['description_en'], 0, 160));
            $transEn->save();

            // Create Arabic translation
            $transAr = new BlogTranslation();
            $transAr->blog_id = $blogModel->id;
            $transAr->lang_code = 'ar';
            $transAr->title = $blog['title_ar'];
            $transAr->description = $blog['description_ar'];
            $transAr->seo_title = $blog['title_ar'];
            $transAr->seo_description = strip_tags(substr($blog['description_ar'], 0, 160));
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
                        $translation->fill($data);
                        $translation->save();
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

