@php
    $currentLang = session()->get('front_lang');
    $ctaContent = getContent('main_demo_cta_section.content', true);
@endphp

<div class="section bg-cover Barmagly-section-padding cta-bg3  {{ Route::is('home') ? 'custom-image-two-home' : 'custom-image-two' }}">
    <div class="container">
        <div class="Barmagly-cta-wrap">
            <div class="Barmagly-cta-content center">
                <h2>{{ getTranslatedValue($ctaContent, 'heading', $currentLang) }}</h2>
                <p>{{ getTranslatedValue($ctaContent, 'description', $currentLang) }}</p>
                <div class="Barmagly-extra-mt" data-aos="fade-up" data-aos-duration="600">
                    <a class="Barmagly-default-btn Barmagly-white-btn" href="{{ route($ctaContent->data_values['button_link']) }}" data-text="{{ getTranslatedValue($ctaContent, 'button_text', $currentLang) }}">
                        <span class="btn-wraper">{{ getTranslatedValue($ctaContent, 'button_text', $currentLang) }}</span> </a>
                </div>
            </div>
        </div>
    </div>
</div>
