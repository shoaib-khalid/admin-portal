<x-app-layout>
    <x-slot name="header_content">
        <h1>Settlement</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Merchants</div>
        </div>
    </x-slot>
    <div>
        <x-settlement2-table :datas="$datas" :datechosen="$datechosen"></x-settlement2-table>
    </div>
</x-app-layout>
<script>

    $(document).ready(function () {
    
        $("#table-5").dataTable({
        "columnDefs": [
            { "sortable": false, "targets": [2,3] }
        ]
        });

        var datas = {!! json_encode($datas) !!};

        // console.log('datas: ', datas)

        
  
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
      null
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


   $('#SettlementDetailsModal').on('show.bs.modal', function(e) {
        var payoutdate = $(e.relatedTarget).data('payoutdate'); 
        var storename = $(e.relatedTarget).data('storename'); 
        var startdate = $(e.relatedTarget).data('startdate'); 
        var cutoffdate = $(e.relatedTarget).data('cutoffdate'); 
        var grossamount = $(e.relatedTarget).data('grossamount');
        var servicecharge = $(e.relatedTarget).data('servicecharge');
        var deliverycharge = $(e.relatedTarget).data('deliverycharge');
        var commission = $(e.relatedTarget).data('commission');
        var nettamount = $(e.relatedTarget).data('nettamount');
        var remarks = $(e.relatedTarget).data('remarks');
        var id = $(e.relatedTarget).data('id');
        $('#spayoutdate').val(payoutdate);
        $('#sstorename').val(storename);
        $('#sstartdate').val(startdate);
        $('#scutoffdate').val(cutoffdate);
        $('#sgrossamount').val(grossamount);
        $('#sservicecharge').val(servicecharge);
        $('#sdeliverycharge').val(deliverycharge);
        $('#scommission').val(commission);
        $('#snettamount').val(nettamount);
        $('#sremarks').val(remarks);
        $('#sid').val(id);
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