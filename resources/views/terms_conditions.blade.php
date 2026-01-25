@extends('master_layout')

@section('title')
    @php
        $seoTitle = $seo_setting->seo_title ?? __('translate.Terms and Condition');
        $seoDescription = strip_tags(clean($seo_setting->seo_description ?? ''));
        $canonicalUrl = url('/terms-conditions');
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
<!-- Main Start -->
<main class="bg-offWhite">
    <!-- Breadcrumb -->
        <!-- Breadcrumb -->
        <div class="Barmagly-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
          <div class="container">
              <h1 class="post__title">{{ __('translate.Terms and Condition') }}</h1>
              <nav class="breadcrumbs">
                  <ul>
                      <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>

                      <li aria-current="page">{{ __('translate.Terms and Condition') }}</li>
                  </ul>
              </nav>
          </div>
        </div>
    <!-- Breadcrumb End -->

    <!-- Content -->
    <section class="py-110 legal-content my-5">
      <div class="container">
        <div>
          <div class="row">
            <div class="co-auto">
              <div class="Barmagly-service-details-item">
                {!! clean($terms_conditions->description) !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Job Grid End -->
  </main>
  <!-- Main End -->
@endsection
