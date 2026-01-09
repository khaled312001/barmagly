<div class="menu-block-wrapper">
    <div class="menu-overlay"></div>
    <nav class="menu-block" id="append-menu-header">
        <div class="mobile-menu-head">
            <div class="go-back">
                <i class="fa fa-angle-left"></i>
            </div>
            <div class="current-menu-title"></div>
            <div class="mobile-menu-close">&times;</div>
        </div>

        <ul class="site-menu-main {{ $menuTheme ?? '' }} {{ Session::get('lang_dir', 'right_to_left') == 'right_to_left' ? 'rtl-menu' : '' }}">

            @php
                $currentTheme = Modules\GlobalSetting\App\Models\GlobalSetting::where('key', 'selected_theme')->first()?->value ?? 'all_theme';
                $currentLang = Session::get('front_lang', 'en');
                $langDir = Session::get('lang_dir', 'right_to_left') == 'right_to_left' ? 'rtl-arrow' : '';
                
                // Get menu items from database
                $menuConfig = Modules\GlobalSetting\App\Models\GlobalSetting::where('key', 'menu_config')->first();
                $menuItems = [];
                
                if ($menuConfig && $menuConfig->value) {
                    $menuItems = json_decode($menuConfig->value, true) ?? [];
                }
                
                // If no menu config, use default menu structure
                if (empty($menuItems)) {
                    // Keep original menu structure as fallback
                    $useDefaultMenu = true;
                } else {
                    $useDefaultMenu = false;
                }
            @endphp

            @if($useDefaultMenu)
                {{-- Default Menu Structure (Fallback) --}}
                @if(config('app.env') === 'DEMO' || $currentTheme === 'all_theme')
                    <li class="nav-item nav-item-has-children">
                        <a href="#" class="nav-link-item drop-trigger">{{ __('translate.Home') }} <i
                                class="ri-arrow-down-s-fill {{ $langDir }}"></i></a>
                        <ul class="sub-menu" id="submenu-1">
                            <li class="sub-menu--item">
                                <a href="{{ route('home', ['theme' => 'startup_home']) }}">
                                    <span class="menu-item-text {{ $currentTheme === 'startup_home' ? 'active' : '' }}">{{ __('translate.Startup Home') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link-item">
                            <span class="menu-item-text active">{{ __('translate.Home') }}</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('services') }}" class="nav-link-item">
                        <span class="menu-item-text">{{ __('translate.Service') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('portfolio') }}" class="nav-link-item">
                        <span class="menu-item-text">{{ __('translate.Portfolio') }}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('blogs') }}" class="nav-link-item">
                        <span class="menu-item-text">{{ __('translate.Blog') }}</span>
                    </a>
                </li>

                <li class="nav-item nav-item-has-children">
                    <a href="#" class="nav-link-item drop-trigger">{{ __('translate.Pages') }} <i
                            class="ri-arrow-down-s-fill {{ $langDir }}"></i></a>
                    <ul class="sub-menu" id="submenu-2">
                        <li class="sub-menu--item">
                            <a href="{{ route('about-us') }}">
                                <span class="menu-item-text">{{ __('translate.About Us') }}</span>
                            </a>
                        </li>
                        <li class="sub-menu--item">
                            <a href="{{ route('pricing') }}">
                                <span class="menu-item-text">{{ __('translate.Pricing Plan') }}</span>
                            </a>
                        </li>
                        <li class="sub-menu--item">
                            <a href="{{ route('teams') }}">{{ __('translate.Our Teams') }}</a>
                        </li>
                        <li class="sub-menu--item">
                            <a href="{{ route('faq') }}">
                                <span class="menu-item-text">{{ __('translate.FAQ') }}</span>
                            </a>
                        </li>
                        <li class="sub-menu--item">
                            <a href="{{ route('testimonials') }}">
                                <span class="menu-item-text">{{ __('translate.Testimonials') }}</span>
                            </a>
                        </li>
                        @foreach ($custom_pages as $custom_page)
                            <li class="sub-menu--item">
                                <a href="{{ route('custom-page', $custom_page->slug) }}">{{ $custom_page->page_name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link-item" href="{{ route('contact-us') }}">{{ __('translate.Contact') }}</a>
                </li>
            @else
                {{-- Dynamic Menu from Database --}}
                @foreach($menuItems as $item)
                    @if(($item['visible'] ?? true) == false)
                        @continue
                    @endif

                    @if(($item['type'] ?? 'link') == 'dropdown' && isset($item['children']))
                        <li class="nav-item nav-item-has-children">
                            <a href="#" class="nav-link-item drop-trigger">
                                <span class="menu-item-text">{{ $currentLang == 'ar' ? ($item['label_ar'] ?? $item['label']) : $item['label'] }}</span>
                                <i class="ri-arrow-down-s-fill {{ $langDir }}"></i>
                            </a>
                            <ul class="sub-menu">
                                @foreach($item['children'] as $child)
                                    @if(($child['visible'] ?? true) == false)
                                        @continue
                                    @endif
                                    <li class="sub-menu--item">
                                        <a href="{{ $child['route'] ? route($child['route']) : '#' }}">
                                            <span class="menu-item-text">{{ $currentLang == 'ar' ? ($child['label_ar'] ?? $child['label']) : $child['label'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                                
                                {{-- Add custom pages to Pages dropdown if this is the Pages menu --}}
                                @if(($item['id'] ?? '') == 'pages')
                                    @foreach ($custom_pages as $custom_page)
                                        <li class="sub-menu--item">
                                            <a href="{{ route('custom-page', $custom_page->slug) }}">{{ $custom_page->page_name }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ $item['route'] ? route($item['route']) : '#' }}" class="nav-link-item">
                                <span class="menu-item-text">{{ $currentLang == 'ar' ? ($item['label_ar'] ?? $item['label']) : $item['label'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </nav>
</div>
