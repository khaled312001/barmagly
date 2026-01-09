<div class="Barmagly-header-search-section">
    <div class="container">
        <div class="Barmagly-header-search-box">
            <form id="searchForm" action="{{ route('blogs') }}" method="GET">
                <input type="search" name="search" placeholder="{{ __('translate.Search') }}..." id="searchInput">
                <button id="header-search" type="button"><i class="ri-search-line"></i></button>
                <p>{{ __('translate.Type above and press Enter to search. Press Close to cancel.') }}</p>
            </form>
        </div>
    </div>
    <div class="Barmagly-header-search-close">
        <i class="ri-close-line"></i>
    </div>
</div>
