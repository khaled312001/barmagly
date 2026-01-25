@extends('master_layout')

@section('title')
    @php
        $pageTitle = $custom_page->page_name;
        $pageDescription = strip_tags(clean($custom_page->description ?? ''));
        $canonicalUrl = url('/custom-page/' . $custom_page->slug);
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary">
    <meta property="twitter:url" content="{{ $canonicalUrl }}">
    <meta property="twitter:title" content="{{ $pageTitle }}">
    <meta property="twitter:description" content="{{ $pageDescription }}">
    
    <!-- Structured Data -->
    @php
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $pageTitle,
            'description' => strip_tags($pageDescription),
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
              <h1 class="post__title">{{ $custom_page->page_name }}</h1>
              <nav class="breadcrumbs">
                  <ul>
                      <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>

                      <li aria-current="page">{{ $custom_page->page_name }}</li>
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
              <div class="content-details Barmagly-service-details-item">
                {!! clean($custom_page->description) !!}
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
