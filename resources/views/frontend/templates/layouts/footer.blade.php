
<footer class="Barmagly-footer-section dark-bg">
    <div class="container">
        <div class="Barmagly-footer-top Barmagly-section-padding">
            <div class="row">
                <div class="col-xl-4 col-lg-12">
                    <div class="Barmagly-footer-textarea light-color">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset($general_setting->white_logo) }}" alt="Logo">
                        </a>
                        <p>{{ $footer->about_us }}</p>
                        <div class="Barmagly-social-icon-box">
                            <ul>
                                <li>
                                    <a href="{{ $footer->facebook }}">
                                        <i class="ri-facebook-fill"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $footer->linkedin }}">
                                        <i class="ri-linkedin-fill"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 offset-xl-1 col-md-4">
                    <div class="Barmagly-footer-menu">
                        <div class="Barmagly-footer-title">
                            <h5>{{ __('translate.Quick Links') }}</h5>
                        </div>
                        <ul>
                            <li><a href="{{ route('about-us') }}">{{ __('translate.About Us') }}</a></li>
                            <li><a href="{{ route('blogs') }}">{{ __('translate.Blogs') }}</a></li>
                            <li><a href="{{ route('contact-us') }}">{{ __('translate.Contact Us') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-md-5">
                    <div class="Barmagly-footer-menu">
                        <div class="Barmagly-footer-title">
                            <h5>{{ __('translate.Services') }}</h5>
                        </div>
                        <ul>
                            @foreach($services as $service)
                                <li><a href="{{ route('service', $service->slug) }}">{{ $service->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-md-3">
                    <div class="Barmagly-footer-menu mb-0">
                        <div class="Barmagly-footer-title">
                            <h5>{{ __('translate.Information') }}</h5>
                        </div>
                        <ul>
                            <li><a href="{{ route('services') }}">{{ __('translate.Services') }}</a></li>
                            <li><a href="{{ route('privacy-policy') }}">{{ __('translate.Privacy Policy') }}</a></li>
                            <li><a href="{{ route('terms-conditions') }}">{{ __('translate.Terms & Conditions') }}</a></li>
                            <li><a href="{{ route('faq') }}">{{ __('translate.Faqs') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="Barmagly-footer-bottom center">
            <div class="Barmagly-copywright">
                <p>{{ $footer->copyright }}</p>
            </div>
        </div>
    </div>
</footer>
