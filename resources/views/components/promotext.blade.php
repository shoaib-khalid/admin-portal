<x-app-layout>
    <x-slot name="header_content">
        <h1>Promo Text</h1>        
    </x-slot>
    <div>
        <x-promotext-table :datas="$datas" :eventlist="$eventlist" :promodata="$promodata" :verticallist="$verticallist"></x-promotext-table>
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
      null,
    ],
    "aaSorting": [],
    'columnDefs': [

        { "sortable": false, "targets": [] },
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