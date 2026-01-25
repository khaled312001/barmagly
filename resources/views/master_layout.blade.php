@extends('layout')

@section('title')
    @php
        $seoTitle = $seo_setting->seo_title ?? config('app.name');
        $seoDescription = strip_tags(clean($seo_setting->seo_description ?? config('app.name')));
        // Get the base URL from config and ensure it uses www
        $baseUrl = config('app.url');
        $parsedUrl = parse_url($baseUrl);
        $host = $parsedUrl['host'] ?? 'barmagly.tech';
        // Ensure www prefix
        if (strpos($host, 'www.') !== 0) {
            $host = 'www.' . $host;
        }
        $canonicalUrl = ($parsedUrl['scheme'] ?? 'https') . '://' . $host;
        // Add path if not homepage
        if (request()->path() !== '/') {
            $canonicalUrl .= '/' . request()->path();
        } else {
            $canonicalUrl .= '/';
        }
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
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $canonicalUrl }}">
    <meta property="twitter:title" content="{{ $seoTitle }}">
    <meta property="twitter:description" content="{{ $seoDescription }}">
@endsection

@section('front-content')
    @include('frontend.templates.layouts.white_navbar')

    @yield('new-layout')

    @if(!request()->routeIs('user.*') && !request()->routeIs('product.shop') && !request()->routeIs('product.search'))
        @include('frontend.templates.layouts.main_demo_cta')
    @endif
    @include('frontend.templates.layouts.footer')
@endsection
