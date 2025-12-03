<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @yield('title')

    <link rel="shortcut icon" href="{{ asset($general_setting->favicon) }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <!-- End google font  -->

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('global/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">

    <!-- Code Editor  -->

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/app.min.css') }}">

    <link rel="stylesheet" href="{{ asset('global/toastr/toastr.min.css') }}">

    @if(Session::get('lang_dir', 'right_to_left') == 'right_to_left')
    <style>
        /* Force RTL Navbar - Loaded after main.css to override */
        html[dir="rtl"] .site-navbar,
        body.rtl .site-navbar {
            flex-direction: row-reverse !important;
            direction: rtl !important;
            justify-content: flex-start !important;
        }
        @media (min-width: 992px) {
            html[dir="rtl"] .site-navbar,
            body.rtl .site-navbar {
                flex-flow: row-reverse nowrap !important;
                justify-content: flex-start !important;
            }
        }
        html[dir="rtl"] .site-navbar .brand-logo,
        body.rtl .site-navbar .brand-logo {
            order: 999 !important;
            margin-right: 35px !important;
            margin-left: 0 !important;
        }
        html[dir="rtl"] .site-navbar .menu-block-wrapper,
        body.rtl .site-navbar .menu-block-wrapper {
            order: 998 !important;
            flex: 1 !important;
        }
        html[dir="rtl"] .site-navbar .header-btn,
        body.rtl .site-navbar .header-btn {
            order: 997 !important;
        }
        html[dir="rtl"] .site-navbar .mobile-menu-trigger,
        body.rtl .site-navbar .mobile-menu-trigger {
            order: 996 !important;
        }
        html[dir="rtl"] .site-menu-main,
        body.rtl .site-menu-main {
            flex-direction: row-reverse !important;
            direction: rtl !important;
            justify-content: flex-start !important;
        }
        html[dir="rtl"] .site-menu-main .nav-item,
        body.rtl .site-menu-main .nav-item {
            direction: rtl !important;
        }
        /* Reverse menu items order - first item on right */
        html[dir="rtl"] .site-menu-main .nav-item:nth-child(1),
        body.rtl .site-menu-main .nav-item:nth-child(1) {
            order: 999 !important;
        }
        html[dir="rtl"] .site-menu-main .nav-item:nth-child(2),
        body.rtl .site-menu-main .nav-item:nth-child(2) {
            order: 998 !important;
        }
        html[dir="rtl"] .site-menu-main .nav-item:nth-child(3),
        body.rtl .site-menu-main .nav-item:nth-child(3) {
            order: 997 !important;
        }
        html[dir="rtl"] .site-menu-main .nav-item:nth-child(4),
        body.rtl .site-menu-main .nav-item:nth-child(4) {
            order: 996 !important;
        }
        html[dir="rtl"] .site-menu-main .nav-item:nth-child(5),
        body.rtl .site-menu-main .nav-item:nth-child(5) {
            order: 995 !important;
        }
        html[dir="rtl"] .site-menu-main .nav-item:nth-child(6),
        body.rtl .site-menu-main .nav-item:nth-child(6) {
            order: 994 !important;
        }
        html[dir="rtl"] .site-menu-main .nav-item:nth-child(7),
        body.rtl .site-menu-main .nav-item:nth-child(7) {
            order: 993 !important;
        }
        html[dir="rtl"] .site-menu-main .nav-item:nth-child(8),
        body.rtl .site-menu-main .nav-item:nth-child(8) {
            order: 992 !important;
        }
    </style>
    @endif

    @stack('style_section')




    @if ($general_setting->google_analytic_status == 1)
        <script async
                src="https://www.googletagmanager.com/gtag/js?id={{ $general_setting->google_analytic_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', '{{ $general_setting->google_analytic_id }}');
        </script>
    @endif


    @if ($general_setting->pixel_status == 1)
        <script>
            !function (f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function () {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $general_setting->pixel_app_id }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id={{ $general_setting->pixel_app_id }}&ev=PageView&noscript=1"
            /></noscript>
    @endif



</head>
