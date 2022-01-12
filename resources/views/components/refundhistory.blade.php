<x-app-layout>
    <x-slot name="header_content">
        <h1>Refund History</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Merchants</div>
        </div>
    </x-slot>
    <div>
        <x-refundhistory-table :datas="$datas" :datechosen="$datechosen"></x-refundhistory-table>
    </div>
</x-app-layout>

<script>

    $(document).ready(function () {
    
        // $("#table-4").dataTable({
        // "columnDefs": [
        //     { "sortable": false, "targets": [2,3] }
        // ]
        // });

        var datas = {!! json_encode($datas) !!};

        // console.log('datas: ', datas)

        function formatTable(rowData, obj) { 

            // alert(JSON.stringify(obj))

            // return false;
            var childTable;

            childTable = '<tr class="bg-secondary">' +
                    '<th class="font-weight-bold">Store Name</th>' +
                    '<th class="font-weight-bold">Store Info</th>' +
                    '<th class="font-weight-bold">Address</th>' +
                    '<th class="font-weight-bold">City</th>' +
                    '<th class="font-weight-bold">Postcode</th>' +
                    '<th class="font-weight-bold">State</th>' +
                    '<th class="font-weight-bold">Email</th>' +
                    '<th class="font-weight-bold">Phone</th>' +
                    '<th class="font-weight-bold">Vertical</th>' +
                    '<th class="font-weight-bold">Delivery Type</th>' +
                '</tr>';

            if(obj){

                store_obj = obj.store_details

                // alert(store_obj.length)

                store_obj.forEach(element => {

                    childTable += '<tr class="bg-light">' +
                        '<td class="">'+element.name+'</td>' +
                        '<td class="">'+element.storeDescription+'</td>' +
                        '<td class="">'+element.address+'</td>' +
                        '<td class="">'+element.city+'</td>' +
                        '<td class="">'+element.postcode+'</td>' +
                        '<td class="">'+element.state+'</td>' +
                        '<td class="">'+element.email+'</td>' +
                        '<td class="">'+element.phone+'</td>' +
                        '<td class="">'+element.verticalCode+'</td>' +
                        '<td class="">'+element.type+'</td>' +
                    '</tr>';

                });

            }else{
                // alert('toasa')
                childTable += '<tr class="bg-light">' +
                                '<td colspan="10" class="text-danger font-weight-bold">No Store Available</td>' +
                            '</tr>';
            }

            
            return childTable;
        }
  
  var table = $('#table-4').DataTable({
    // 'dom' : 't',
    // "bPaginate": true,
    // "bLengthChange": false,
    // "bFilter": true,
    // "bInfo": false,
    // "bAutoWidth": false,
    'columns': [
    //   {
    //     'className': 'details-control',
    //     'orderable': false,
    //     'data': null,
    //     'defaultContent': ''
    //   },
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
    ],
    "aaSorting": [],
    'columnDefs': [

        { "sortable": false, "targets": [0,2,3] },
      {
        'targets': [0],
        'width': 'auto',
      },
      {
        'targets': [1,2],
        'className' : 'dt-left',
      },
      {
        'targets' : [3,4,5,6],
        'className' : 'dt-right',
        'width': '100px',
      },
    ]
  });


  // Add event listener for opening and closing details
  $('#table-4 tbody').on('click', '.view_store', function () {

    var clientId = $(this).attr("clientId");
    var tr = $(this).closest('tr');
    var row = table.row(tr);

    // alert('clientId: ' + clientId)

    // return false

    var newObj = datas.find(x => x.id === clientId)

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
      row.child(formatTable(row.data(), newObj)).show();
      tr.addClass('shown');
    }
  });

        // $('#exampleModal').on('show.bs.modal', function(e) {

        //     var cust_name = $(e.relatedTarget).data('cust_name');
        //     var date = $(e.relatedTarget).data('date');
        //     var merchant_name = $(e.relatedTarget).data('merchant_name');
        //     var store_name = $(e.relatedTarget).data('store_name');
        //     var sub_total = $(e.relatedTarget).data('sub_total');
        //     var total = $(e.relatedTarget).data('total');
        //     var service_charge = $(e.relatedTarget).data('service_charge');
        //     var delivery_charge = $(e.relatedTarget).data('delivery_charge');
        //     var order_status = $(e.relatedTarget).data('order_status');
        //     var delivery_status = $(e.relatedTarget).data('delivery_status');
        //     var commision = $(e.relatedTarget).data('commision');

        //     var cust_name = (cust_name!= null) ? $('#cust_name').val(cust_name) : $('#cust_name').val('N/A');
        //     var date = (date!= null) ? $('#date').val(date) : $('#date').val('N/A');
        //     var merchant_name = (merchant_name!= null) ? $('#merchant_name').val(merchant_name) : $('#merchant_name').val('N/A');
        //     var store_name = (store_name!= null) ? $('#store_name').val(store_name) : $('#store_name').val('N/A');
        //     var sub_total = (sub_total!= null) ? $('#sub_total').val(sub_total) : $('#sub_total').val('N/A');
        //     var total = (total!= null) ? $('#total').val(total) : $('#total').val('N/A');
        //     var service_charge = (service_charge!= null) ? $('#service_charge').val(service_charge) : $('#service_charge').val('N/A');
        //     var delivery_charge = (delivery_charge!= null) ? $('#delivery_charge').val(delivery_charge) : $('#delivery_charge').val('N/A');
        //     var order_status = (order_status!= null) ? $('#order_status').val(order_status) : $('#order_status').val('N/A');
        //     var delivery_status = (delivery_status!= null) ? $('#delivery_status').val(delivery_status) : $('#delivery_status').val('N/A');
        //     var commision = (commision!= null) ? $('#commision').val(commision) : $('#commision').val('N/A');

        // });

        // $('#date_chosen2').val("");

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
    
      $('#RefundHistoryDetailsModal').on('show.bs.modal', function(e) {
        var created = $(e.relatedTarget).data('created');      
        var refundId = $(e.relatedTarget).data('refundid');      
        var invoiceId = $(e.relatedTarget).data('invoiceid'); 
        var storeName = $(e.relatedTarget).data('storename'); 
        var customerName = $(e.relatedTarget).data('customername'); 
        var refundType = $(e.relatedTarget).data('refundtype'); 
        var refundAmount = $(e.relatedTarget).data('refundamount'); 
        var paymentChannel = $(e.relatedTarget).data('paymentchannel'); 
        var refundStatus = $(e.relatedTarget).data('refundstatus'); 
        var remarks = $(e.relatedTarget).data('remarks'); 
        var proof = $(e.relatedTarget).data('proof'); 
        console.log("proof:"+proof);
        $('#created2').val(created);  
        $('#refund_id2').val(refundId);
        $('#invoice_id2').val(invoiceId);
        $('#storename2').val(storeName);
        $('#customer_name2').val(customerName);
        $('#refund_type2').val(refundType);
        $('#refund_amount2').val(refundAmount);
        $('#payment_channel2').val(paymentChannel);
        $('#refund_status2').val(refundStatus);
        $('#remarks2').val(remarks);
        $("#proofimage").attr("src",proof);
   });


</script>