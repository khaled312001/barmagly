<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\GlobalSetting\App\Models\GlobalSetting;
use Illuminate\Support\Facades\File;

class MenuManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display menu management page
     */
    public function index()
    {
        // Get menu configuration from GlobalSetting or use default
        $menuConfig = GlobalSetting::where('key', 'menu_config')->first();
        
        $menuItems = [];
        if ($menuConfig) {
            $menuItems = json_decode($menuConfig->value, true) ?? [];
            // Merge defaults if Arabic labels are missing (migration for existing data)
            $defaultItems = $this->getDefaultMenuItems();
            $menuItems = $this->mergeDefaults($menuItems, $defaultItems);
        } else {
            // Default menu items based on current menu structure
            $menuItems = $this->getDefaultMenuItems();
        }

        return view('admin.menu-management.index', compact('menuItems'));
    }

    /**
     * Update menu order and visibility
     */
    public function update(Request $request)
    {
        $menuData = $request->input('menu_data');
        
        if (!$menuData) {
            $notify_message = trans('translate.No data provided');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }

        $menuItems = json_decode($menuData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $notify_message = trans('translate.Invalid data format');
            $notify_message = array('message' => $notify_message, 'alert-type' => 'error');
            return redirect()->back()->with($notify_message);
        }

        // Normalize keys (handle camelCase from JS to snake_case)
        $menuItems = $this->normalizeMenuKeys($menuItems);
        $menuData = json_encode($menuItems);

        // Save to GlobalSetting
        $menuConfig = GlobalSetting::where('key', 'menu_config')->first();
        
        if ($menuConfig) {
            $menuConfig->value = $menuData;
            $menuConfig->save();
        } else {
            $menuConfig = new GlobalSetting();
            $menuConfig->key = 'menu_config';
            $menuConfig->value = $menuData;
            $menuConfig->save();
        }

        $notify_message = trans('translate.Updated Successfully');
        $notify_message = array('message' => $notify_message, 'alert-type' => 'success');
        return redirect()->back()->with($notify_message);
    }

    /**
     * Get default menu items
     */
    private function getDefaultMenuItems()
    {
        return [
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
                'label_ar' => 'سابقة أعمالنا',
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
    }

    /**
     * Update menu blade file
     */
    private function updateMenuFile($menuItems)
    {
        // This will be handled by the view generation
        // For now, we'll just save the config
        // The actual menu rendering will read from GlobalSetting
    }

    /**
     * Normalize menu keys from camelCase to snake_case
     */
    private function normalizeMenuKeys($items)
    {
        $normalized = [];
        foreach ($items as $item) {
            // Handle specific keys that might come in as camelCase from jQuery data
            if (isset($item['labelAr'])) {
                $item['label_ar'] = $item['labelAr'];
                unset($item['labelAr']);
            }
            if (isset($item['label-ar'])) {
                $item['label_ar'] = $item['label-ar'];
                unset($item['label-ar']);
            }

            // Recursively handle children
            if (isset($item['children']) && is_array($item['children'])) {
                $item['children'] = $this->normalizeMenuKeys($item['children']);
            }
            
            $normalized[] = $item;
        }
        return $normalized;
    }

    /**
     * Merge items with defaults to fill missing translations
     */
    private function mergeDefaults($items, $defaults)
    {
        foreach ($items as &$item) {
            // Try to find matching default by ID or Label
            if (empty($item['label_ar'])) {
                foreach ($defaults as $default) {
                    if (
                        (isset($item['id']) && isset($default['id']) && $item['id'] == $default['id']) ||
                        (isset($item['label']) && isset($default['label']) && $item['label'] == $default['label'])
                    ) {
                        if (isset($default['label_ar'])) {
                            $item['label_ar'] = $default['label_ar'];
                        }
                        break;
                    }
                    
                    // Check children of default
                    if (isset($default['children'])) {
                        $this->findAndFillChild($item, $default['children']);
                    }
                }
            }

            // Recursively handle children
            if (isset($item['children']) && is_array($item['children'])) {
                $item['children'] = $this->mergeDefaults($item['children'], $defaults);
            }
        }
        return $items;
    }

    private function findAndFillChild(&$item, $defaults) {
        if (!empty($item['label_ar'])) return;

        foreach ($defaults as $default) {
            if (
                (isset($item['id']) && isset($default['id']) && $item['id'] == $default['id']) ||
                (isset($item['label']) && isset($default['label']) && $item['label'] == $default['label'])
            ) {
                if (isset($default['label_ar'])) {
                    $item['label_ar'] = $default['label_ar'];
                }
                return;
            }
             if (isset($default['children'])) {
                $this->findAndFillChild($item, $default['children']);
            }
        }
    }
}

