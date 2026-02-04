
@extends('master_layout')
@section('title')
    @php
        $seoTitle = $seo_setting->seo_title ?? __('translate.Our Services') . ' - ' . ($general_setting->site_name ?? config('app.name'));
        $seoDescription = strip_tags(clean($seo_setting->seo_description ?? __('translate.Explore our comprehensive range of services')));
        $canonicalUrl = url('/services');
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
            '@type' => 'CollectionPage',
            'name' => $seoTitle,
            'description' => strip_tags($seoDescription),
            'url' => $canonicalUrl,
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection
@php
    $currentLang = session()->get('front_lang');
    $getProcessData = getContent('main_demo_process_section.content', true);
@endphp
@section('new-layout')
    <div class="Barmagly-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
        <div class="container">
            <h1 class="post__title">{{ __('translate.Our Services') }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                    <li aria-current="page"> {{ __('translate.Our Services') }}</li>
                </ul>
            </nav>

        </div>
    </div>
    <!-- End breadcrumb -->

    @php
        $currentLang = session()->get('front_lang');
        $getServiceContent = getContent('main_demo_service_section.content', true);
    @endphp
    <!-- Services Section -->
    <div class="section Barmagly-section-padding2 bg-light1">
        <div class="container">
            <div class="Barmagly-section-title center">
                <h2>{{ getTranslatedValue($getServiceContent, 'heading', $currentLang) ?? __('translate.Our Services') }}</h2>
            </div>
            <div class="row">

                @foreach($services_list as $index => $service)

                <div class="col-lg-6" data-aos="fade-up" data-aos-duration="600">
                    <div class="Barmagly-iconbox-wrap style-two">
                        <div class="Barmagly-iconbox-icon">
                            <img src="{{ asset($service->thumb_image) }}" alt="Image" width="123" height="41" loading="lazy">
                        </div>
                        <div class="Barmagly-iconbox-data">
                            <h5>{{ $service->title }}</h5>
                            <p>{{ $service->short_description }}</p>
                            <a class="Barmagly-icon-btn" href="{{ route('service', $service->slug) }}"><i class="icon-show ri-arrow-right-line"></i>
                                <span>{{ __('translate.Learn More') }}</span> <i class="icon-hide ri-arrow-right-line"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Services Section -->

    <!-- How We Work Section -->
    <div class="section Barmagly-section-padding5">
        @include('frontend.templates.layouts.process_section')
    </div>
    <!-- End How We Work Section -->
@endsection


