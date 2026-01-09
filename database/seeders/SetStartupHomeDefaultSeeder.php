<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GlobalSetting\App\Models\GlobalSetting;

class SetStartupHomeDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set startup_home as default theme
        $themeSetting = GlobalSetting::where('key', 'selected_theme')->first();
        
        if ($themeSetting) {
            $themeSetting->value = 'startup_home';
            $themeSetting->save();
        } else {
            $themeSetting = new GlobalSetting();
            $themeSetting->key = 'selected_theme';
            $themeSetting->value = 'startup_home';
            $themeSetting->save();
        }

        // Set default menu configuration for startup_home
        $menuConfig = GlobalSetting::where('key', 'menu_config')->first();
        
        $defaultMenuItems = [
            [
                'id' => 'home',
                'label' => 'Home',
                'label_ar' => 'الرئيسية',
                'route' => 'home',
                'order' => 1,
                'visible' => true,
                'type' => 'link',
            ],
            [
                'id' => 'services',
                'label' => 'Service',
                'label_ar' => 'الخدمة',
                'route' => 'services',
                'order' => 2,
                'visible' => true,
                'type' => 'link',
            ],
            [
                'id' => 'portfolio',
                'label' => 'Portfolio',
                'label_ar' => 'المحفظة',
                'route' => 'portfolio',
                'order' => 3,
                'visible' => true,
                'type' => 'link',
            ],
            [
                'id' => 'blog',
                'label' => 'Blog',
                'label_ar' => 'المدونة',
                'route' => 'blogs',
                'order' => 4,
                'visible' => true,
                'type' => 'link',
            ],
            [
                'id' => 'pages',
                'label' => 'Pages',
                'label_ar' => 'الصفحات',
                'route' => null,
                'order' => 5,
                'visible' => true,
                'type' => 'dropdown',
                'children' => [
                    [
                        'id' => 'about-us',
                        'label' => 'About Us',
                        'label_ar' => 'من نحن',
                        'route' => 'about-us',
                        'order' => 1,
                        'visible' => true,
                    ],
                    [
                        'id' => 'pricing',
                        'label' => 'Pricing Plan',
                        'label_ar' => 'خطط الأسعار',
                        'route' => 'pricing',
                        'order' => 2,
                        'visible' => true,
                    ],
                    [
                        'id' => 'teams',
                        'label' => 'Our Teams',
                        'label_ar' => 'فريقنا',
                        'route' => 'teams',
                        'order' => 3,
                        'visible' => true,
                    ],
                    [
                        'id' => 'faq',
                        'label' => 'FAQ',
                        'label_ar' => 'الأسئلة الشائعة',
                        'route' => 'faq',
                        'order' => 4,
                        'visible' => true,
                    ],
                    [
                        'id' => 'testimonials',
                        'label' => 'Testimonials',
                        'label_ar' => 'الشهادات',
                        'route' => 'testimonials',
                        'order' => 5,
                        'visible' => true,
                    ],
                ],
            ],
            [
                'id' => 'contact',
                'label' => 'Contact',
                'label_ar' => 'اتصل',
                'route' => 'contact-us',
                'order' => 6,
                'visible' => true,
                'type' => 'link',
            ],
        ];

        if ($menuConfig) {
            $menuConfig->value = json_encode($defaultMenuItems);
            $menuConfig->save();
        } else {
            $menuConfig = new GlobalSetting();
            $menuConfig->key = 'menu_config';
            $menuConfig->value = json_encode($defaultMenuItems);
            $menuConfig->save();
        }

        $this->command->info('✅ Default theme set to startup_home');
        $this->command->info('✅ Default menu configuration saved');
    }
}

