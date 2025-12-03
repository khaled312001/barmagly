@extends('master_layout')
@section('new-layout')
    @php
        $currentLang = session()->get('front_lang');
        $pricingContent = getContent('it_solutions_pricing_section.content', true);
                $packageInformation = $currentLang === 'en'
               ? ($pricingContent->data_values['package_information'] ?? [])
               : getTranslatedValue($pricingContent, 'package_information', $currentLang);
    @endphp
    <div class="Jovero-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
        <div class="container">
            <h1 class="post__title">{{ __($pageTitle) }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                    <li aria-current="page">{{ __($pageTitle) }}</li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- End breadcrumb -->
    <div class="section Jovero-section-padding2">
        <div class="container">
            <div class="row">
                @if(is_array($packageInformation))
                    @foreach($packageInformation as $package)
                        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="{{ 600 + ($loop->index * 200) }}">
                            <div class="Jovero-pricing-wrap {{ $loop->iteration == 2 ? 'active' : '' }}">
                                <div class="Jovero-pricing-header">
                                    <h4>{{ $package['title'] ?? '' }}</h4>
                                    <p>{{ $package['description'] ?? '' }}</p>
                                </div>
                                <div class="Jovero-pricing-price">
                                    <h2>{{ currency($package['price']) ?? '0' }}<span>/{{ __('translate.month') }}</span></h2>
                                </div>
                                <div class="Jovero-pricing-feature">
                                    <ul>
                                        @if(isset($package['features']) && is_array($package['features']))
                                            @foreach($package['features'] as $feature)
                                                <li><i class="ri-check-line"></i>{{ $feature }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <a class="Jovero-pricing-btn" href="{{ route('contact-us') }}">{{ __('translate.Select This Plan') }}</a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <p class="text-center">{{ __('translate.No pricing packages available') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('frontend.templates.layouts.faq')
    <!-- End -->
@endsection
