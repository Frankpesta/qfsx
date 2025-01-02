@php
    $footer = getContent('footer.content', true);
    $subscriber = getContent('subscriber.content', true);
    $counts = getContent('counter.element', false);
    $policys = getContent('policy_pages.element', false);
    $socialIcons = getContent('social_icon.element', false, null, true);
@endphp
<section class="footer-section pt-60">
    <div class="container">
        
    
    <div style="display: flex; flex-wrap: wrap; justify-content: center;">
    <div style="flex: 1; max-width: 200px;">
        <!-- <img style="width: 60%; height: auto; display: block; margin-left: 10%; margin-top: -9%;" src="./app.png" alt="App Image" onclick="showComingSoonAlert()"> -->
    </div>
    <div style="flex: 1; max-width: 200px;">
        <!-- <img style="width: 60%; height: auto; display: block; margin-top: 8%;" src="./play.png" alt="Play Image" onclick="showComingSoonAlert()"> -->
    </div>
</div>

<script>
    function showComingSoonAlert() {
        alert("Coming Soon");
    }
</script>
        
        <div class="footer-wrapper">
            <div class="footer-top-area d-flex flex-wrap align-items-center justify-content-between">
                <div class="footer-logo">
                    <a class="site-logo" href="{{ route('home') }}"><img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('logo')"></a>
                </div>
                <div class="footer-statistics-area">
                    @foreach ($counts as $count)
                        <div class="statistics-item text-end">
                            <div class="statistics-content">
                                <div class="odo-area">
                                    <h3 class="odo-title odometer" data-odometer-final="{{ __($count->data_values->counter_digit) }}">0</h3>
                                </div>
                            </div>
                            <p>{{ __($count->data_values->title) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="footer-middle-area ptb-60">
                <div class="row justify-content-between gy-4">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <h3 class="title">@lang('QFSLedgerChain')</h3>
                            <p>{{ __($footer->data_values->description) }}</p>

                            <div class="social-area">
                                <ul class="footer-social">
                                    @foreach ($socialIcons as $socialIcon)
                                        <li><a href="{{ $socialIcon->data_values->url }}" target="_blank">@php echo $socialIcon->data_values->icon @endphp</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <h3 class="title">@lang('Usefull Link')</h3>
                            <ul class="footer-links">
                                @foreach ($pages as $k => $data)
                                    <li><a href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a></li>
                                @endforeach
                                <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <h3 class="title">@lang('Quick Links')</h3>
                            <ul class="footer-links">
                                @foreach ($policys as $policy)
                                    <li><a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">{{ __($policy->data_values->title) }}</a></li>
                                @endforeach
                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="footer-widget">
                            <h3 class="title">@lang('Get In Touch')</h3>
                            
                            <form class="subscribe-form">
                                <input type="email" name="email" id="emailSub" placeholder="@lang('Email Adress')....">
                                <button type="submit" class="subscribe-btn"><i class="fas fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrapper">
        <div class="container">
            <div class="copyright-area text-center">
                <div class="copyright">
                    <p>@lang('Copyright') &copy; {{ date('2024') }} @lang('All Rights Reserved')</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('script')
    <script>
        (function() {
            'use strict';
            $(document).on('submit', '.subscribe-form', function(e) {
                e.preventDefault();
                var email = $("#emailSub").val();
                if (email) {
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        url: "{{ route('subscribe') }}",
                        method: "POST",
                        data: {
                            email: email
                        },
                        success: function(response) {
                            if (response.success) {
                                notify('success', response.success);
                                $("#emailSub").val('');
                            } else {
                                $.each(response, function(i, val) {
                                    notify('error', val);
                                });
                            }
                        }
                    });
                } else {

                    notify('error', "Please input your email");
                }
            });

        })(jQuery);
    </script>
@endpush
