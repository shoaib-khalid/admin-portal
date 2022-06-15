<x-app-layout>
    <x-slot name="header_content">
        <h1>Delete Voucher</h1>        
    </x-slot>
    <div>
        <x-voucherdelete-table :voucher="$voucher" :storelist="$storelist"></x-voucherdelete-table>
    </div>
</x-app-layout>
<script>

    $(document).ready(function () {
    
   
    $('.daterange-btn4').daterangepicker({
            locale: {format: 'YYYY-MM-DD HH:mm:ss'},
            timePicker: true,           
        }, function (start, end) {
            $('.daterange-btn4 span').html(start.format('YYYY-MM-DD HH:mm:ss') + ' - ' + end.format('YYYY-MM-DD HH:mm:ss'))
            $('#date_range').val(start.format('YYYY-MM-DD HH:mm:ss') + ' - ' + end.format('YYYY-MM-DD HH:mm:ss'))            
        });
       
        
    $("#store").click(function() {
       if ($(this).is(":checked")) {
          $("#selectStore").prop("disabled", false);
       } 
     });

     $("#deliverin").click(function() {
       if ($(this).is(":checked")) {
          $("#selectStore").prop("disabled", true);
       } 
     }); 

     $("#easydukan").click(function() {
       if ($(this).is(":checked")) {
          $("#selectStore").prop("disabled", true);
       } 
     });

        
    });
    
</script>