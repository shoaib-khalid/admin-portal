<x-app-layout>
    <x-slot name="header_content">
        <h1>Create New Voucher</h1>        
    </x-slot>
    <div>
        <x-voucheradd-table></x-voucheradd-table>
    </div>
</x-app-layout>
<script>

    $(document).ready(function () {
    
   
    $('.daterange-btn4').daterangepicker({
            locale: {format: 'YYYY-MM-DD HH:mm'},
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),            
        });
       
        
    });
    
</script>