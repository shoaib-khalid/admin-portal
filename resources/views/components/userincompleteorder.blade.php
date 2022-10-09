<x-app-layout>
    <x-slot name="header_content">
        <h1>Customer Incomplete Order</h1>        
    </x-slot>
    <div>
        <x-userincompleteorder-table :datas="$datas" :datechosen="$datechosen"></x-userincompleteorder-table>
    </div>
</x-app-layout>
<script>

    $(document).ready(function () {
    
    // // Add event listener for opening and closing details
    // $('#table-4 tbody').on('click', '.view_store', function () {

    // var clientId = $(this).attr("clientId");
    // var tr = $(this).closest('tr');
    // var row = table.row(tr);

    // // alert('clientId: ' + clientId)

    // // return false

    // var newObj = datas.find(x => x.id === clientId)

    // // alert(JSON.stringify(newObj))

    // // console.log('obj', newObj)

    // // return false;

    // if (row.child.isShown()) {
    // // This row is already open - close it
    // row.child.hide();
    // tr.removeClass('shown');
    // }
    // else
    // {
    // // Open this row
    // row.child(formatTable(row.data(), newObj)).show();
    // tr.addClass('shown');
    // }
    // });

    // $(window).load(function(){
    //      $('#ProductModal').modal('show');
    //   });

    $('#ProductModal').on('show.bs.modal', function(e) {
        console.log("CHECKING PRODCUCTNAME::::",productname);
        var productid = $(e.relatedTarget).data('productid');
        var productname = $(e.relatedTarget).data('productname');
        var productquantity = $(e.relatedTarget).data('productquantity');  
        $('#productid2').val(productid);  
        $('#productname2').val(productname);
        $('#productquantity2').val(productquantity);
        // $('#quantity').val(quantity);
    });


    $('#table-4 tbody').on('click','.viewdetails',function(){
        
        var customerId = $(this).attr('data-id');
        console.log("customerId:"+customerId);
        if(customerId){

        // AJAX request
        var url = "{{ route('getdetails_incompleteorder',[':customerId']) }}";
        url = url.replace(':customerId',customerId);
        console.log("url:"+url);
        // Empty modal data
        $('#productinfo tbody').empty();

        $.ajax({
            url: url,
            dataType: 'json',
            success: function(response){

                console.log("response:"+response);
                // Add details
                $('#productinfo tbody').html(response.html);

                // Display Modal
                $('#ProductModalDetails').modal('show'); 
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