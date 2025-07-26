@push('js-lib')
    @if ($datatable ?? false)
        <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    @endif

    {{-- select allways load after datatable --}}
    @if ($select ?? false)
        <script src="{{ asset('assets/admin/js/jquery.select.min.js') }}"></script>
    @endif
@endpush


@push('script')

    @if ($datatable ?? false)
        <script>
            const noDataImg = "{{ asset('assets/admin/img/oc-error.svg') }}";
            const noDataImgDark = "{{ asset('assets/admin/img/oc-error-light.svg') }}";

            //with select chekbox logic
            function initDataTable(ajaxUrl, columns, tableId = '#datatable') {
                if (!ajaxUrl || !columns.length) return;

                let formattedColumns = columns.map(column => ({
                    data: column,
                    name: column
                }));

                let hasSelect = columns.includes('checkbox');
                console.log(hasSelect)

                let datatableOptions = {
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: ajaxUrl
                    },
                    columns: formattedColumns,
                    language: {
                        zeroRecords: `<div class="text-center p-4">
                            <img class="dataTables-image mb-3" src="${noDataImg}" alt="No Data" data-hs-theme-appearance="default">
                            <img class="dataTables-image mb-3" src="${noDataImgDark}" alt="No Data" data-hs-theme-appearance="dark">
                            <p class="mb-0">No data to show</p>
                        </div>`,
                        processing: `<div><div></div><div></div><div></div><div></div></div>`
                    }
                };

                if (hasSelect) {
                    datatableOptions.select = {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        classMap: {
                            checkAll: '#datatableCheckAll',
                            counter: '#datatableCounter',
                            counterInfo: '#datatableCounterInfo'
                        }
                    };
                }

                HSCore.components.HSDatatables.init($(tableId), datatableOptions);
            }

            //Apply Filter
            function applyFilter(route, filters, tableIndex = 0, ) {
                const datatable = HSCore.components.HSDatatables.getItem(tableIndex);
                if (!datatable) return;

                let queryString = Object.keys(filters)
                    .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(filters[key])}`)
                    .join('&');

                datatable.ajax.url(`${route}?${queryString}`).load();
            }


            //Wihout select checkbox logic 
            function initDataTable(ajaxUrl, columns, tableId = '#datatable', ) {
                if (!ajaxUrl || !columns.length) return;

                let formattedColumns = columns.map(column => ({
                    data: column,
                    name: column
                }));

                HSCore.components.HSDatatables.init($(tableId), {
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: ajaxUrl
                    },
                    columns: formattedColumns,
                    language: {
                        zeroRecords: `<div class="text-center p-4">
                           <img class="dataTables-image mb-3" src="${noDataImg}" alt="No Data" data-hs-theme-appearance="default">
                           <img class="dataTables-image mb-3" src="${noDataImgDark}" alt="No Data" data-hs-theme-appearance="dark">
                           <p class="mb-0">No data to show</p>
                     </div>`,
                        processing: `<div><div></div><div></div><div></div><div></div></div>`
                    }
                });
            }
            
        </script>
    @endif




    <script>
        $(document).ready(function() {
            initCheckboxSelection('#datatableCheckAll', '.row-tic', '#check-all');
            initMultiDelete('.delete-multiple', "{{ route('admin.user.delete.multiple') }}");
        });

        /**
         * Initialize checkbox selection logic
         * @param {string} checkAllSelector - The selector for the "Select All" checkbox
         * @param {string} rowCheckboxSelector - The selector for row checkboxes
         * @param {string} checkAllControl - The selector for the control checkbox
         */
        function initCheckboxSelection(checkAllSelector, rowCheckboxSelector, checkAllControl) {
            $(document).on('click', checkAllSelector, function() {
                $(rowCheckboxSelector).prop('checked', this.checked);
            });

            $(document).on('change', rowCheckboxSelector, function() {
                let total = $(rowCheckboxSelector).length;
                let checked = $(rowCheckboxSelector + ":checked").length;
                $(checkAllControl).prop('checked', total === checked);
            });
        }

        /**
         * Initialize multi-delete functionality
         * @param {string} deleteButtonSelector - The selector for the delete button
         * @param {string} deleteUrl - The URL for the delete request
         */
        function initMultiDelete(deleteButtonSelector, deleteUrl) {
            $(document).on('click', deleteButtonSelector, function(e) {
                e.preventDefault();

                let selectedIds = $(".row-tic:checked").map(function() {
                    return $(this).attr('data-id');
                }).get();

                if (selectedIds.length === 0) {
                    alert("No items selected.");
                    return;
                }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: deleteUrl,
                    type: "POST",
                    data: {
                        strIds: selectedIds
                    },
                    dataType: 'json',
                    success: function() {
                        location.reload();
                    },
                    error: function() {
                        alert("Something went wrong!");
                    }
                });
            });
        }
    </script>

@endpush
