@php use Modules\Blog\App\Models\Blog; @endphp
@extends('frontend.templates.main_demo_layout')

@section('title')
    @php
        $seoTitle = $blog->seo_title ?? $blog->front_translate?->title ?? $blog->translate?->title;
        $seoDescription = $blog->seo_description ?? strip_tags(clean($blog->front_translate?->description ?? $blog->translate?->description ?? ''));
        $blogTitle = $blog->front_translate?->title ?? $blog->translate?->title;
        $canonicalUrl = url('/blog/' . $blog->slug);
        $blogImage = asset($blog->image);
        
        $tags = '';
        if($blog->tags){
            $decoded_tags = json_decode($blog->tags);
            if(is_array($decoded_tags) || is_object($decoded_tags)){
                foreach ($decoded_tags as $key => $blog_tag) {
                    if(isset($blog_tag->value)){
                        $tags .= $blog_tag->value.', ';
                    }
                }
            }
        }
    @endphp
    <title>{{ $seoTitle }}</title>
    <meta name="title" content="{{ $seoTitle }}">
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @if($tags)
    <meta name="keywords" content="{{ rtrim($tags, ', ') }}">
    @endif
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $blogImage }}">
    @if($blog->created_at)
    <meta property="article:published_time" content="{{ $blog->created_at->toIso8601String() }}">
    @endif
    @if($blog->category)
    <meta property="article:section" content="{{ $blog->category->front_translate?->name ?? $blog->category->translate?->name ?? '' }}">
    @endif
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $canonicalUrl }}">
    <meta property="twitter:title" content="{{ $seoTitle }}">
    <meta property="twitter:description" content="{{ $seoDescription }}">
    <meta property="twitter:image" content="{{ $blogImage }}">
    
    <!-- Structured Data -->
    @php
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $blogTitle,
            'description' => strip_tags($seoDescription),
            'image' => $blogImage,
            'url' => $canonicalUrl,
        ];
        
        if($blog->created_at) {
            $structuredData['datePublished'] = $blog->created_at->toIso8601String();
        }
        
        if($blog->updated_at) {
            $structuredData['dateModified'] = $blog->updated_at->toIso8601String();
        }
        
        if($blog->author) {
            $structuredData['author'] = [
                '@type' => 'Person',
                'name' => $blog->author->name ?? 'Admin'
            ];
        }
        
        if($blog->category) {
            $structuredData['articleSection'] = $blog->category->front_translate?->name ?? $blog->category->translate?->name ?? '';
        }
        
        $structuredData['publisher'] = [
            '@type' => 'Organization',
            'name' => $general_setting->site_name ?? config('app.name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset($general_setting->logo ?? '')
            ]
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endsection

@section('content')
<!-- Main Start -->
<div class="Barmagly-breadcrumb" style="background-image: url({{ asset($general_setting->breadcrumb_image ?? '') }})">
    <div class="container">
        <h1 class="post__title">{{ $blog->front_translate?->title ?? $blog->translate?->title }}</h1>
        <nav class="breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                <li><a href="{{ route('blogs') }}">{{ __('translate.Blog') }}</a></li>
                <li aria-current="page">{{ $blog->front_translate?->title ?? $blog->translate?->title }}</li>
            </ul>
        </nav>
    </div>
</div>
<!-- End breadcrumb -->

<div class="section Barmagly-section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="Barmagly-blog-thumb single-blog" data-aos="fade-up" data-aos-duration="800">
                    <img src="{{ asset($blog->image) }}" alt="{{ $blogTitle }}">
                </div>
                <div class="Barmagly-single-post-content-wrap">
                    <div class="Barmagly-single-post-meta">
                        <ul>
                            <li><a href=""><i class="ri-calendar-fill"></i>{{ __($blog->created_at->format('d M Y')) }}</a></li>
                            <li><a href=""><i class="ri-bookmark-fill"></i>{{ $blog->category?->front_translate?->name ?? $blog->category?->translate?->name ?? 'Uncategorized' }}</a></li>
                        </ul>
                    </div>
                    <div class="entry-content">
                        <p>
                            {!! clean($blog->front_translate?->description ?? $blog->translate?->description) !!}
                        </p>

                        <div class="Barmagly-single-post-tag-wrap">
                            <div class="Barmagly-blog-tags">
                                <ul>
                                    @if ($blog->tags)
                                        @php
                                            $decoded_tags = json_decode($blog->tags);
                                        @endphp
                                        @if(is_array($decoded_tags) || is_object($decoded_tags))
                                            @foreach ($decoded_tags as $blog_tag)
                                                @if(isset($blog_tag->value))
                                                    <li><a href="javascript:;">{{ $blog_tag->value }}</a></li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="Barmagly-post-navigation">
                            @if($previous)
                                <a href="{{ route('blog', $previous->slug) }}" class="nav-previous">
                                    <i class="ri-arrow-left-line"></i> {{ __('translate.Previous Post') }}
                                </a>
                            @else
                                <span class="nav-previous disabled">
                                    <i class="ri-arrow-left-line"></i>
                                    {{ __('translate.No Previous Post') }}
                                </span>
                            @endif
                            @if($next)
                                <a href="{{ route('blog', $next->slug) }}" class="nav-next">
                                    {{ __('translate.Next Post') }} <i class="ri-arrow-right-line"></i>
                                </a>
                                @else
                                 <span class="nav-next disabled">
                                    {{ __('translate.No Next Post') }}
                                    <i class="ri-arrow-right-line"></i>
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            @include('blog_sidebar')
        </div>
    </div>
</div>
    <!-- End Main Blog Details -->
@endsection

