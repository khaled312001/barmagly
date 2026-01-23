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
use Modules\Category\Entities\CategoryTranslation;
use Modules\FAQ\App\Models\Faq;
use Modules\FAQ\App\Models\FaqTranslation;
use Modules\Page\App\Models\PrivacyPolicy;
use Modules\Page\App\Models\TermAndCondition;
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
        $this->updatePrivacyPolicy();
        $this->updateCategories();
        $this->updateTermsAndConditions();
        
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
                'question_en' => 'What services does Barmagly provide?',
                'question_ar' => 'ما هي الخدمات التي تقدمها برمجلي؟',
                'answer_en' => 'Barmagly specializes in web development, website design, and UI/UX design services. We offer custom web applications, responsive website designs, mobile app development, e-commerce solutions, and comprehensive digital transformation services.',
                'answer_ar' => 'تتخصص برمجلي في تطوير المواقع وتصميمها وخدمات تصميم UI/UX. نقدم تطبيقات ويب مخصصة وتصاميم مواقع متجاوبة وتطوير تطبيقات الهاتف وحلول المتاجر الإلكترونية وخدمات التحول الرقمي الشاملة.',
            ],
            [
                'question_en' => 'How long does it take to complete a web development project?',
                'question_ar' => 'كم يستغرق إكمال مشروع تطوير موقع؟',
                'answer_en' => 'Project timelines vary based on complexity and requirements. A simple website typically takes 2-4 weeks, while complex web applications may take 2-6 months. We provide detailed timelines during the initial consultation and keep you updated throughout the development process.',
                'answer_ar' => 'تختلف المدد الزمنية للمشاريع حسب التعقيد والمتطلبات. الموقع البسيط عادة ما يستغرق 2-4 أسابيع، بينما التطبيقات الويب المعقدة قد تستغرق 2-6 أشهر. نقدم جداول زمنية مفصلة خلال الاستشارة الأولية ونبقيك على اطلاع طوال عملية التطوير.',
            ],
            [
                'question_en' => 'Do you provide ongoing support and maintenance?',
                'question_ar' => 'هل تقدمون دعم وصيانة مستمرة؟',
                'answer_en' => 'Yes, we offer comprehensive support and maintenance services for all our projects. This includes regular updates, security patches, bug fixes, and technical support. We provide flexible maintenance packages tailored to your needs.',
                'answer_ar' => 'نعم، نقدم خدمات دعم وصيانة شاملة لجميع مشاريعنا. يشمل ذلك التحديثات المنتظمة وترقيعات الأمان وإصلاح الأخطاء والدعم الفني. نقدم حزم صيانة مرنة مصممة خصيصاً لاحتياجاتك.',
            ],
            [
                'question_en' => 'What technologies and frameworks do you use?',
                'question_ar' => 'ما هي التقنيات والأطر التي تستخدمونها؟',
                'answer_en' => 'We use modern technologies and frameworks including Laravel, React, Vue.js, Node.js, PHP, JavaScript, and various CMS platforms. Our technology stack is chosen based on project requirements to ensure optimal performance, scalability, and security.',
                'answer_ar' => 'نستخدم تقنيات وأطر حديثة تشمل Laravel و React و Vue.js و Node.js و PHP و JavaScript ومنصات CMS متنوعة. يتم اختيار مجموعة التقنيات لدينا بناءً على متطلبات المشروع لضمان الأداء الأمثل والقابلية للتوسع والأمان.',
            ],
            [
                'question_en' => 'How can I get a quote for my project?',
                'question_ar' => 'كيف يمكنني الحصول على عرض سعر لمشروعي؟',
                'answer_en' => 'You can contact us through our website contact form, email us at info@barmagly.com, or call us at +201010254819. We offer free consultations where we discuss your project requirements and provide detailed quotes based on your needs.',
                'answer_ar' => 'يمكنك التواصل معنا من خلال نموذج الاتصال على موقعنا أو إرسال بريد إلكتروني إلى info@barmagly.com أو الاتصال بنا على +201010254819. نقدم استشارات مجانية حيث نناقش متطلبات مشروعك ونقدم عروض أسعار مفصلة بناءً على احتياجاتك.',
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

    /**
     * Update Privacy Policy
     */
    private function updatePrivacyPolicy(): void
    {
        $this->command->info('📝 Updating Privacy Policy...');
        
        $privacyPolicyEn = PrivacyPolicy::where('lang_code', 'en')->first();
        if (!$privacyPolicyEn) {
            $privacyPolicyEn = new PrivacyPolicy();
            $privacyPolicyEn->lang_code = 'en';
        }
        
        $privacyPolicyEn->description = '<div class="legal-content">
    <h2>Privacy Policy</h2>
    <p><strong>Last Updated:</strong> ' . date('Y-m-d') . '</p>
    
    <h3>1. Introduction</h3>
    <p>Welcome to Barmagly. We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our services.</p>
    
    <h3>2. Information We Collect</h3>
    <p>We may collect the following types of information:</p>
    <ul>
        <li><strong>Personal Information:</strong> Name, email address, phone number, and other contact details you provide when contacting us or requesting our services.</li>
        <li><strong>Project Information:</strong> Details about your project requirements, business information, and any other information you share with us during consultations.</li>
        <li><strong>Technical Information:</strong> IP address, browser type, device information, and usage data collected automatically when you visit our website.</li>
    </ul>
    
    <h3>3. How We Use Your Information</h3>
    <p>We use the collected information for the following purposes:</p>
    <ul>
        <li>To provide and improve our web development, design, and UI/UX services</li>
        <li>To communicate with you about your projects and respond to your inquiries</li>
        <li>To send you updates, newsletters, and marketing communications (with your consent)</li>
        <li>To analyze website usage and improve user experience</li>
        <li>To comply with legal obligations and protect our rights</li>
    </ul>
    
    <h3>4. Data Security</h3>
    <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the internet is 100% secure.</p>
    
    <h3>5. Data Sharing and Disclosure</h3>
    <p>We do not sell, trade, or rent your personal information to third parties. We may share your information only in the following circumstances:</p>
    <ul>
        <li>With your explicit consent</li>
        <li>To comply with legal obligations or court orders</li>
        <li>To protect our rights, property, or safety</li>
        <li>With trusted service providers who assist us in operating our business (under strict confidentiality agreements)</li>
    </ul>
    
    <h3>6. Your Rights</h3>
    <p>You have the right to:</p>
    <ul>
        <li>Access and receive a copy of your personal data</li>
        <li>Request correction of inaccurate information</li>
        <li>Request deletion of your personal data</li>
        <li>Object to processing of your personal data</li>
        <li>Withdraw consent at any time</li>
    </ul>
    
    <h3>7. Cookies and Tracking Technologies</h3>
    <p>Our website uses cookies and similar tracking technologies to enhance your browsing experience. You can control cookie preferences through your browser settings.</p>
    
    <h3>8. Third-Party Links</h3>
    <p>Our website may contain links to third-party websites. We are not responsible for the privacy practices of these external sites. We encourage you to review their privacy policies.</p>
    
    <h3>9. Children\'s Privacy</h3>
    <p>Our services are not directed to individuals under the age of 18. We do not knowingly collect personal information from children.</p>
    
    <h3>10. Changes to This Privacy Policy</h3>
    <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last Updated" date.</p>
    
    <h3>11. Contact Us</h3>
    <p>If you have any questions about this Privacy Policy or wish to exercise your rights, please contact us:</p>
    <ul>
        <li><strong>Email:</strong> info@barmagly.com</li>
        <li><strong>Phone:</strong> +201010254819</li>
        <li><strong>Address:</strong> Qena-Egypt</li>
    </ul>
</div>';
        $privacyPolicyEn->save();
        
        $privacyPolicyAr = PrivacyPolicy::where('lang_code', 'ar')->first();
        if (!$privacyPolicyAr) {
            $privacyPolicyAr = new PrivacyPolicy();
            $privacyPolicyAr->lang_code = 'ar';
        }
        
        $privacyPolicyAr->description = '<div class="legal-content">
    <h2>سياسة الخصوصية</h2>
    <p><strong>آخر تحديث:</strong> ' . date('Y-m-d') . '</p>
    
    <h3>1. مقدمة</h3>
    <p>مرحباً بك في برمجلي. نحن ملتزمون بحماية خصوصيتك وضمان أمان معلوماتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع واستخدام وكشف وحماية معلوماتك عند زيارة موقعنا أو استخدام خدماتنا.</p>
    
    <h3>2. المعلومات التي نجمعها</h3>
    <p>قد نجمع الأنواع التالية من المعلومات:</p>
    <ul>
        <li><strong>المعلومات الشخصية:</strong> الاسم وعنوان البريد الإلكتروني ورقم الهاتف وتفاصيل الاتصال الأخرى التي تقدمها عند التواصل معنا أو طلب خدماتنا.</li>
        <li><strong>معلومات المشروع:</strong> تفاصيل حول متطلبات مشروعك ومعلومات الأعمال وأي معلومات أخرى تشاركها معنا أثناء الاستشارات.</li>
        <li><strong>المعلومات التقنية:</strong> عنوان IP ونوع المتصفح ومعلومات الجهاز وبيانات الاستخدام التي يتم جمعها تلقائياً عند زيارة موقعنا.</li>
    </ul>
    
    <h3>3. كيفية استخدامنا لمعلوماتك</h3>
    <p>نستخدم المعلومات المجمعة للأغراض التالية:</p>
    <ul>
        <li>لتقديم وتحسين خدماتنا في تطوير المواقع والتصميم وUI/UX</li>
        <li>للتواصل معك حول مشاريعك والرد على استفساراتك</li>
        <li>لإرسال التحديثات والنشرات الإخبارية والاتصالات التسويقية (بموافقتك)</li>
        <li>لتحليل استخدام الموقع وتحسين تجربة المستخدم</li>
        <li>للامتثال للالتزامات القانونية وحماية حقوقنا</li>
    </ul>
    
    <h3>4. أمان البيانات</h3>
    <p>نطبق التدابير التقنية والتنظيمية المناسبة لحماية معلوماتك الشخصية من الوصول غير المصرح به أو التعديل أو الكشف أو التدمير. ومع ذلك، لا توجد طريقة نقل عبر الإنترنت آمنة بنسبة 100%.</p>
    
    <h3>5. مشاركة البيانات والكشف عنها</h3>
    <p>لا نبيع أو نتاجر أو نؤجر معلوماتك الشخصية لأطراف ثالثة. قد نشارك معلوماتك فقط في الحالات التالية:</p>
    <ul>
        <li>بموافقتك الصريحة</li>
        <li>للامتثال للالتزامات القانونية أو أوامر المحكمة</li>
        <li>لحماية حقوقنا أو ممتلكاتنا أو سلامتنا</li>
        <li>مع مقدمي الخدمات الموثوقين الذين يساعدوننا في تشغيل أعمالنا (بموجب اتفاقيات سرية صارمة)</li>
    </ul>
    
    <h3>6. حقوقك</h3>
    <p>لديك الحق في:</p>
    <ul>
        <li>الوصول والحصول على نسخة من بياناتك الشخصية</li>
        <li>طلب تصحيح المعلومات غير الدقيقة</li>
        <li>طلب حذف بياناتك الشخصية</li>
        <li>الاعتراض على معالجة بياناتك الشخصية</li>
        <li>سحب الموافقة في أي وقت</li>
    </ul>
    
    <h3>7. ملفات تعريف الارتباط وتقنيات التتبع</h3>
    <p>يستخدم موقعنا ملفات تعريف الارتباط وتقنيات تتبع مماثلة لتحسين تجربة التصفح لديك. يمكنك التحكم في تفضيلات ملفات تعريف الارتباط من خلال إعدادات المتصفح.</p>
    
    <h3>8. روابط الطرف الثالث</h3>
    <p>قد يحتوي موقعنا على روابط لمواقع طرف ثالث. نحن لسنا مسؤولين عن ممارسات الخصوصية لهذه المواقع الخارجية. نشجعك على مراجعة سياسات الخصوصية الخاصة بهم.</p>
    
    <h3>9. خصوصية الأطفال</h3>
    <p>خدماتنا ليست موجهة للأفراد دون سن 18 عاماً. لا نجمع معلومات شخصية من الأطفال عن قصد.</p>
    
    <h3>10. التغييرات على سياسة الخصوصية هذه</h3>
    <p>قد نحدث سياسة الخصوصية هذه من وقت لآخر. سنخطرك بأي تغييرات عن طريق نشر السياسة الجديدة على هذه الصفحة وتحديث تاريخ "آخر تحديث".</p>
    
    <h3>11. اتصل بنا</h3>
    <p>إذا كان لديك أي أسئلة حول سياسة الخصوصية هذه أو ترغب في ممارسة حقوقك، يرجى الاتصال بنا:</p>
    <ul>
        <li><strong>البريد الإلكتروني:</strong> info@barmagly.com</li>
        <li><strong>الهاتف:</strong> +201010254819</li>
        <li><strong>العنوان:</strong> قنا-مصر</li>
    </ul>
</div>';
        $privacyPolicyAr->save();
        
        $this->command->info('✅ Privacy Policy updated!');
    }

    /**
     * Update Terms and Conditions
     */
    private function updateTermsAndConditions(): void
    {
        $this->command->info('📝 Updating Terms and Conditions...');
        
        $termsEn = TermAndCondition::where('lang_code', 'en')->first();
        if (!$termsEn) {
            $termsEn = new TermAndCondition();
            $termsEn->lang_code = 'en';
        }
        
        $termsEn->description = '<div class="legal-content">
    <h2>Terms and Conditions</h2>
    <p><strong>Last Updated:</strong> ' . date('Y-m-d') . '</p>
    
    <h3>1. Acceptance of Terms</h3>
    <p>By accessing and using Barmagly\'s website and services, you accept and agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use our services.</p>
    
    <h3>2. Services Description</h3>
    <p>Barmagly provides professional web development, website design, UI/UX design, mobile app development, e-commerce solutions, and related digital services. All services are provided subject to these terms and any specific agreements entered into for individual projects.</p>
    
    <h3>3. Project Agreements</h3>
    <p>Each project will be governed by a separate project agreement that outlines:</p>
    <ul>
        <li>Project scope, deliverables, and timeline</li>
        <li>Pricing and payment terms</li>
        <li>Intellectual property rights</li>
        <li>Warranty and support terms</li>
    </ul>
    <p>The project agreement will take precedence over these general terms in case of any conflict.</p>
    
    <h3>4. Payment Terms</h3>
    <p>Payment terms will be specified in each project agreement. Generally:</p>
    <ul>
        <li>An initial deposit may be required to commence work</li>
        <li>Progress payments may be scheduled based on project milestones</li>
        <li>Final payment is due upon project completion and acceptance</li>
        <li>All prices are in the currency specified in the project agreement</li>
    </ul>
    
    <h3>5. Intellectual Property Rights</h3>
    <p>Upon full payment, ownership of the custom-developed work will transfer to the client, subject to:</p>
    <ul>
        <li>Barmagly retaining rights to use the work in portfolios and marketing materials</li>
        <li>Third-party components and libraries remaining subject to their respective licenses</li>
        <li>Pre-existing Barmagly intellectual property remaining with Barmagly</li>
    </ul>
    
    <h3>6. Client Responsibilities</h3>
    <p>Clients are responsible for:</p>
    <ul>
        <li>Providing accurate and complete project requirements</li>
        <li>Timely feedback and approvals during the development process</li>
        <li>Providing necessary materials, content, and access credentials</li>
        <li>Ensuring compliance with applicable laws and regulations</li>
    </ul>
    
    <h3>7. Project Revisions and Changes</h3>
    <p>Minor revisions are typically included in the project scope. Significant changes or additions may result in additional charges and timeline adjustments, which will be discussed and agreed upon before implementation.</p>
    
    <h3>8. Project Delays</h3>
    <p>Barmagly will make reasonable efforts to meet project deadlines. However, delays may occur due to:</p>
    <ul>
        <li>Client delays in providing feedback, approvals, or materials</li>
        <li>Unforeseen technical challenges</li>
        <li>Force majeure events</li>
    </ul>
    <p>Timeline adjustments will be communicated promptly.</p>
    
    <h3>9. Warranty and Support</h3>
    <p>Barmagly provides a warranty period for completed projects as specified in the project agreement. During this period, we will fix any bugs or defects that are our responsibility at no additional cost. Support beyond the warranty period may be subject to separate maintenance agreements.</p>
    
    <h3>10. Limitation of Liability</h3>
    <p>Barmagly\'s liability is limited to the total project fee paid by the client. We are not liable for indirect, incidental, or consequential damages arising from the use of our services.</p>
    
    <h3>11. Confidentiality</h3>
    <p>Both parties agree to maintain confidentiality of proprietary information shared during the project. Barmagly will not disclose client information or project details to third parties without consent, except as required by law.</p>
    
    <h3>12. Termination</h3>
    <p>Either party may terminate a project agreement with written notice. Upon termination:</p>
    <ul>
        <li>Payment is due for all work completed up to the termination date</li>
        <li>Client receives all deliverables completed to date</li>
        <li>Confidentiality obligations continue to apply</li>
    </ul>
    
    <h3>13. Dispute Resolution</h3>
    <p>Any disputes will first be addressed through good faith negotiations. If resolution cannot be reached, disputes will be resolved through appropriate legal channels in accordance with Egyptian law.</p>
    
    <h3>14. Modifications to Terms</h3>
    <p>Barmagly reserves the right to modify these terms at any time. Continued use of our services after changes constitutes acceptance of the modified terms.</p>
    
    <h3>15. Contact Information</h3>
    <p>For questions about these Terms and Conditions, please contact us:</p>
    <ul>
        <li><strong>Email:</strong> info@barmagly.com</li>
        <li><strong>Phone:</strong> +201010254819</li>
        <li><strong>Address:</strong> Qena-Egypt</li>
    </ul>
</div>';
        $termsEn->save();
        
        $termsAr = TermAndCondition::where('lang_code', 'ar')->first();
        if (!$termsAr) {
            $termsAr = new TermAndCondition();
            $termsAr->lang_code = 'ar';
        }
        
        $termsAr->description = '<div class="legal-content">
    <h2>الشروط والأحكام</h2>
    <p><strong>آخر تحديث:</strong> ' . date('Y-m-d') . '</p>
    
    <h3>1. قبول الشروط</h3>
    <p>من خلال الوصول إلى موقع برمجلي واستخدامه وخدماته، فإنك تقبل وتوافق على الالتزام بهذه الشروط والأحكام. إذا كنت لا توافق على أي جزء من هذه الشروط، يجب ألا تستخدم خدماتنا.</p>
    
    <h3>2. وصف الخدمات</h3>
    <p>تقدم برمجلي خدمات تطوير المواقع الاحترافية وتصميمها وتصميم UI/UX وتطوير تطبيقات الهاتف وحلول المتاجر الإلكترونية والخدمات الرقمية ذات الصلة. يتم تقديم جميع الخدمات وفقاً لهذه الشروط وأي اتفاقيات محددة يتم إبرامها للمشاريع الفردية.</p>
    
    <h3>3. اتفاقيات المشروع</h3>
    <p>سيتم حكم كل مشروع بموجب اتفاقية مشروع منفصلة تحدد:</p>
    <ul>
        <li>نطاق المشروع والنتائج والجدول الزمني</li>
        <li>التسعير وشروط الدفع</li>
        <li>حقوق الملكية الفكرية</li>
        <li>شروط الضمان والدعم</li>
    </ul>
    <p>ستأخذ اتفاقية المشروع الأولوية على هذه الشروط العامة في حالة وجود أي تعارض.</p>
    
    <h3>4. شروط الدفع</h3>
    <p>سيتم تحديد شروط الدفع في كل اتفاقية مشروع. بشكل عام:</p>
    <ul>
        <li>قد يكون مطلوباً دفعة أولية لبدء العمل</li>
        <li>قد يتم جدولة مدفوعات التقدم بناءً على معالم المشروع</li>
        <li>الدفع النهائي مستحق عند اكتمال المشروع وقبوله</li>
        <li>جميع الأسعار بالعملة المحددة في اتفاقية المشروع</li>
    </ul>
    
    <h3>5. حقوق الملكية الفكرية</h3>
    <p>عند الدفع الكامل، سينتقل ملكية العمل المطور خصيصاً إلى العميل، مع مراعاة:</p>
    <ul>
        <li>احتفاظ برمجلي بحقوق استخدام العمل في المحافظ والمواد التسويقية</li>
        <li>بقاء مكونات ومكتبات الطرف الثالث خاضعة لتراخيصها الخاصة</li>
        <li>بقاء الملكية الفكرية الموجودة مسبقاً لبرمجلي مع برمجلي</li>
    </ul>
    
    <h3>6. مسؤوليات العميل</h3>
    <p>العملاء مسؤولون عن:</p>
    <ul>
        <li>توفير متطلبات المشروع الدقيقة والكاملة</li>
        <li>الملاحظات والموافقات في الوقت المناسب أثناء عملية التطوير</li>
        <li>توفير المواد والمحتوى وأوراق الاعتماد اللازمة</li>
        <li>ضمان الامتثال للقوانين واللوائح المعمول بها</li>
    </ul>
    
    <h3>7. مراجعات وتغييرات المشروع</h3>
    <p>عادة ما يتم تضمين المراجعات البسيطة في نطاق المشروع. قد تؤدي التغييرات أو الإضافات الكبيرة إلى رسوم إضافية وتعديلات على الجدول الزمني، والتي سيتم مناقشتها والاتفاق عليها قبل التنفيذ.</p>
    
    <h3>8. تأخيرات المشروع</h3>
    <p>ستبذل برمجلي جهوداً معقولة للوفاء بالمواعيد النهائية للمشروع. ومع ذلك، قد تحدث تأخيرات بسبب:</p>
    <ul>
        <li>تأخيرات العميل في تقديم الملاحظات أو الموافقات أو المواد</li>
        <li>التحديات التقنية غير المتوقعة</li>
        <li>أحداث القوة القاهرة</li>
    </ul>
    <p>سيتم التواصل حول تعديلات الجدول الزمني على الفور.</p>
    
    <h3>9. الضمان والدعم</h3>
    <p>تقدم برمجلي فترة ضمان للمشاريع المكتملة كما هو محدد في اتفاقية المشروع. خلال هذه الفترة، سنقوم بإصلاح أي أخطاء أو عيوب هي من مسؤوليتنا دون تكلفة إضافية. قد يكون الدعم بعد فترة الضمان خاضعاً لاتفاقيات صيانة منفصلة.</p>
    
    <h3>10. الحد من المسؤولية</h3>
    <p>مسؤولية برمجلي محدودة بإجمالي رسوم المشروع المدفوعة من قبل العميل. نحن لسنا مسؤولين عن الأضرار غير المباشرة أو العرضية أو التبعية الناشئة عن استخدام خدماتنا.</p>
    
    <h3>11. السرية</h3>
    <p>يوافق الطرفان على الحفاظ على سرية المعلومات الخاصة المشتركة أثناء المشروع. لن تكشف برمجلي عن معلومات العميل أو تفاصيل المشروع لأطراف ثالثة دون موافقة، إلا كما هو مطلوب بموجب القانون.</p>
    
    <h3>12. الإنهاء</h3>
    <p>يجوز لأي من الطرفين إنهاء اتفاقية المشروع بإشعار كتابي. عند الإنهاء:</p>
    <ul>
        <li>الدفع مستحق لجميع العمل المكتمل حتى تاريخ الإنهاء</li>
        <li>يحصل العميل على جميع النتائج المكتملة حتى الآن</li>
        <li>تستمر التزامات السرية في التطبيق</li>
    </ul>
    
    <h3>13. حل النزاعات</h3>
    <p>سيتم معالجة أي نزاعات أولاً من خلال المفاوضات بحسن نية. إذا لم يتم التوصل إلى حل، سيتم حل النزاعات من خلال القنوات القانونية المناسبة وفقاً للقانون المصري.</p>
    
    <h3>14. تعديلات الشروط</h3>
    <p>تحتفظ برمجلي بالحق في تعديل هذه الشروط في أي وقت. الاستمرار في استخدام خدماتنا بعد التغييرات يشكل قبولاً للشروط المعدلة.</p>
    
    <h3>15. معلومات الاتصال</h3>
    <p>للأسئلة حول هذه الشروط والأحكام، يرجى الاتصال بنا:</p>
    <ul>
        <li><strong>البريد الإلكتروني:</strong> info@barmagly.com</li>
        <li><strong>الهاتف:</strong> +201010254819</li>
        <li><strong>العنوان:</strong> قنا-مصر</li>
    </ul>
</div>';
        $termsAr->save();
        
        $this->command->info('✅ Terms and Conditions updated!');
    }

    private function updateCategories(): void
    {
        $this->command->info('📝 Updating Categories...');
        
        // Define categories with translations
        $categories = [
            [
                'slug' => 'medical',
                'ar' => 'المجال الطبي',
                'en' => 'Medical',
                'hd' => 'Medical',
            ],
            [
                'slug' => 'educational',
                'ar' => 'التعليمي',
                'en' => 'Educational',
                'hd' => 'Educational',
            ],
            [
                'slug' => 'commercial',
                'ar' => 'التجاري',
                'en' => 'Commercial',
                'hd' => 'Commercial',
            ],
            [
                'slug' => 'startups',
                'ar' => 'الشركات الناشئة',
                'en' => 'Startups',
                'hd' => 'Startups',
            ],
            [
                'slug' => 'hotels',
                'ar' => 'الفنادق',
                'en' => 'Hotels',
                'hd' => 'Hotels',
            ],
            [
                'slug' => 'restaurants',
                'ar' => 'المطاعم',
                'en' => 'Restaurants',
                'hd' => 'Restaurants',
            ],
        ];
        
        foreach ($categories as $categoryData) {
            // Find or create category
            $category = Category::where('slug', $categoryData['slug'])->first();
            
            if (!$category) {
                $category = new Category();
                $category->slug = $categoryData['slug'];
                $category->status = 'enable';
                $category->save();
            }
            
            // Update translations for all languages
            $languages = ['ar', 'en', 'hd'];
            
            foreach ($languages as $lang) {
                $translation = CategoryTranslation::where('category_id', $category->id)
                    ->where('lang_code', $lang)
                    ->first();
                
                if (!$translation) {
                    $translation = new CategoryTranslation();
                    $translation->category_id = $category->id;
                    $translation->lang_code = $lang;
                }
                
                $translation->name = $categoryData[$lang];
                $translation->save();
            }
        }
        
        $this->command->info('✅ Categories updated!');
    }
}

