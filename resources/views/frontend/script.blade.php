@if ($general_setting->cookie_consent_status == 1)
    <!-- common-modal start  -->
    <div class="common-modal cookie_consent_modal d-none bg-white">
        <button type="button" class="btn-close cookie_consent_close_btn" aria-label="Close"></button>

        <h5>{{ __('translate.Cookies') }}</h5>
        <p>{{ $general_setting->cookie_consent_message }}</p>


        <a href="javascript:;"
           class="td_btn td_style_1 td_type_3 td_radius_30 td_medium td_fs_14 report-modal-btn cookie_consent_accept_btn">
                                        <span class="td_btn_in td_accent_color">
                                        <span>{{ __('translate.Accept') }}</span>
                                        </span>
        </a>

    </div>
    <!-- common-modal end  -->
@endif


{{-- Tawk Chat Disabled --}}
{{-- @if ($general_setting->tawk_status == 1)
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = '{{ $general_setting->tawk_chat_link }}';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
@endif --}}



<!-- Critical JavaScript - Load immediately -->
<script src="{{ asset('global/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/menu/menu.js') }}"></script>

<!-- Non-critical JavaScript - Defer loading -->
<script defer src="{{ asset('global/select2/select2.min.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/slick.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/countdown.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/skillbar.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/slick-animation.min.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/faq.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/isotope.pkgd.min.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/tabs-slider.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/top-to-bottom.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/aos.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/cart.js') }}"></script>
<script defer src="{{ asset('frontend/assets/js/app.js') }}"></script>
<script defer src="{{ asset('global/toastr/toastr.min.js') }}"></script>


<script>
    (function($) {
        "use strict";
        $(document).ready(function () {

            const session_notify_message = @json(Session::get('message'));
            const demo_mode_message = @json(Session::get('demo_mode'));

            if(session_notify_message != null){
                const session_notify_type = @json(Session::get('alert-type', 'info'));
                switch (session_notify_type) {
                    case 'info':
                        toastr.info(session_notify_message);
                        break;
                    case 'success':
                        toastr.success(session_notify_message);
                        break;
                    case 'warning':
                        toastr.warning(session_notify_message);
                        break;
                    case 'error':
                        toastr.error(session_notify_message);
                        break;
                }
            }

            if(demo_mode_message != null){
                toastr.warning("{{ __('translate.All Language keywords are not implemented in the demo mode') }}");
                toastr.info("{{ __('translate.Admin can translate every word from the admin panel') }}");
            }

            const validation_errors = @json($errors->all());

            if (validation_errors.length > 0) {
                validation_errors.forEach(error => toastr.error(error));
            }


            $("#currency_dropdown").on("change", function(){
                $("#currency_form").submit();
            });

            $("#language_dropdown").on("change", function(){
                $("#language_form").submit();
            });


            $(document).on('click', '.cart-add-btn', function (e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                var quantity = $('input[name="quantity"]').val() || 1;
                var $this = $(this);

                // Create Form Data
                let formData = new FormData();
                formData.append('product_id', productId);
                formData.append('quantity', quantity);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('cart.add') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $this.attr("disabled", true);
                    },
                    complete: function () {
                        $this.attr("disabled", false);
                    },
                    success: function (response) {
                        if (response.success) {
                            $('.cart-count').text(response.totalCartItem);

                            toastr.success("{{ __('translate.Cart Added Successfully') }}");
                        } else {
                            toastr.error("{{ __('translate.Something Went Wrong') }}");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX error:", xhr.responseText);
                    }
                });
            });

            let $searchForm = $("#searchForm"),
                $searchInput = $("#searchInput"),
                $searchButton = $("#header-search"),
                $closeButton = $(".Barmagly-header-search-close"),
                $searchSection = $(".Barmagly-header-search-section");

            // Handle search button click
            $searchButton.on("click", function() {
                if ($searchInput.val().trim()) {
                    $searchForm.submit();
                }
            });

            // Handle Enter key press
            $searchInput.on("keypress", function(e) {
                if (e.key === "Enter" && $searchInput.val().trim()) {
                    e.preventDefault();
                    $searchForm.submit();
                }
            });

            // Handle close button click
            $closeButton.on("click", function() {
                $searchSection.hide();
                $searchInput.val("");
            });


            if (localStorage.getItem('Barmagly-cookie') != '1') {
                $('.cookie_consent_modal').removeClass('d-none');
            }

            $('.cookie_consent_close_btn').on('click', function () {
                $('.cookie_consent_modal').addClass('d-none');
            });

            $('.cookie_consent_accept_btn').on('click', function () {
                localStorage.setItem('Barmagly-cookie', '1');
                $('.cookie_consent_modal').addClass('d-none');
            });

            // Portfolio Filter Functionality for Homepage
            // Only apply client-side filtering if portfolio-item elements exist (homepage)
            // Otherwise, allow normal navigation (portfolio page)
            $('.portfolio-filter-btn').on('click', function(e) {
                // Check if we're on a page with portfolio-item elements (homepage)
                if ($('.portfolio-item').length > 0) {
                    e.preventDefault();
                    var category = $(this).data('category');
                    
                    // Update active button
                    $('.portfolio-filter-btn').removeClass('active');
                    $(this).addClass('active');
                    
                    // Filter portfolio items
                    if (category === 'all') {
                        $('.portfolio-item').fadeIn(300);
                    } else {
                        $('.portfolio-item').each(function() {
                            if ($(this).data('category') == category) {
                                $(this).fadeIn(300);
                            } else {
                                $(this).fadeOut(300);
                            }
                        });
                    }
                }
                // If no portfolio-item elements, allow normal link navigation (portfolio page)
            });


        });

        // Force RTL Navbar
        @if(Session::get('lang_dir', 'right_to_left') == 'right_to_left')
        (function() {
            function applyRTLNavbar() {
                var navbars = document.querySelectorAll('.site-navbar');
                navbars.forEach(function(navbar) {
                    if (navbar) {
                        navbar.style.setProperty('flex-direction', 'row-reverse', 'important');
                        navbar.style.setProperty('direction', 'rtl', 'important');
                        navbar.style.setProperty('justify-content', 'flex-start', 'important');
                        
                        var brandLogo = navbar.querySelector('.brand-logo');
                        if (brandLogo) {
                            brandLogo.style.setProperty('order', '999', 'important');
                            brandLogo.style.setProperty('margin-right', '35px', 'important');
                            brandLogo.style.setProperty('margin-left', '0', 'important');
                        }
                        
                        var menuWrapper = navbar.querySelector('.menu-block-wrapper');
                        if (menuWrapper) {
                            menuWrapper.style.setProperty('order', '998', 'important');
                            menuWrapper.style.setProperty('flex', '1', 'important');
                        }
                        
                        var headerBtn = navbar.querySelector('.header-btn');
                        if (headerBtn) {
                            headerBtn.style.setProperty('order', '997', 'important');
                        }
                        
                        var mobileTrigger = navbar.querySelector('.mobile-menu-trigger');
                        if (mobileTrigger) {
                            mobileTrigger.style.setProperty('order', '996', 'important');
                        }
                    }
                });
                
                // Reverse menu items order
                var menuMain = document.querySelectorAll('.site-menu-main');
                menuMain.forEach(function(menu) {
                    if (menu) {
                        menu.style.setProperty('flex-direction', 'row-reverse', 'important');
                        menu.style.setProperty('direction', 'rtl', 'important');
                        menu.style.setProperty('justify-content', 'flex-start', 'important');
                        
                        // Get all menu items and reverse their order
                        var items = Array.from(menu.querySelectorAll('.nav-item'));
                        if (items.length > 0) {
                            // Reverse order: first item gets highest order number (appears on right)
                            items.forEach(function(item, index) {
                                var reverseOrder = items.length - index;
                                item.style.setProperty('order', reverseOrder, 'important');
                            });
                        }
                    }
                });
            }
            
            // Apply immediately
            applyRTLNavbar();
            
            // Apply after DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', applyRTLNavbar);
            }
            
            // Apply after a short delay to override any other scripts
            setTimeout(applyRTLNavbar, 100);
            setTimeout(applyRTLNavbar, 500);
        })();
        @endif
    })(jQuery);

</script>
