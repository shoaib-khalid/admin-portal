<x-app-layout>
    <x-slot name="header_content">
        <h1>Customer Site Map</h1>        
    </x-slot>
    <div>
        <x-usersitemap-table :datas="$datas" :datechosen="$datechosen" :storename="$storename" :customername="$customername" :device="$device" :browser="$browser"></x-usersitemap-table>
    </div>
</x-app-layout>
<script>

    $(document).ready(function () {

        var datas = {!! json_encode($datas) !!};

    function formatTableOrder(rowData, obj) { 

    // alert(JSON.stringify(obj))

    // return false;
    var childTable;

    childTable = '<tr class="bg-secondary">' +
        '<th class="font-weight-bold">Order Id</th>' +
        '<th class="font-weight-bold">Invoice No</th>' +
        '<th class="font-weight-bold">Created</th>' +
        '<th class="font-weight-bold">Store</th>' +
        '<th class="font-weight-bold">Customer</th>' +
        '<th class="font-weight-bold">Status</th>' +
    '</tr>';

    if(obj){

        store_obj = obj.order_details

        //alert(store_obj)

        
            childTable += '<tr class="bg-light">' +
                '<td class="">'+store_obj.orderId+'</td>' +
                '<td class="">'+store_obj.invoiceNo+'</td>' +
                '<td class="">'+store_obj.created+'</td>' +
                '<td class="">'+store_obj.storeName+'</td>' +
                '<td class="">'+store_obj.customerName+'</td>' +
                '<td class="">'+store_obj.status+'</td>' +
            '</tr>';

    

    }else{
        // alert('toasa')
        childTable += '<tr class="bg-light">' +
                        '<td colspan="10" class="text-danger font-weight-bold">No Order Found</td>' +
                    '</tr>';
    }


    return childTable;
    }

    // Add event listener for opening and closing details
    $('#table-4 tbody').on('click', '.view_order', function () {

    var sessionId = $(this).attr("sessionId");
    var tr = $(this).closest('tr');
    var row = table.row(tr);

    // alert('clientId: ' + clientId)

    // return false

    var newObj = datas.find(x => x.sessionId === sessionId)

    // alert(JSON.stringify(newObj))

    // console.log('obj', newObj)

    // return false;

    if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
        }
    else
        {
        // Open this row
        row.child(formatTableOrder(row.data(), newObj)).show();
        tr.addClass('shown');
        }
    });

    // $('#OrderCompleteModal').on('show.bs.modal', function(e) {
    //     console.log("CHECKING CUSTOMERNAME::::",ostatus);
    //     var created = $(e.relatedTarget).data('created');
    //     var ostatus = $(e.relatedTarget).data('ostatus');
    //     $('#created').val(created);  
    //     $('#ostatus2').val(ostatus);
    //     // $('#quantity').val(quantity);
    // });


    $('#ActivityModal').on('show.bs.modal', function(e) {
        console.log("CHECKING OS::::",os);
        var os = $(e.relatedTarget).data('os');
        var pagevisited = $(e.relatedTarget).data('pagevisited');
        var devicemodel = $(e.relatedTarget).data('devicemodel');
        var created = $(e.relatedTarget).data('created');
        var erroroccur = $(e.relatedTarget).data('erroroccur');
        var errortype = $(e.relatedTarget).data('errortype');
        $('#os2').val(os);
        $('#pagevisited2').val(pagevisited);
        $('#devicemodel2').val(devicemodel); 
        $('#created2').val(created);   
        $('#erroroccur2').val(erroroccur);
        $('#errortype2').val(errortype);
        // $('#quantity').val(quantity);
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