<x-app-layout>
    <x-slot name="header_content">
        <h1>Daily Sales Summary</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Daily Sales Summary</div>
        </div>
    </x-slot>
    <div>
        <x-dashboard-table :days="$days"></x-dashboard-table>
    </div>
</x-app-layout>

<script>

$(document).ready(function () {

    $("#table-1").dataTable({
        "columnDefs": [
            { "sortable": false, "targets": [2,3] }
        ]
    });

    $('#dailySalesModal').on('show.bs.modal', function(e) {

        var date = $(e.relatedTarget).data('date');
        var total_order = $(e.relatedTarget).data('total_order');
        var success_order = $(e.relatedTarget).data('success_order');
        var cancel_order = $(e.relatedTarget).data('cancel_order');
        var amount_earn = $(e.relatedTarget).data('amount_earn');
        var commision = $(e.relatedTarget).data('commision');
        var total_amount = $(e.relatedTarget).data('total_amount');
        var settlement_id = $(e.relatedTarget).data('settlement_id');


        var date2 = (date) ? $('#date2').val(date) : $('#date2').val('N/A');
        var total_order2 = (total_order) ? $('#total_order2').val(total_order) : $('#total_order2').val('N/A');
        var success_order2 = (success_order) ? $('#success_order2').val(success_order) : $('#success_order2').val('N/A');
        var cancel_order2 = (cancel_order) ? $('#cancel_order2').val(cancel_order) : $('#cancel_order2').val('N/A');
        var amount_earn2 = (amount_earn) ? $('#amount_earn2').val(amount_earn) : $('#amount_earn2').val('N/A');
        var commision2 = (commision) ? $('#commision2').val(commision) : $('#commision2').val('N/A');
        var total_amount2 = (total_amount) ? $('#total_amount2').val(total_amount) : $('#total_amount2').val('N/A');
        var settlement_id2 = (settlement_id) ? $('#settlement_id2').val(settlement_id) : $('#settlement_id2').val('N/A');


    });

    $('.daterange-btn').daterangepicker({
        locale: {format: 'MMMM D, YYYY'},
        ranges: {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
    }, function (start, end) {
        $('.daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        $('#date_chosen').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        $('#date_chosen_copy').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    });
    
});


</script>

