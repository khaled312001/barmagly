@extends('master_layout')
@section('title')
    @php
        $seoTitle = __('translate.Pricing Plan') . ' - ' . ($general_setting->site_name ?? config('app.name'));
        $seoDescription = __('translate.View our pricing plans and packages') . ' - ' . ($general_setting->site_name ?? config('app.name'));
        $canonicalUrl = url('/pricing-plan');
    @endphp
    <title>{{ $seoTitle }}</title>
    <meta name="title" content="{{ $seoTitle }}">
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary">
    <meta property="twitter:url" content="{{ $canonicalUrl }}">
    <meta property="twitter:title" content="{{ $seoTitle }}">
    <meta property="twitter:description" content="{{ $seoDescription }}">
    
    <!-- Structured Data -->
    @php
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $seoTitle,
            'description' => strip_tags($seoDescription),
            'url' => $canonicalUrl,
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection
@section('new-layout')
    @php
        $currentLang = session()->get('front_lang');
        $pricingContent = getContent('it_solutions_pricing_section.content', true);
                $packageInformation = $currentLang === 'en'
               ? ($pricingContent->data_values['package_information'] ?? [])
               : getTranslatedValue($pricingContent, 'package_information', $currentLang);
    @endphp
    <div class="Barmagly-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
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
    <div class="section Barmagly-section-padding2">
        <div class="container">
            <div class="row">
                @if(is_array($packageInformation))
                    @foreach($packageInformation as $package)
                        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-duration="{{ 600 + ($loop->index * 200) }}">
                            <div class="Barmagly-pricing-wrap {{ $loop->iteration == 2 ? 'active' : '' }}">
                                <div class="Barmagly-pricing-header">
                                    <h4>{{ $package['title'] ?? '' }}</h4>
                                    <p>{{ $package['description'] ?? '' }}</p>
                                </div>
                                <div class="Barmagly-pricing-price">
                                    <h2>{{ currency($package['price']) ?? '0' }}<span>/{{ __('translate.month') }}</span></h2>
                                </div>
                                <div class="Barmagly-pricing-feature">
                                    <ul>
                                        @if(isset($package['features']) && is_array($package['features']))
                                            @foreach($package['features'] as $feature)
                                                <li><i class="ri-check-line"></i>{{ $feature }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <a class="Barmagly-pricing-btn" href="{{ route('contact-us') }}">{{ __('translate.Select This Plan') }}</a>
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
