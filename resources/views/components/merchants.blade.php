<x-app-layout>
    <x-slot name="header_content">
        <h1>Merchants</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Merchants</div>
        </div>
    </x-slot>
    <div>
        <x-merchants-table :datas="$datas"></x-merchants-table>
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

        console.log('datas: ', datas)

        function format(rowData) { 
            var childTable = '<tr>' +
                '<td></td>' +
                    '<td>Brown, John</td>' +
                    '<td>Staff</td>' +
                    '<td>50</td>' +
                    '<td>$2,500</td>' +
                    '<td>$1,500</td>' +
                '</tr>'+
                '<tr>' +
                    '<td></td>' +
                    '<td>Smith, Mary</td>' +
                    '<td>Consultant</td>' +
                    '<td>50</td>' +
                    '<td>$2,500</td>' +
                    '<td>$1,000</td>' +
                '</tr>' ;
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
    ],
    'columnDefs': [

        { "sortable": false, "targets": [2,3] },
      {
        'targets': [0],
        'width': 'auto',
      },
      {
        'targets': [1,2],
        'className' : 'dt-left',
      },
      {
        'targets' : [3,4,5],
        'className' : 'dt-right',
        'width': '100px',
      },
    ]
  });


  // Add event listener for opening and closing details
  $('#table-4 tbody').on('click', '.view_store', function () {

    var storeId = $(this).attr("storeId");
    var tr = $(this).closest('tr');
    var row = table.row(tr);

    // alert('storeId: ' + storeId)

    // return false

    var newObj = datas.find(x => x.storeId === storeId)

    console.log('obj', newObj)

    return false;

    if (row.child.isShown()) {
      // This row is already open - close it
      row.child.hide();
      tr.removeClass('shown');
    }
      else
    {
      // Open this row
      row.child(format(row.data())).show();
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
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
        }, function (start, end) {
            $('.daterange-btn4 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            $('#date_chosen4').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            $('#date_chosen4_copy').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        });
        
    });
    
</script>