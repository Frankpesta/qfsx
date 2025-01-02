@php
    $banner = getContent('banner.content', true);
@endphp

<section class="banner-section bg_img" data-background="{{ getImage('assets/images/frontend/banner/' . @$banner->data_values->background_image, '1920x1280') }}">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-xl-6 col-lg-6">
                <div class="banner-content wow fade-in-left" data-wow-duration="1s">
                    <h1 class="title">{{ __($banner->data_values->heading) }}</h1>
                    <p>{{ __($banner->data_values->subheading) }}</p>
                    <div class="banner-btn">
                        <a href="{{ url($banner->data_values->btn_url) }}" class="btn--base">{{ __($banner->data_values->btn_name) }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 position-relative">
                <div class="banner-element wow fade-in-right" data-wow-duration="1s">
                    <img style='width: 100vw; height: 18vh; margin-top: 23%;' src="./jj.png" alt="banner">
                </div>
            </div>
        </div>
    </div>
</section>
