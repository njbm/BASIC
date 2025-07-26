
{{--<div class="list-group list-group-flush list-group-no-gutters showCharge">--}}

<div class="list-group-item">
    <div class="d-flex align-items-center">
        <div class="flex-grow-1 ms-2">
            <div class="row align-items-center">
                <div class="col">
                    <span class="d-block">{{ __($label) }}</span>
                </div>
                <div class="col-auto">
                    <span class=" {{ $class ?? '' }}">{{ $value }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
