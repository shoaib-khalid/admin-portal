<x-app-layout>
    <x-slot name="header_content">
        <h1>Customer Visit Channel</h1>        
    </x-slot>
    <div>
        <x-visitchannel-table :datas="$datas" :datechosen="$datechosen" :storename="$storename" :customername="$customername" :device="$device" :browser="$browser"></x-visitchannel-table>
    </div>
</x-app-layout>
<script>

    $(document).ready(function () {
    
        var datas = {!! json_encode($datas) !!};

        // console.log('datas: ', datas)

        function formatTable(rowData, obj) { 

            // alert(JSON.stringify(obj))

            // return false;
            var childTable;

            childTable = '<tr class="bg-secondary">' +
                    '<th class="font-weight-bold">Created</th>' +
                    '<th class="font-weight-bold">Page Visited</th>' +
                    '<th class="font-weight-bold">OS</th>' +
                    '<th class="font-weight-bold">Device Model</th>' +
                    '<th class="font-weight-bold">Error Occur</th>' +
                    '<th class="font-weight-bold">Error Type</th>' +
                '</tr>';

            if(obj){

                store_obj = obj.activity_list

                // alert(store_obj.length)

                store_obj.forEach(element => {

                    childTable += '<tr class="bg-light">' +
                        '<td class="">'+element.created+'</td>' +
                        '<td class="">'+element.pageVisited+'</td>' +
                        '<td class="">'+element.os+'</td>' +
                        '<td class="">'+element.deviceModel+'</td>' +
                        '<td class="">'+element.errorOccur+'</td>' +
                        '<td class="">'+element.errorType+'</td>' +
                    '</tr>';

                });

            }else{
                // alert('toasa')
                childTable += '<tr class="bg-light">' +
                                '<td colspan="10" class="text-danger font-weight-bold">No Activity Available</td>' +
                            '</tr>';
            }

            
            return childTable;
        }


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

    var newObj = datas.find(x => x.sessionId === clientId)

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