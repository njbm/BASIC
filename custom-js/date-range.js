









//by extra function

function initDateRangePicker(selector, callbackFn, defaultRange = 'Last 7 Days') {
    const ranges = {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
    };

    const start = ranges[defaultRange][0];
    const end = ranges[defaultRange][1];

    function cb(start, end, label) {
        const display = start.format('MMM D') + ' - ' + end.format('MMM D, YYYY');
        const container = typeof selector === 'string' ? $(selector) : selector;
        container.find('.js-daterangepicker-preview').html(display);

        if (typeof callbackFn === 'function') {
            callbackFn(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        }
    }

    $(selector).daterangepicker({
        startDate: start,
        endDate: end,
        ranges: ranges,
    }, cb);

    // Trigger once on load
    cb(start, end, defaultRange);
}





//single page
function cbOs(start, end) {
   $('#js-daterangepicker-statement-predefined .js-daterangepicker-statement-predefined-preview').html(
         start.format('MMM D') + ' - ' + end.format('MMM D, YYYY')
   );
   updatePurchaseChart(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
}
$('#js-daterangepicker-statement-predefined').daterangepicker({
   startDate: moment().subtract(6, 'days'),
   endDate: moment(),
   ranges: {
         'Today': [moment(), moment()],
         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
         'This Month': [moment().startOf('month'), moment().endOf('month')],
         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
   },
}, cbOs);
cbOs(moment().subtract(6, 'days'), moment());