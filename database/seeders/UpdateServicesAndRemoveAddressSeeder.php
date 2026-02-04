<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Page\App\Models\Footer;
use Modules\Page\App\Models\ContactUs;
use Modules\Page\App\Models\ContactUsTranslation;
use Modules\Listing\Entities\Listing;
use Modules\Listing\Entities\ListingTranslation;
use Modules\Category\Entities\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateServicesAndRemoveAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Updates services with new professional services and removes Egypt address
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting services update and address removal...');
        
        $this->removeEgyptAddress();
        $this->deleteAllExistingServices();
        $this->createNewServices();
        
        $this->command->info('✅ Services updated and Egypt address removed!');
    }

    /**
     * Remove Egypt address from footer and contact us
     */
    private function removeEgyptAddress(): void
    {
        $this->command->info('📝 Removing Egypt address...');
        
        // Update Footer - remove address
        $footer = Footer::first();
        if ($footer) {
            $footer->address = '';
            $footer->save();
            $this->command->info('✅ Footer address removed!');
        }

        // Update Contact Us - remove address
        $contactUs = ContactUs::first();
        if ($contactUs) {
            // Update English translation
            $transEn = ContactUsTranslation::where('contact_us_id', $contactUs->id)
                ->where('lang_code', 'en')
                ->first();
            
            if ($transEn) {
                $transEn->address = '';
                $transEn->save();
            }

            // Update Arabic translation
            $transAr = ContactUsTranslation::where('contact_us_id', $contactUs->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if ($transAr) {
                $transAr->address = '';
                $transAr->save();
            }
            
            $this->command->info('✅ Contact Us address removed!');
        }
    }

    /**
     * Delete all existing services
     */
    private function deleteAllExistingServices(): void
    {
        $this->command->info('📝 Deleting all existing services...');
        
        // Delete all listing translations first
        ListingTranslation::query()->delete();
        
        // Delete all listings
        Listing::query()->delete();
        
        $this->command->info('✅ All existing services deleted!');
    }

    /**
     * Create new professional services
     */
    private function createNewServices(): void
    {
        $this->command->info('📝 Creating new professional services...');
        
        // Get or create a category
        $category = Category::where('status', 'enable')->first();
        if (!$category) {
            $category = new Category();
            $category->status = 'enable';
            $category->save();
        }

        $services = [
            [
                'slug' => 'web-design-development',
                'title_en' => 'Web Design & Development',
                'title_ar' => 'برمجة وتصميم مواقع',
                'description_en' => 'Professional website design and development services using the latest technologies. We create responsive, fast, and SEO-optimized websites tailored to your business needs. Our team specializes in Laravel, Vue.js, React, WordPress, and modern web technologies to deliver exceptional digital experiences.',
                'description_ar' => 'خدمات تصميم وتطوير المواقع الاحترافية باستخدام أحدث التقنيات. نقوم بإنشاء مواقع متجاوبة وسريعة ومحسنة لمحركات البحث مصممة خصيصاً لاحتياجات عملك. فريقنا متخصص في Laravel و Vue.js و React و WordPress والتقنيات الحديثة لتقديم تجارب رقمية استثنائية.',
                'short_description_en' => 'Professional web design & development with modern technologies',
                'short_description_ar' => 'تصميم وبرمجة مواقع احترافية بأحدث التقنيات',
            ],
            [
                'slug' => 'mobile-app-development',
                'title_en' => 'Mobile Applications',
                'title_ar' => 'موبايل',
                'description_en' => 'Native and cross-platform mobile app development for iOS and Android. We build high-performance mobile applications using React Native, Flutter, and native technologies. From concept to launch, we deliver mobile solutions that engage users and drive business growth.',
                'description_ar' => 'تطوير تطبيقات الهاتف الأصلية ومتعددة المنصات لـ iOS و Android. نبني تطبيقات هاتف عالية الأداء باستخدام React Native و Flutter والتقنيات الأصلية. من الفكرة إلى الإطلاق، نقدم حلول موبايل تجذب المستخدمين وتدفع نمو الأعمال.',
                'short_description_en' => 'iOS & Android mobile app development',
                'short_description_ar' => 'تطوير تطبيقات iOS و Android',
            ],
            [
                'slug' => 'digital-marketing',
                'title_en' => 'Digital Marketing',
                'title_ar' => 'تسويق',
                'description_en' => 'Comprehensive digital marketing services to grow your online presence. We offer SEO optimization, social media marketing, content marketing, email campaigns, and paid advertising. Our data-driven strategies help you reach your target audience and achieve measurable results.',
                'description_ar' => 'خدمات التسويق الرقمي الشاملة لتنمية وجودك على الإنترنت. نقدم تحسين محركات البحث، التسويق عبر وسائل التواصل الاجتماعي، تسويق المحتوى، حملات البريد الإلكتروني، والإعلانات المدفوعة. استراتيجياتنا المستندة إلى البيانات تساعدك على الوصول لجمهورك المستهدف وتحقيق نتائج قابلة للقياس.',
                'short_description_en' => 'SEO, social media & digital campaigns',
                'short_description_ar' => 'تحسين محركات البحث والتسويق الرقمي',
            ],
            [
                'slug' => 'sales-crm-solutions',
                'title_en' => 'Sales & CRM Solutions',
                'title_ar' => 'سيلز',
                'description_en' => 'Custom sales and CRM solutions to streamline your business processes. We develop and integrate CRM systems, sales automation tools, and customer management platforms. Boost your sales team productivity and improve customer relationships with our tailored solutions.',
                'description_ar' => 'حلول المبيعات وإدارة علاقات العملاء المخصصة لتبسيط عمليات أعمالك. نقوم بتطوير ودمج أنظمة CRM وأدوات أتمتة المبيعات ومنصات إدارة العملاء. عزز إنتاجية فريق المبيعات وحسّن علاقات العملاء مع حلولنا المخصصة.',
                'short_description_en' => 'CRM systems & sales automation',
                'short_description_ar' => 'أنظمة CRM وأتمتة المبيعات',
            ],
            [
                'slug' => 'web-hosting-domains',
                'title_en' => 'Web Hosting & Domains',
                'title_ar' => 'استضافة مواقع ودومينات',
                'description_en' => 'Reliable web hosting services and domain registration. We offer secure, fast, and scalable hosting solutions for all types of websites. From shared hosting to dedicated servers and cloud solutions, we ensure your website is always online with 99.9% uptime guarantee.',
                'description_ar' => 'خدمات استضافة مواقع موثوقة وتسجيل دومينات. نقدم حلول استضافة آمنة وسريعة وقابلة للتوسع لجميع أنواع المواقع. من الاستضافة المشتركة إلى السيرفرات المخصصة والحلول السحابية، نضمن بقاء موقعك متاحاً دائماً مع ضمان 99.9% وقت التشغيل.',
                'short_description_en' => 'Secure hosting & domain registration',
                'short_description_ar' => 'استضافة آمنة وتسجيل دومينات',
            ],
        ];

        foreach ($services as $index => $service) {
            // Create the listing
            $listing = new Listing();
            $listing->category_id = $category->id;
            $listing->sub_category_id = 0;
            $listing->thumb_image = 'default/service.jpg';
            $listing->slug = $service['slug'];
            
            // Set price fields only if they exist
            if (DB::getSchemaBuilder()->hasColumn('listings', 'regular_price')) {
                $listing->regular_price = 0;
            }
            if (DB::getSchemaBuilder()->hasColumn('listings', 'offer_price')) {
                $listing->offer_price = null;
            }
            
            $listing->status = 'enable';
            $listing->save();

            // Create English translation
            $transEn = new ListingTranslation();
            $transEn->listing_id = $listing->id;
            $transEn->lang_code = 'en';
            $transEn->title = $service['title_en'];
            $transEn->description = $service['description_en'];
            
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'short_description')) {
                $transEn->short_description = $service['short_description_en'];
            }
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'address')) {
                $transEn->address = $service['short_description_en'];
            }
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'seo_title')) {
                $transEn->seo_title = $service['title_en'] . ' - Barmagly';
            }
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'seo_description')) {
                $transEn->seo_description = $service['short_description_en'];
            }
            $transEn->save();

            // Create Arabic translation
            $transAr = new ListingTranslation();
            $transAr->listing_id = $listing->id;
            $transAr->lang_code = 'ar';
            $transAr->title = $service['title_ar'];
            $transAr->description = $service['description_ar'];
            
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'short_description')) {
                $transAr->short_description = $service['short_description_ar'];
            }
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'address')) {
                $transAr->address = $service['short_description_ar'];
            }
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'seo_title')) {
                $transAr->seo_title = $service['title_ar'] . ' - برمجلي';
            }
            if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'seo_description')) {
                $transAr->seo_description = $service['short_description_ar'];
            }
            $transAr->save();

            $this->command->info("✅ Created service: {$service['title_en']}");
        }

        $this->command->info('✅ All new services created!');
    }
}
