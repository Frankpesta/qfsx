@php
    $about = getContent('about.content', true);
@endphp
<section class="about-section ptb-80">
    <div class="container">
        <div class="row justify-content-center gy-4">
            <div class="col-xl-5 col-lg-6">
                <div class="about-thumb-area wow fade-in-left" data-wow-duration="1s">
                    <!--<img src="{{ getImage('assets/images/frontend/about/' . @$about->data_values->about_image, '460x415') }}" alt="@lang('about')">-->
                    
                    <video style="width: 100%;" controls autoplay>
                    <source src="QFSmovie.mp4" type="video/mp4">
                    
                    Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            <div class="col-xl-6 offset-xl-1 col-lg-6">
                <div class="about-content-area wow fade-in-right" data-wow-duration="1s">
                    <span class="sub-title">@lang('About Us')</span>
                    <h2 class="title">{{ __($about->data_values->heading) }}</h2>
                    <p>
                    
                    QFSLedgerchain is a leading asset security company dedicated to safeguarding your valuable assets. With our innovative solutions and cutting-edge technology, we provide comprehensive protection for your assets, ensuring their integrity and confidentiality. Our team of experts utilizes advanced encryption and authentication methods to ensure that your assets are shielded from unauthorized access or tampering. Trust QFSLedgerchain to keep your assets secure and provide you with peace of mind in an ever-evolving digital landscape.<br>
                    
                    
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<img style="width: 40%; margin-left: 26%; height: ;" src="./Wapp.jpg">



<!--{{ __($about->data_values->description) }}-->