@extends('frontend.templates.main_demo_layout')
@section('title')
    @php
        $seoTitle = $service->seo_title ?? $service->translate->title ?? html_decode($service->title);
        $seoDescription = $service->seo_description ?? strip_tags(clean($service->translate->description ?? ''));
        $serviceTitle = __($service->translate->title);
        $canonicalUrl = url('/service/' . $service->slug);
        $serviceImage = asset($service->background_image ?? $service->thumb_image ?? '');
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
    @if($serviceImage)
    <meta property="og:image" content="{{ $serviceImage }}">
    @endif
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $canonicalUrl }}">
    <meta property="twitter:title" content="{{ $seoTitle }}">
    <meta property="twitter:description" content="{{ $seoDescription }}">
    @if($serviceImage)
    <meta property="twitter:image" content="{{ $serviceImage }}">
    @endif
    
    <!-- Structured Data -->
    @php
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $serviceTitle,
            'description' => strip_tags($seoDescription),
            'url' => $canonicalUrl,
        ];
        
        if($serviceImage) {
            $structuredData['image'] = $serviceImage;
        }
        
        if($service->category) {
            $structuredData['serviceType'] = $service->category->translate->name ?? '';
        }
        
        $structuredData['provider'] = [
            '@type' => 'Organization',
            'name' => $general_setting->site_name ?? config('app.name')
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@section('content')
    @php
        $currentLang = session()->get('front_lang');
        $getSidebarCTAData = getContent('main_demo_sidebar_cta_section.content', true);
    @endphp
    <!-- Page Update -->
    <div class="Barmagly-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image)}})">
        <div class="container">
            <h1 class="post__title">{{ __($service->translate->title) }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                    <li><a href="{{ route('services') }}">{{ __('translate.Services') }}</a></li>
                    <li aria-current="page"> {{ __($service->translate->title) }}</li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="section Barmagly-section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="Barmagly-service-details-wrap">
                        <img data-aos="fade-up" data-aos-duration="800" src="{{ asset($service->background_image) }}" alt="{{ $serviceTitle }}" class="Barmagly-service-details-img">
                        <div class="Barmagly-service-details-item">
                            <h3>{{ __('translate.Overview') }}</h3>
                             {!! clean($service->translate->description) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="Barmagly-service-sidebar">
                        <div class="Barmagly-service-menu">
                            <ul>
                                @foreach($showServices as $service)
                                <li><a href="{{ route('service', $service->slug) }}">{{ __($service->title) }} <i class="ri-arrow-right-up-line"></i></a></li>
                                @endforeach
                            </ul>
                        </div>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End section -->


@endsection
