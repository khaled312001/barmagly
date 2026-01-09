<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Frontend;
use Modules\Listing\Entities\Listing;
use Modules\Listing\Entities\ListingTranslation;
use Modules\Blog\App\Models\Blog;
use Modules\Blog\App\Models\BlogTranslation;
use Modules\Blog\App\Models\BlogCategory;
use Modules\Project\App\Models\Project;
use App\Models\ProjectTranslation;
use App\Models\Team;
use App\Models\TeamTranslation;
use Modules\Testimonial\App\Models\Testimonial;
use Modules\Testimonial\App\Models\TestimonialTrasnlation;
use Modules\Category\Entities\Category;
use Illuminate\Support\Facades\DB;

class CompleteContentUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting complete content update...');
        
        $this->updateServices();
        $this->updateBlogs();
        $this->updateProjects();
        $this->updateTeams();
        $this->updateTestimonials();
        
        $this->command->info('✅ Complete content update finished!');
    }

    /**
     * Update Services (Listings)
     */
    private function updateServices(): void
    {
        $this->command->info('📝 Updating Services...');
        
        // Get or create a category for services
        $category = Category::where('status', 'enable')->first();
        if (!$category) {
            // Create default category if none exists
            $category = new Category();
            $category->status = 'enable';
            $category->save();
        }
        
        $services = [
            [
                'title_en' => 'Web Development',
                'title_ar' => 'تطوير المواقع',
                'description_en' => 'We provide professional web development services using the latest technologies. From simple websites to complex web applications, we build solutions that meet your business needs.',
                'description_ar' => 'نقدم خدمات تطوير المواقع الاحترافية باستخدام أحدث التقنيات. من المواقع البسيطة إلى التطبيقات الويب المعقدة، نبني حلول تلبي احتياجات عملك.',
                'short_description_en' => 'Professional web development with modern technologies',
                'short_description_ar' => 'تطوير مواقع احترافي بأحدث التقنيات',
            ],
            [
                'title_en' => 'Website Design',
                'title_ar' => 'تصميم المواقع',
                'description_en' => 'Create stunning, responsive website designs that engage your audience and drive conversions. We focus on user experience and visual appeal.',
                'description_ar' => 'أنشئ تصاميم مواقع مذهلة ومتجاوبة تجذب جمهورك وتزيد المبيعات. نركز على تجربة المستخدم والجاذبية البصرية.',
                'short_description_en' => 'Beautiful, responsive website designs',
                'short_description_ar' => 'تصاميم مواقع جميلة ومتجاوبة',
            ],
            [
                'title_en' => 'UI/UX Design',
                'title_ar' => 'تصميم UI/UX',
                'description_en' => 'User-centered design approach that creates intuitive and delightful user experiences. We design interfaces that users love to interact with.',
                'description_ar' => 'نهج تصميم يركز على المستخدم لخلق تجارب مستخدم سهلة وممتعة. نصمم واجهات يحب المستخدمون التفاعل معها.',
                'short_description_en' => 'User-centered design for better experiences',
                'short_description_ar' => 'تصميم يركز على المستخدم لتجارب أفضل',
            ],
            [
                'title_en' => 'Mobile App Development',
                'title_ar' => 'تطوير تطبيقات الهاتف',
                'description_en' => 'Native and cross-platform mobile app development for iOS and Android. We create apps that provide seamless user experiences.',
                'description_ar' => 'تطوير تطبيقات الهاتف الأصلية والمتعددة المنصات لـ iOS و Android. ننشئ تطبيقات توفر تجارب مستخدم سلسة.',
                'short_description_en' => 'iOS and Android app development',
                'short_description_ar' => 'تطوير تطبيقات iOS و Android',
            ],
            [
                'title_en' => 'E-commerce Development',
                'title_ar' => 'تطوير المتاجر الإلكترونية',
                'description_en' => 'Complete e-commerce solutions from design to implementation. We build secure, scalable online stores that drive sales.',
                'description_ar' => 'حلول متاجر إلكترونية كاملة من التصميم إلى التنفيذ. نبني متاجر إلكترونية آمنة وقابلة للتوسع تزيد المبيعات.',
                'short_description_en' => 'Complete e-commerce solutions',
                'short_description_ar' => 'حلول متاجر إلكترونية كاملة',
            ],
        ];

        foreach ($services as $index => $service) {
            $listing = Listing::skip($index)->first();
            
            if (!$listing) {
                // Create new listing if doesn't exist
                $listing = new Listing();
                $listing->category_id = $category->id;
                $listing->sub_category_id = 0;
                $listing->thumb_image = 'default/service.jpg';
                $listing->slug = \Illuminate\Support\Str::slug($service['title_en']);
                $listing->regular_price = 0;
                $listing->offer_price = null;
                $listing->status = 'enable';
                $listing->save();
            } else {
                // Update slug if needed
                if (empty($listing->slug)) {
                    $listing->slug = \Illuminate\Support\Str::slug($service['title_en']);
                    $listing->save();
                }
            }

            // Update English translation
            $translationEn = ListingTranslation::where('listing_id', $listing->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$translationEn) {
                $translationEn = new ListingTranslation();
                $translationEn->listing_id = $listing->id;
                $translationEn->lang_code = 'en';
            }
            
            $translationEn->title = $service['title_en'];
            $translationEn->description = $service['description_en'];
            // Only set address if column exists in database
            try {
                if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'address')) {
                    $translationEn->address = $service['short_description_en'] ?? '';
                }
            } catch (\Exception $e) {
                // Column doesn't exist, skip it
            }
            $translationEn->save();

            // Update Arabic translation
            $translationAr = ListingTranslation::where('listing_id', $listing->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$translationAr) {
                $translationAr = new ListingTranslation();
                $translationAr->listing_id = $listing->id;
                $translationAr->lang_code = 'ar';
            }
            
            $translationAr->title = $service['title_ar'];
            $translationAr->description = $service['description_ar'];
            // Only set address if column exists in database
            try {
                if (DB::getSchemaBuilder()->hasColumn('listing_translations', 'address')) {
                    $translationAr->address = $service['short_description_ar'] ?? '';
                }
            } catch (\Exception $e) {
                // Column doesn't exist, skip it
            }
            $translationAr->save();
        }

        $this->command->info('✅ Services updated!');
    }

    /**
     * Update Blogs
     */
    private function updateBlogs(): void
    {
        $this->command->info('📝 Updating Blogs...');
        
        // Get or create a blog category
        $blogCategory = BlogCategory::where('status', 1)->first();
        if (!$blogCategory) {
            $blogCategory = new BlogCategory();
            $blogCategory->status = 1;
            $blogCategory->save();
            
            // Create translations for blog category
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
                'title_en' => 'Best Practices for Web Development in 2025',
                'title_ar' => 'أفضل الممارسات لتطوير المواقع في 2025',
                'description_en' => 'Discover the latest trends and best practices in web development. Learn about modern frameworks, performance optimization, and security measures.',
                'description_ar' => 'اكتشف أحدث الاتجاهات وأفضل الممارسات في تطوير المواقع. تعرف على الأطر الحديثة وتحسين الأداء وإجراءات الأمان.',
            ],
            [
                'title_en' => 'UI/UX Design Principles for Better User Experience',
                'title_ar' => 'مبادئ تصميم UI/UX لتجربة مستخدم أفضل',
                'description_en' => 'Learn the fundamental principles of UI/UX design that help create intuitive and engaging user interfaces. Understand user psychology and design patterns.',
                'description_ar' => 'تعلم المبادئ الأساسية لتصميم UI/UX التي تساعد في إنشاء واجهات مستخدم سهلة وجذابة. افهم نفسية المستخدم وأنماط التصميم.',
            ],
            [
                'title_en' => 'How to Choose the Right Technology Stack for Your Project',
                'title_ar' => 'كيف تختار التقنيات المناسبة لمشروعك',
                'description_en' => 'A comprehensive guide to choosing the right technology stack for your web development project. Compare different frameworks and tools.',
                'description_ar' => 'دليل شامل لاختيار التقنيات المناسبة لمشروع تطوير المواقع. قارن بين الأطر والأدوات المختلفة.',
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
            } else {
                // Update slug if needed
                if (empty($blogModel->slug)) {
                    $blogModel->slug = \Illuminate\Support\Str::slug($blog['title_en']);
                    $blogModel->save();
                }
            }

            // Update English translation
            $translationEn = BlogTranslation::where('blog_id', $blogModel->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$translationEn) {
                $translationEn = new BlogTranslation();
                $translationEn->blog_id = $blogModel->id;
                $translationEn->lang_code = 'en';
            }
            
            $translationEn->title = $blog['title_en'];
            $translationEn->description = $blog['description_en'];
            $translationEn->save();

            // Update Arabic translation
            $translationAr = BlogTranslation::where('blog_id', $blogModel->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$translationAr) {
                $translationAr = new BlogTranslation();
                $translationAr->blog_id = $blogModel->id;
                $translationAr->lang_code = 'ar';
            }
            
            $translationAr->title = $blog['title_ar'];
            $translationAr->description = $blog['description_ar'];
            $translationAr->save();
        }

        $this->command->info('✅ Blogs updated!');
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
                'description_en' => 'A complete e-commerce platform with modern design and advanced features. Built with Laravel and Vue.js for optimal performance.',
                'description_ar' => 'منصة متجر إلكتروني كاملة بتصميم حديث وميزات متقدمة. مبني بـ Laravel و Vue.js لأداء مثالي.',
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
        ];

        foreach ($projects as $index => $project) {
            $projectModel = Project::skip($index)->first();
            
            if (!$projectModel) {
                $projectModel = new Project();
                $projectModel->status = 'enable';
                $projectModel->save();
            }

            // Update English translation
            $translationEn = ProjectTranslation::where('project_id', $projectModel->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$translationEn) {
                $translationEn = new ProjectTranslation();
                $translationEn->project_id = $projectModel->id;
                $translationEn->lang_code = 'en';
            }
            
            $translationEn->title = $project['title_en'];
            $translationEn->description = $project['description_en'];
            $translationEn->client_name = $project['client_name_en'];
            $translationEn->save();

            // Update Arabic translation
            $translationAr = ProjectTranslation::where('project_id', $projectModel->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$translationAr) {
                $translationAr = new ProjectTranslation();
                $translationAr->project_id = $projectModel->id;
                $translationAr->lang_code = 'ar';
            }
            
            $translationAr->title = $project['title_ar'];
            $translationAr->description = $project['description_ar'];
            $translationAr->client_name = $project['client_name_ar'];
            $translationAr->save();
        }

        $this->command->info('✅ Projects updated!');
    }

    /**
     * Update Teams
     */
    private function updateTeams(): void
    {
        $this->command->info('📝 Updating Teams...');
        
        $teams = [
            [
                'name_en' => 'Ahmed Mohamed',
                'name_ar' => 'أحمد محمد',
                'designation_en' => 'Lead Web Developer',
                'designation_ar' => 'مطور ويب رئيسي',
                'description_en' => 'Expert in web development with 10+ years of experience. Specialized in Laravel, Vue.js, and modern web technologies.',
                'description_ar' => 'خبير في تطوير المواقع مع أكثر من 10 سنوات من الخبرة. متخصص في Laravel و Vue.js وتقنيات الويب الحديثة.',
            ],
            [
                'name_en' => 'Sara Ali',
                'name_ar' => 'سارة علي',
                'designation_en' => 'UI/UX Designer',
                'designation_ar' => 'مصممة UI/UX',
                'description_en' => 'Creative UI/UX designer with passion for user-centered design. Expert in creating intuitive and beautiful interfaces.',
                'description_ar' => 'مصممة UI/UX إبداعية شغوفة بالتصميم المرتكز على المستخدم. خبيرة في إنشاء واجهات سهلة وجميلة.',
            ],
            [
                'name_en' => 'Mohamed Hassan',
                'name_ar' => 'محمد حسن',
                'designation_en' => 'Frontend Developer',
                'designation_ar' => 'مطور واجهة أمامية',
                'description_en' => 'Frontend developer specialized in React, Vue.js, and modern JavaScript frameworks. Focus on performance and user experience.',
                'description_ar' => 'مطور واجهة أمامية متخصص في React و Vue.js وأطر JavaScript الحديثة. يركز على الأداء وتجربة المستخدم.',
            ],
            [
                'name_en' => 'Fatima Ibrahim',
                'name_ar' => 'فاطمة إبراهيم',
                'designation_en' => 'Project Manager',
                'designation_ar' => 'مديرة مشاريع',
                'description_en' => 'Experienced project manager ensuring smooth delivery of web development projects. Expert in agile methodologies.',
                'description_ar' => 'مديرة مشاريع خبيرة تضمن تسليم سلس لمشاريع تطوير المواقع. خبيرة في منهجيات Agile.',
            ],
        ];

        foreach ($teams as $index => $team) {
            $teamModel = Team::skip($index)->first();
            
            if (!$teamModel) {
                $teamModel = new Team();
                $teamModel->status = 'enable';
                $teamModel->save();
            }

            // Update English translation
            $translationEn = TeamTranslation::where('team_id', $teamModel->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$translationEn) {
                $translationEn = new TeamTranslation();
                $translationEn->team_id = $teamModel->id;
                $translationEn->lang_code = 'en';
            }
            
            $translationEn->name = $team['name_en'];
            $translationEn->designation = $team['designation_en'];
            $translationEn->description = $team['description_en'];
            $translationEn->save();

            // Update Arabic translation
            $translationAr = TeamTranslation::where('team_id', $teamModel->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$translationAr) {
                $translationAr = new TeamTranslation();
                $translationAr->team_id = $teamModel->id;
                $translationAr->lang_code = 'ar';
            }
            
            $translationAr->name = $team['name_ar'];
            $translationAr->designation = $team['designation_ar'];
            $translationAr->description = $team['description_ar'];
            $translationAr->save();
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
                'comment_en' => 'Barmagly delivered an exceptional website for our company. Their attention to detail and professional approach exceeded our expectations. Highly recommended!',
                'comment_ar' => 'قدمت برمجلي موقعاً استثنائياً لشركتنا. انتباههم للتفاصيل ونهجهم الاحترافي تجاوز توقعاتنا. أنصح بهم بشدة!',
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
                'comment_en' => 'Professional web development services. The team was responsive, knowledgeable, and delivered on time. Great experience overall!',
                'comment_ar' => 'خدمات تطوير مواقع احترافية. الفريق كان متجاوباً ومطلعاً وسلم في الوقت المحدد. تجربة رائعة بشكل عام!',
            ],
        ];

        foreach ($testimonials as $index => $testimonial) {
            $testimonialModel = Testimonial::skip($index)->first();
            
            if (!$testimonialModel) {
                $testimonialModel = new Testimonial();
                $testimonialModel->status = 'active';
                $testimonialModel->save();
            }

            // Update English translation
            $translationEn = TestimonialTrasnlation::where('testimonial_id', $testimonialModel->id)
                ->where('lang_code', 'en')
                ->first();
            
            if (!$translationEn) {
                $translationEn = new TestimonialTrasnlation();
                $translationEn->testimonial_id = $testimonialModel->id;
                $translationEn->lang_code = 'en';
            }
            
            $translationEn->name = $testimonial['name_en'];
            $translationEn->designation = $testimonial['designation_en'];
            $translationEn->comment = $testimonial['comment_en'];
            $translationEn->save();

            // Update Arabic translation
            $translationAr = TestimonialTrasnlation::where('testimonial_id', $testimonialModel->id)
                ->where('lang_code', 'ar')
                ->first();
            
            if (!$translationAr) {
                $translationAr = new TestimonialTrasnlation();
                $translationAr->testimonial_id = $testimonialModel->id;
                $translationAr->lang_code = 'ar';
            }
            
            $translationAr->name = $testimonial['name_ar'];
            $translationAr->designation = $testimonial['designation_ar'];
            $translationAr->comment = $testimonial['comment_ar'];
            $translationAr->save();
        }

        $this->command->info('✅ Testimonials updated!');
    }
}

