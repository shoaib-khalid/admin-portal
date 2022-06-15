<x-app-layout>
    <x-slot name="header_content">
        <h1>Customer Summary</h1>        
    </x-slot>
    <div>
        <x-useractivitysummary-table :datas="$datas" :datechosen="$datechosen" :storename="$storename" :customername="$customername" :device="$device" :browser="$browser" :groupstore="$groupstore" :groupbrowser="$groupbrowser" :groupdevice="$groupdevice" :groupos="$groupos" :grouppage="$grouppage"></x-useractivitysummary-table>
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
    ],
    "aaSorting": [],
    'columnDefs': [

        { "sortable": false, "targets": [0] },
      {
        'targets': [0],
        'width': 'auto',
      },
      {
        'targets': [],
        'className' : 'dt-left',
      },
      {
        'targets' : [0],
        'className' : 'dt-right',
        'width': '100px',
      },
    ]
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