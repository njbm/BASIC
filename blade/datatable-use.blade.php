
<x-assets :datatable="true" :counter="true"/>

@push('script')
    <script>
        $(document).on('ready', function () {
            let url = "{{ route('admin.voucher.search') }}";
            initDataTable(url,
                {!! json_encode(['transaction_id','amount','sender','receiver','receiver_mail','status','transaction_at']) !!}
            );

            document.getElementById("filter_button").addEventListener("click", function () {
                applyFilter(url, {
                    filter_trx_id: $('#filter_trx_id').val(),
                    filter_currency: $('#filter_currency').val(),
                    filter_status: $('#filter_status').val(),
                    filter_date: $('#filter_date_range').val()
                });
            });
        });
    </script>
@endpush





<div class="card">
    <div class="card-header card-header-content-md-between">
        <x-datatable.search />

        <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">

        </div>
    </div>
    <x-datatable.table :column="4">
        <x-slot name="thead">
            <tr>
                <th class="table-column-pe-0">
                    <div class="form-check">
                        <input class="form-check-input check-all tic-check" type="checkbox" name="check-all"
                               id="datatableCheckAll">
                        <label class="form-check-label" for="datatableCheckAll"></label>
                    </div>
                </th>
                <th>@lang('Item Id')</th>
                <th>@lang('Category Name')</th>
                <th>@lang('Title')</th>
                <th>@lang('Publish')</th>
                <th>@lang('Status')</th>
                <th>@lang('At')</th>
                <th>@lang('Action')</th>
            </tr>
        </x-slot>
    </x-datatable.table>

</div>