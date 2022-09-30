<x-app-layout>
    <x-slot name="header_content">
        <h1>Customer Abandon Cart</h1>        
    </x-slot>
    <div>
        <x-userabandoncart-table :datas="$datas" :datechosen="$datechosen" :storename="$storename" :customername="$customername"></x-userabandoncart-table>
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
                    '<th class="font-weight-bold">Product Id</th>' +
                    '<th class="font-weight-bold">Product Name</th>' +
                    '<th class="font-weight-bold">Quantity</th>' +
                '</tr>';

            if(obj){

                store_obj = obj.item_list

                // alert(store_obj.length)

                store_obj.forEach(element => {

                    childTable += '<tr class="bg-light">' +
                        '<td class="">'+element.productId+'</td>' +
                        '<td class="">'+element.name+'</td>' +
                        '<td class="">'+element.quantity+'</td>' +                       
                    '</tr>';

                });

            }else{
                // alert('toasa')
                childTable += '<tr class="bg-light">' +
                                '<td colspan="10" class="text-danger font-weight-bold">No Data Available</td>' +
                            '</tr>';
            }

            //alert(childTable);
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
        'targets' : [3,4,5],
        'className' : 'dt-right',
        'width': '100px',
      },
    ]
  });


  // Add event listener for opening and closing details
  $('#table-4 tbody').on('click', '.view_details', function () {

    var rowId = $(this).attr("rowId");
    var tr = $(this).closest('tr');
    var row = table.row(tr);

    // alert('rowId: ' + rowId)

    // return false

    var newObj = datas.find(x => x.id === rowId)

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
      //alert('open row: ' + row.data())
      row.child(formatTable(row.data(), newObj)).show();
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