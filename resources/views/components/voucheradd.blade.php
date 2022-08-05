<x-app-layout>
    <x-slot name="header_content">
        <h1>Create New Voucher</h1>        
    </x-slot>
    <div>
        <x-voucheradd-table :storelist="$storelist" :verticalList="$verticalList"></x-voucheradd-table>
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

     $("#addStore").click(function() {
        var dropDown = document.getElementById("selectStore");
        var selectedStore = dropDown.value; 
        var selectedText = dropDown.options[dropDown.selectedIndex].text
        $("#selectedStoreList").append('<li value='+selectedStore+'>'+selectedText+' <button type="button" class="delete btn btn-danger icon-left btn-icon" onclick="deleteStore(this)">Delete</button><input type="hidden" name="addStoreList[]" value="'+selectedStore+'"/></li>');
     });

  

    });

    function deleteStore(store) {
        store.parentElement.remove();
    }
    
</script>