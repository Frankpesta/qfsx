
<style>
.alert-info {
    background-color: #e8f4fd;
    color: #0c5460;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
}

.alert i {
    opacity: 0.8;
}

.alert-link:hover {
    opacity: 0.8;
}

.btn-close {
    opacity: 0.5;
    transition: opacity 0.2s;
}

.btn-close:hover {
    opacity: 0.8;
}
</style>
<div class="col-12">
    <div class="alert alert-{{ $type }} d-flex align-items-center p-4 border-0">
        <div class="me-3">
            @if($type == 'info')
                <i class="fas fa-info-circle fs-2"></i>
            @elseif($type == 'warning')
                <i class="fas fa-exclamation-triangle fs-2"></i>
            @endif
        </div>
        <div class="flex-grow-1">
            <h5 class="alert-heading fw-bold mb-1">{{ $heading }}</h5>
            <p class="mb-2">{{ $message }}</p>
            @if(!empty($link))
                <a href="{{ $link }}" class="alert-link text-decoration-underline fw-medium">
                    {{ $linkText }} <i class="fas fa-arrow-right ms-1"></i>
                </a>
            @endif
        </div>
        <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>



