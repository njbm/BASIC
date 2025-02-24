

<div class="col mb-3 mb-lg-5 col-lg-3 col-md-4">
    <div class="card card-hover-shadow text-center h-100 statRecord">

        @if($pgBar ?? true)
            <div class="card-progress-wrap">
                <div class="progress card-progress">
                    <div class="progress-bar {{ $pgColor ?? 'bg-secondary' }}" role="progressbar"
                         style="width: {{ $pgValue ?? 100 }}%"
                         aria-valuenow="{{ $pgValue ?? 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        @endif

        <div class="card-body d-flex justify-content-start align-items-center gap-2">
            <div class="">
                <div class="icon icon-lg icon-soft-dark icon-circle">
                    <i class="{{ $icon ?? 'bi bi-send' }}"></i>
                </div>
            </div>
            <div class="">
                <span class="h5 d-flex justify-content-start text-muted mb-1">
                    @if($currency ?? true)
                        {{ $basicControl->currency_symbol ?? '$' }}
                    @endif
                    {{ $amount ?? 0 }}
                </span>
                <span class="fw-semibold ">{{ __($text) ?? __('Last 30 Days Send Money') }}</span>
            </div>
        </div>

    </div>
</div>
