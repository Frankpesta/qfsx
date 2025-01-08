<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 gap-6">
    <div class="dashboard-item">
        @if (!empty($link))
            <a href="{{ $link }}" class="dash-btn">{{ $linkText ?? __('View all') }}</a>
        @endif
        <div class="dashboard-content">
            @if (!empty($icon))
                <div class="dashboard-icon">
                    <img src="{{ asset('./' . $icon) }}" alt="Icon" style="width: 15%;">
                </div>
            @elseif (!empty($iconClass))
                <div class="dashboard-icon">
                    <i class="{{ $iconClass }}"></i>
                </div>
            @endif
            <h5 class="title">{{ $title }} <span class="text--base">{{ $subTitle ?? '' }}</span></h5>
            <h4 class="num mb-0">
                {{ $value }}
                @if (isset($priceChange))
                    <span class="ms-2 {{ $priceChange >= 0 ? 'text-success' : 'text-danger' }}" style="font-weight: 600; font-size: 0.9em;">
                        ({{ $priceChange >= 0 ? '+' : '' }}{{ number_format($priceChange, 2) }}%)
                    </span>
                @endif
            </h4>
            @if (!empty($subValue))
                <h6 class="text-success">{{ $subValue }}</h6>
            @endif
        </div>
    </div>
</div>