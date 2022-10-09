<x-app-layout>
    <x-slot name="header_content">
        <h1>Customer Data</h1>        
    </x-slot>
    <div>
        <x-userdata-table :datas="$datas" :custnamechosen="$custnamechosen"></x-userdata-table>
    </div>
</x-app-layout>
<script>

    $(document).ready(function () {
    
    //Product Details PopUp for Incomplete Order
    $('#table-3 tbody').on('click','.viewdetails',function(){
        
        var customerId = $(this).attr('data-id');
        console.log("customerId:"+customerId);
        if(customerId){

        // AJAX request
        var url = "{{ route('getuserdatadetails_incompleteorder',[':customerId']) }}";
        url = url.replace(':customerId',customerId);
        console.log("url:"+url);
        // Empty modal data
        $('#productincompleteinfo tbody').empty();

        $.ajax({
            url: url,
            dataType: 'json',
            success: function(response){

                console.log("response:"+response);
                // Add details
                $('#productincompleteinfo tbody').html(response.html);

                // Display Modal
                $('#IncompleteOrderDetails').modal('show'); 
            }
        });
        }
    });


    //Product Details PopUp for Complete Order
    $('#table-3 tbody').on('click','.viewcompletedetails',function(){
        
        var customerId = $(this).attr('data-id');
        console.log("customerId:"+customerId);
        if(customerId){

        // AJAX request
        var url = "{{ route('getuserdatadetails_completeorder',[':customerId']) }}";
        url = url.replace(':customerId',customerId);
        console.log("url:"+url);
        // Empty modal data
        $('#productcompleteinfo tbody').empty();

        $.ajax({
            url: url,
            dataType: 'json',
            success: function(response){

                console.log("response:"+response);
                // Add details
                $('#productcompleteinfo tbody').html(response.html);

                // Display Modal
                $('#CompleteOrderDetails').modal('show'); 
            }
        });
        }
    });


    //Product Details PopUp for Abandon Cart
    $('#table-3 tbody').on('click','.viewabandondetails',function(){
        
        var customerId = $(this).attr('data-id');
        console.log("customerId:"+customerId);
        if(customerId){

        // AJAX request
        var url = "{{ route('getuserdatadetails_abandoncart',[':customerId']) }}";
        url = url.replace(':customerId',customerId);
        console.log("url:"+url);
        // Empty modal data
        $('#abandoncartinfo tbody').empty();

        $.ajax({
            url: url,
            dataType: 'json',
            success: function(response){

                console.log("response:"+response);
                // Add details
                $('#abandoncartinfo tbody').html(response.html);

                // Display Modal
                $('#AbandonCartDetails').modal('show'); 
            }
        });
        }
    });


    $('.daterange-btn4').daterangepicker({
            locale: {format: 'MMMM D, YYYY'},
            ranges: {
                'Today'       : [moment(), moment()],
                'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
           // startDate: moment().subtract(29, 'days'),
           // endDate  : moment()
        }, function (start, end) {
            $('.daterange-btn4 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            $('#date_chosen4').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            $('#date_chosen4_copy').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        });
        
    });
    
</script>


