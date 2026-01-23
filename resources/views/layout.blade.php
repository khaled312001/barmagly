<!DOCTYPE html>
<html lang="{{ Session::get('front_lang', 'ar') }}" dir="{{ Session::get('lang_dir', 'right_to_left') == 'right_to_left' ? 'rtl' : 'ltr' }}">
    @include('frontend.head')
  <body class="{{ Session::get('lang_dir', 'right_to_left') == 'right_to_left' ? 'rtl' : 'ltr' }}">

    <!-- Menu Start -->
    <div class="Barmagly-preloader-wrap">
        <div class="Barmagly-preloader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- End preloader -->


    <!-- progress circle -->
    <div class="paginacontainer">
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
            <div class="top-arrow">
                <i class="ri-arrow-up-s-line"></i>
            </div>
        </div>
    </div>

    @yield('front-content')

    <!-- Floating WhatsApp Button -->
    @php
        $whatsappNumber = str_replace(['+', ' ', '-'], '', $footer->phone ?? '201010254819');
    @endphp
    <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="whatsapp-float" aria-label="WhatsApp">
        <i class="ri-whatsapp-fill"></i>
    </a>

    @include('frontend.script')

    @stack('js_section')

  </body>
</html>
