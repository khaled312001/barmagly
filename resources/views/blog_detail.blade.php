@php use Modules\Blog\App\Models\Blog; @endphp
@extends('frontend.templates.main_demo_layout')

@section('title')
    <title>{{ $blog->seo_title }}</title>
    <meta name="title" content="{{ $blog->seo_title }}">
    <meta name="description" content="{{ $blog->seo_description }}">

    @php
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

    <meta name="keyword" content="{{ $tags }}">
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
                    <img src="{{ asset($blog->image) }}" alt="Blog Image">
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

