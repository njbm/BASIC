

<div class="col-lg-4">
   <div class="card">
       <div class="card-header card-header-content-between">
           <h4 class="card-header-title">@lang('Transaction Details') </h4>
       </div>

       

status form-check-input remove is-invalid

<label for="Amount" class="form-label">@lang('Amount')</label>

<x-tooltip class="amount-info d-none" />



<x-transaction-details :mobile="true" />


<button id="submit" type="submit" class="btn btn-primary mt-4" disabled>
    @lang('Exchange Money')
</button>


<x-transaction-details :mobile="false" />


<x-assets :flatpickr="false" />




<script>
    function showCharge(response, from_code, to_code) {

        let minLimit = formatAmount(response.min_limit, response.currency_limit);
        let maxLimit = formatAmount(response.max_limit, response.currency_limit);
        let tooltipContent =
            `@lang('Min'): <b>${minLimit}</b> | @lang('Max'): <b>${maxLimit} ${from_code}</b>`;
        updateTooltip('.amount-info', tooltipContent);


        1.add only charge
        2.remove min max from list
        3.rmove tomselect init


    }
</script>
