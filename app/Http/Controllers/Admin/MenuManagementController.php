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
        // Normalize checkbox values before validation
        $menuItems = $request->input('menu_items', []);
        foreach ($menuItems as $index => $item) {
            // Set visible to false if checkbox is not checked
            if (!isset($item['visible']) || $item['visible'] != '1') {
                $menuItems[$index]['visible'] = false;
            } else {
                $menuItems[$index]['visible'] = true;
            }
            
            // Handle children visible
            if (isset($item['children']) && is_array($item['children'])) {
                foreach ($item['children'] as $childIndex => $child) {
                    if (!isset($child['visible']) || $child['visible'] != '1') {
                        $menuItems[$index]['children'][$childIndex]['visible'] = false;
                    } else {
                        $menuItems[$index]['children'][$childIndex]['visible'] = true;
                    }
                }
            }
        }
        
        // Replace request input with normalized data
        $request->merge(['menu_items' => $menuItems]);
        
        $request->validate([
            'menu_items' => 'required|array',
            'menu_items.*.id' => 'required|string',
            'menu_items.*.label' => 'required|string',
            'menu_items.*.route' => 'nullable|string',
            'menu_items.*.order' => 'required|integer',
            'menu_items.*.visible' => 'sometimes|boolean',
        ]);

        $menuItems = $request->input('menu_items');
        
        // Sort by order
        usort($menuItems, function($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        // Save to GlobalSetting
        $menuConfig = GlobalSetting::where('key', 'menu_config')->first();
        
        if ($menuConfig) {
            $menuConfig->value = json_encode($menuItems);
            $menuConfig->save();
        } else {
            $menuConfig = new GlobalSetting();
            $menuConfig->key = 'menu_config';
            $menuConfig->value = json_encode($menuItems);
            $menuConfig->save();
        }

        // Update the menu file
        $this->updateMenuFile($menuItems);

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
}

