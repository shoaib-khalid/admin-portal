<x-app-layout>
    <x-slot name="header_content">
        <h1>Daily Details Sales</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Daily Details Sales</div>
        </div>
    </x-slot>
    <div>
        <x-daily-group-details-table :datas="$datas" :datechosen="$datechosen" :selectedService="$selectedService" :selectedChannel="$selectedChannel"></x-daily-group-details-table>
    </div>
</x-app-layout>


<script>

   

    $(document).ready(function () {
    
        $("#table-2").dataTable({
        "columnDefs": [
            { "sortable": false, "targets": [2,3] }
        ]
        });

        $('#exampleModal').on('show.bs.modal', function(e) {

            var cust_name = $(e.relatedTarget).data('cust_name');
            var date = $(e.relatedTarget).data('date');
            var merchant_name = $(e.relatedTarget).data('merchant_name');
            var store_name = $(e.relatedTarget).data('store_name');
            var sub_total = $(e.relatedTarget).data('sub_total');
            var total = $(e.relatedTarget).data('total');
            var service_charge = $(e.relatedTarget).data('service_charge');
            var delivery_charge = $(e.relatedTarget).data('delivery_charge');
            var order_status = $(e.relatedTarget).data('order_status');
            var delivery_status = $(e.relatedTarget).data('delivery_status');
            var commision = $(e.relatedTarget).data('commision');

            var cust_name = (cust_name!= null) ? $('#cust_name').val(cust_name) : $('#cust_name').val('N/A');
            var date = (date!= null) ? $('#date').val(date) : $('#date').val('N/A');
            var merchant_name = (merchant_name!= null) ? $('#merchant_name').val(merchant_name) : $('#merchant_name').val('N/A');
            var store_name = (store_name!= null) ? $('#store_name').val(store_name) : $('#store_name').val('N/A');
            var sub_total = (sub_total!= null) ? $('#sub_total').val(sub_total) : $('#sub_total').val('N/A');
            var total = (total!= null) ? $('#total').val(total) : $('#total').val('N/A');
            var service_charge = (service_charge!= null) ? $('#service_charge').val(service_charge) : $('#service_charge').val('N/A');
            var delivery_charge = (delivery_charge!= null) ? $('#delivery_charge').val(delivery_charge) : $('#delivery_charge').val('N/A');
            var order_status = (order_status!= null) ? $('#order_status').val(order_status) : $('#order_status').val('N/A');
            var delivery_status = (delivery_status!= null) ? $('#delivery_status').val(delivery_status) : $('#delivery_status').val('N/A');
            var commision = (commision!= null) ? $('#commision').val(commision) : $('#commision').val('N/A');

        });

        // $('#date_chosen2').val("");

        $('.daterange-btn2').daterangepicker({
            locale: {format: 'MMMM D, YYYY'},
            ranges: {
                'Today'       : [moment(), moment()],
                'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            //startDate: moment().subtract(29, 'days'),
            //endDate  : moment()
        }, function (start, end) {
            $('.daterange-btn2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            $('#date_chosen2').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            $('#date_chosen2_copy').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        });


        //Product Details PopUp for Complete Order
        $('#table-2 tbody').on('click','.viewcompletedetails',function(){
            
            var orderGroupId = $(this).attr('data-id');
            console.log("orderGroupId:"+orderGroupId);
            if(orderGroupId){

            // AJAX request
            var url = "{{ route('getordergroup_items',[':orderGroupId']) }}";
            url = url.replace(':orderGroupId',orderGroupId);
            console.log("url:"+url);
            // Empty modal data
            $('#orderItemDetails tbody').empty();

            $.ajax({
                url: url,
                dataType: 'json',
                success: function(response){

                    console.log("response:"+response);
                    // Add details
                    $('#orderItemDetails tbody').html(response.html);

                    // Display Modal
                    $('#GroupOrderItemDetails').modal('show'); 
                }
            });
            }
        });

        
    });
    
</script>