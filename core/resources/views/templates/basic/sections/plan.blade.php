@php
    $plan = getContent('plan.content', true);
    $plans = App\Models\Plan::where('status', 1)
        ->with('currency')
        ->orderBy('id', 'DESC')
        ->limit(3)
        ->get();
@endphp

<section class="plan-section ptb-80">
    <div class="container">
        <div class="row  gy-4 wow fade-in-bottom" data-wow-duration="1s">
            <div class="col-xl-3 col-lg-12">
                <div class="plan-content-area">
                    <h3 class="title">{{ __(@$plan->data_values->heading) }}</h3>
                    <p>{{ __(@$plan->data_values->subheading) }}</p>
                    <div class="plan-content-btn mt-40">
                        <a href="{{ url(@$plan->data_values->btn_url) }}" class="btn--base">{{ __(@$plan->data_values->btn_name) }}</a>
                    </div>
                    
                </div>
            </div>
            
            
            <div class="col-xl-9 col-lg-12">
                <div class="row gy-4">
                    <!--@include($activeTemplate . 'partials.plan_item', $plans)-->
                    <img style=" " src="./16.png">
                </div>
            </div>
        </div>
    </div>
</section>


<section class="plan-section ptb-80">
    <div class="container">
        <div class="row  gy-4 wow fade-in-bottom" data-wow-duration="1s">
            
            
            <div style="padding-left: 10%;" class="col-xl-9 col-lg-12">
                <div class="row gy-4">
                    <!--@include($activeTemplate . 'partials.plan_item', $plans)-->
                    <img style=" width: 60%; height: ; " src="./U8.png">
                </div>
            </div>
            
            
            
            <div  class="col-xl-3 col-lg-12">
                <div class="plan-content-area">
                    <h3 class="title">Unlock the Power of Secure Asset Management</h3>
                    <p>At QFSledgerchain, we specialize in providing top-notch secure asset management solutions. With our cutting-edge technology and expertise, we enable individuals and businesses to confidently store, trade, and transfer their digital assets.
                    </p>
                    <div class="plan-content-btn mt-40">
                        <a href="{{ url(@$plan->data_values->btn_url) }}" class="btn--base">Connect Ledger</a>
                    </div>
                    
                </div>
            </div>
            
            
            
        </div>
    </div>
</section>


<section class="plan-section ptb-80">
    <div class="container">
        <div class="row  gy-4 wow fade-in-bottom" data-wow-duration="1s">
            <div class="col-xl-3 col-lg-12">
                <div class="plan-content-area">
                    <h3 class="title">Secure Your Money With Confidence</h3>
                    <p>At QFSLedgerchain, we are committed to establishing benchmarks for sustainable business practices that empower our employees, generate exceptional value for our customers, and offer innovative solutions to the markets and communities we engage with.
                    </p>
                    <div class="plan-content-btn mt-40">
                        <a href="https://qfsledgerchain.com/user/register" class="btn--base">Ledger Live</a>
                    </div>
                    
                </div>
            </div>
            
            
            <div class="col-xl-9 col-lg-12">
                <div class="row gy-4">
                    <!--@include($activeTemplate . 'partials.plan_item', $plans)-->
                    <img style="width: 100%; " src="./Wlive.jpg">
                </div>
            </div>
        </div>
    </div>
</section>
