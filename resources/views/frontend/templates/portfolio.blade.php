@extends('master_layout')
@section('new-layout')

    <!-- START GRID SECTION -->
    <!-- Main Start -->
    <div class="Barmagly-breadcrumb"
         style="background-image: url({{ asset($general_setting->breadcrumb_image) }})">
        <div class="container">
            <h1 class="post__title">{{ __('translate.Portfolio') }}</h1>
            <nav class="breadcrumbs">
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('translate.Home') }}</a></li>
                    <li aria-current="page"> {{ __('translate.Portfolio') }}</li>
                </ul>
            </nav>

        </div>
    </div>
    @php
        $isGrid = request()->query('type') === 'grid';
    @endphp

    @if(!$isGrid)
        <div class="section Barmagly-section-padding">
            <div class="container">
                <div class="Barmagly-section-title center">
                    <h2>{{ __('translate.Explore our recent projects') }}</h2>
                </div>
                
                @if(isset($categories) && $categories->count() > 0)
                <div class="portfolio-filters-wrapper">
                    <div class="portfolio-filters">
                        <a href="{{ route('portfolio') }}" 
                           class="portfolio-filter-btn {{ !request()->has('category') || request()->category == 'all' ? 'active' : '' }}"
                           data-category="all">
                            {{ __('translate.All') }}
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('portfolio', ['category' => $category->id]) }}" 
                               class="portfolio-filter-btn {{ request()->category == $category->id ? 'active' : '' }}"
                               data-category="{{ $category->id }}">
                                {{ $category->name ?? $category->translate?->name ?? $category->front_translate->name ?? 'Category' }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="row">
                    @foreach($projects as $project)
                        @if($loop->iteration == 5 || $loop->iteration == 6)
                            <div class="col-xl-8" data-aos="fade-up" data-aos-duration="{{ $loop->iteration * 200 }}">
                                @else
                                    <div class="col-xl-4 col-md-6" data-aos="fade-up"
                                         data-aos-duration="{{ $loop->iteration * 200 }}">
                                        @endif
                                        <div class="Barmagly-portfolio-wrap">
                                            <div class="Barmagly-portfolio-thumb Barmagly-portfolio-thumb-2 Barmagly-portfolio-thumb-main   ">
                                                <img src="{{ asset($project->thumb_image) }}" alt="Image" class="full-img">
                                                @if($project->website_url)
                                                    <a class="Barmagly-portfolio-btn"
                                                       href="{{ $project->website_url }}" target="_blank" rel="noopener noreferrer">
                                                        <span class="p-btn-wraper"><i
                                                                class="ri-arrow-right-up-line"></i></span>
                                                    </a>
                                                @endif
                                                <div class="Barmagly-portfolio-data">
                                                    <h4>{{ $project->title ?? $project->translate->title }}</h4>
                                                    <p>@if($project->category)
                                                            {{ $project->category->name ?? $project->category->translate?->name }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                            </div>

                                        @if($projects->hasPages())
                                            <div class="Barmagly-navigation">
                                                <nav class="navigation pagination center" aria-label="Posts">
                                                    <div class="nav-links">
                                                        @if($projects->onFirstPage())
                                                            <span class="next page-numbers disabled">
                                            <i class="ri-arrow-left-s-line"></i>
                                        </span>
                                            @else
                                                <a class="next page-numbers" href="{{ $projects->previousPageUrl() }}">
                                                    <i class="ri-arrow-left-s-line"></i>
                                                </a>
                                            @endif

                                            @php
                                                $start = max($projects->currentPage() - 2, 1);
                                                $end = min($start + 4, $projects->lastPage());
                                                $start = max(min($start, $projects->lastPage() - 4), 1);
                                            @endphp

                                            @if($start > 1)
                                                <a class="page-numbers" href="{{ $projects->url(1) }}">1</a>
                                                @if($start > 2)
                                                    <span class="page-numbers dots">...</span>
                                                @endif
                                            @endif

                                            @for($i = $start; $i <= $end; $i++)
                                                @if($i == $projects->currentPage())
                                                    <span aria-current="page"
                                                          class="page-numbers current">{{ $i }}</span>
                                                @else
                                                    <a class="page-numbers" href="{{ $projects->url($i) }}">{{ $i }}</a>
                                                @endif
                                            @endfor

                                            @if($end < $projects->lastPage())
                                                @if($end < $projects->lastPage() - 1)
                                                    <span class="page-numbers dots">...</span>
                                                @endif
                                                <a class="page-numbers"
                                                   href="{{ $projects->url($projects->lastPage()) }}">{{ $projects->lastPage() }}</a>
                                            @endif

                                            @if($projects->hasMorePages())
                                                <a class="next page-numbers" href="{{ $projects->nextPageUrl() }}">
                                                    <i class="ri-arrow-right-s-line"></i>
                                                </a>
                                            @else
                                                <span class="next page-numbers disabled">
                                                    <i class="ri-arrow-right-s-line"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </nav>
                                </div>
                            @endif
                </div>
            </div>
        </div>
        <!-- Masonry  End section -->
    @else
        <!-- Grid End section -->
        <div class="section Barmagly-section-padding">
            <div class="container">
                <div class="Barmagly-section-title center">
                    <h2>{{ __('translate.Explore our recent projects') }}</h2>
                </div>
                
                @if(isset($categories) && $categories->count() > 0)
                <div class="portfolio-filters-wrapper">
                    <div class="portfolio-filters">
                        <a href="{{ route('portfolio', ['type' => 'grid']) }}" 
                           class="portfolio-filter-btn {{ !request()->has('category') || request()->category == 'all' ? 'active' : '' }}"
                           data-category="all">
                            {{ __('translate.All') }}
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('portfolio', ['type' => 'grid', 'category' => $category->id]) }}" 
                               class="portfolio-filter-btn {{ request()->category == $category->id ? 'active' : '' }}"
                               data-category="{{ $category->id }}">
                                {{ $category->name ?? $category->translate?->name ?? $category->front_translate->name ?? 'Category' }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="portfolio-grid-modern">
                    @foreach($projects as $project)
                        <div class="portfolio-grid-item" data-aos="fade-up" data-aos-duration="500">
                            <div class="portfolio-card-modern">
                                <div class="portfolio-image-wrapper">
                                    <img src="{{ asset($project->thumb_image) }}" alt="{{ $project->title ?? $project->translate->title }}" class="portfolio-image">
                                    <div class="portfolio-overlay">
                                        @if($project->website_url)
                                            <a class="portfolio-link-btn"
                                               href="{{ $project->website_url }}" target="_blank" rel="noopener noreferrer">
                                                <i class="ri-arrow-right-up-line"></i>
                                                <span>{{ __('translate.Visit Website') }}</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="portfolio-content-modern">
                                    <span class="portfolio-category-modern">
                                        @if($project->category)
                                            {{ $project->category->name ?? $project->category->translate?->name }}
                                        @endif
                                    </span>
                                    <h3 class="portfolio-title-modern">{{ $project->title ?? $project->translate->title }}</h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
    @endif

@endsection

