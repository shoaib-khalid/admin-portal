@php
    // var_dump($datas);
    // dd($datas);
@endphp
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      
<script>

          function changeLocation() {
           var locationId = document.getElementById('selectLocation').value;
            $.ajax({
               type:'POST',
               url:'/storeSearchByLocation',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    locationId : locationId
                },
               success:function(data) {
                  $("#msg").html(data.storeList);
                  //console.log(data);
                  var resultData = data.storeList;
                  showData(resultData);
               }
            });
         }

         function filterStore() {
           var locationId = document.getElementById('selectLocation').value;
           //var selectCategory = document.getElementById('selectCategory').value;
           var storeName = document.getElementById('storeName').value;
           console.log(storeName);

            $.ajax({
               type:'POST',
               url:'/filter_store',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    locationId : locationId,
                   // selectCategory : selectCategory,
                    store_name : storeName,                    
                },
               success:function(data) {
                  $("#msg").html(data.storeList);
                  //console.log(data);
                  var resultData = data.storeList;
                  showFilterStore(resultData);
               }
            });
         }

         function showData(resultData) {
              var bodyData = '';
              var i=1;
              $.each(resultData,function(index,row){
                //console.log(row.stateId+"->"+row.cityName);

                bodyData+='<form name="saveSeq_'+row.id+'" id="'+row.id+'" method="post" enctype="multipart/form-data" accept-charset=\'UTF-8\'>{{@csrf_field()}}';
                
                bodyData+='<tr class="text-center">';
                    bodyData+='<td>'+row.storeName+'</td>';                    
                    bodyData+='<td>'+row.storeCity+'</td>';                                                
                    
                            bodyData+='<input type="hidden" id="saveSeq_id_'+row.id+'" value="'+row.id+'">';
                        bodyData+='<td>';
                            bodyData+='<input type="text" id="saveSeq_sequence_'+row.id+'" value="'+row.sequence+'" class="form-control" >';
                        bodyData+='</td>';
                         if (row.isMainLevel==1) {
                            bodyData+='<td><input type="checkbox" checked name="isMainLevel" id="isMainLevel_'+row.id+'"></td>';
                        } else {
                            bodyData+='<td><input type="checkbox" name="isMainLevel" id="isMainLevel_'+row.id+'"></td>';
                        }                        
                        bodyData+='<td>';
                             bodyData+='<button type="button" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="saveSequence('+row.id+')"><i class="fas fa-save"></i>';
                                bodyData+='</button>';                                
                        bodyData+='</td>';                        
                    bodyData+='<td>';
                        bodyData+='<input type="checkbox" name="delete_sequence" value="'+row.id+'">';
                    bodyData+='</td>';
                bodyData+='</tr>';

                bodyData+='</form>';
                                                 
              })
              $("#storeList").html(bodyData);
         }

        function showFilterStore(resultData) {
              var bodyData = '';
              var i=1;
              $.each(resultData,function(index,row){
                //console.log(row.stateId+"->"+row.cityName);

                bodyData+='<tr class="text-center">';                         
                        bodyData+='<td style="padding: 0">'+row.storeName+'</td>';
                        bodyData+='<td style="padding: 0">'+row.storeCity+'</td>';
                        if (row.sequence) {
                            bodyData+='<td style="padding: 0"><input type="text" name="sequence" id="addStore_sequence_'+row.id+'" class="form-control" value="'+row.sequence+'"></td>';
                            if (row.isMainLevel==1) {
                                bodyData+='<td style="padding: 0"><input type="checkbox" checked></td>';
                            } else {
                                bodyData+='<td style="padding: 0"><input type="checkbox"></td>';
                            }
                                                        
                            bodyData+='<td style="padding: 0"></td>';
                        } else {
                            bodyData+='<td style="padding: 0"><input type="text" name="sequence" id="addStore_sequence_'+row.id+'" class="form-control"></td>';
                            bodyData+='<td style="padding: 0"><input type="checkbox" id="addStore_check_'+row.id+'"></td>';
                            bodyData+='<td style="padding: 0">';                                 
                                 bodyData+='<button type="button" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="addStore(\''+row.id+'\')"><i class="fas fa-plus"></i>';
                                bodyData+='</button>';
                            bodyData+='</td>';
                        }

                        
                        bodyData+='</form>';                
                bodyData+='</tr>';
                                                 
              })
              $("#filterStoreList").html(bodyData);
         }

       
       function addStore(storeId) {
            
            var oForm = document.forms["addStore_"+storeId];
            var sequence = document.getElementById("addStore_sequence_"+storeId).value;
            var mainLevel = document.getElementById("addStore_check_"+storeId).checked;
            var locationId = document.getElementById('selectLocation').value;

            //alert(mainLevel);
            var mainPage=0;
            if (mainLevel) {
                mainPage=1;
            } else {
                mainPage=0;
            }
            $.ajax({
               type:'POST',
               url:'/add_featuredstore',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    id : storeId,
                    sequence : sequence,
                    mainPage : mainPage,
                    locationId : locationId,
                },
               success:function(data) {
                  $("#msg").html(data.storeList);
                  //console.log(data);
                  var resultData = data.storeList;
                  showData(resultData);
                  alert('Store added!')
               }
            });
        }

       function deleteMultiple() {
            if (!confirm('Are you sure want to delete selected store?')) {
                return false;
            }

            var locationId = document.getElementById('selectLocation').value;
            var checkboxes = document.getElementsByName("delete_sequence");  
            console.log(checkboxes);
            const  rowIds=[];
            var x=0;
            for(var i = 0; i < checkboxes.length; i++)  
            {  
                if(checkboxes[i].checked)  {
                    console.log(checkboxes[i].value); 
                    rowIds[x] = checkboxes[i].value;
                    x++;
                }
            }  

            
            $.ajax({
               type:'POST',
               url:'/deletemultiple_featuredstore',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    ids : rowIds,
                    locationId : locationId,                
                },
               success:function(data) {
                 $("#msg").html(data.storeList);
                  //console.log(data);
                  var resultData = data.storeList;
                  showData(resultData);
               }
            });
        }

         function saveSequence(rowId) {
            var oForm = document.forms["saveSeq_"+rowId];
            var sequence = document.getElementById("saveSeq_sequence_"+rowId).value;
            var isMainLevel = document.getElementById("isMainLevel_"+rowId).checked;
            var locationId = document.getElementById('selectLocation').value;
            console.log(isMainLevel);

            $.ajax({
               type:'POST',
               url:'/edit_featuredstore',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    id : rowId,
                    sequence : sequence,
                    locationId : locationId,
                    isMainLevel : isMainLevel
                },
               success:function(data) {
                 $("#msg").html(data.storeList);
                  //console.log(data);
                  var resultData = data.storeList;
                  showData(resultData);
               }
            });
        }


      </script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card section">
    <div class="card-header">
        <h4>Featured Store</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col">
                
              
                    <div class="input-group mb-3">
                        <select name="selectLocation" id="selectLocation" class="form-control" onchange="changeLocation()">   
                            <option value="">Select Location</option>  
                            <option value="">All Location</option>  
                            <option value="main">Main Page</option>                       
                            @foreach ($locationlist as $location)
                            <option value="{{$location->cityId}}">{{$location->cityId}}</option>                            
                            @endforeach
                        </select>                
                    </div>  
                   <!-- <div class="input-group mb-3">
                        <select name="selectCategory" id="selectCategory" class="form-control">   
                            <option value="">Select Parent Category</option>                         
                            @foreach ($categorylist as $category)
                            <option value="{{$category->id}}" <?php if ($categoryselected==$category->id) echo "selected"; ?>>{{$category->name}} - {{$category->verticalCode}}</option>                            
                            @endforeach
                        </select>                
                    </div>    !-->            
                    <div class="input-group mb-3">
                        <input type="text" name="storeName" id="storeName" class="form-control"  value="{{$storename}}" placeholder="Store name">  
                        <div class="input-group-append">
                            <button class="btn btn-danger" type="button" onclick="filterStore()"><i class="fas fa-search"></i> <span>Search</span></button>
                        </div>
                    </div>
               
            </div>
          
        </div>


        <div class="table-responsive">

            <table id="table-4" class="table table-striped" style="font-size:11px !important">        
                <thead>
                    <tr class="text-center">
                        <th style="width: 20%;">Store Name</th>
                        <th style="width: 20%;">City</th>
                        <th style="width: 10%;">Sequence</th>    
                        <th style="width: 10%;">Main Page</th> 
                        <th style="width: 10%;"></th>                                             
                    </tr>
                </thead>      
                <tbody id="filterStoreList">

                </tbody>
            </table>


        <div class="table-responsive">

            <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th style="width: 30%;">Store</th>
                        <th style="width: 30%;">Location</th>
                        <th style="width: 10%;">Sequence</th>     
                        <th style="width: 10%;">Main Page</th>     
                        <th style="width: 10%;"></th> 
                        <th style="width: 10%;"></th>                 
                        <th style="width: 10%;"></th>
                        <th style="width: 10%;"></th>
                    </tr>
                </thead>      
                <tbody  id="storeList">

                   

                </tbody>
            </table>

             <div class="w-full flex flex-row justify-end">
                 <button type="button" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="deleteMultiple()"><span>Delete Store</span> 
                 </button>
            </div>

            {{-- <div class="row" style="margin-top: 5px;">
                <div class="col">
                    <span>Showing 1 to 1 of 1 entries</span>
                </div>
                <div class="col">
                    <nav aria-label="..." class="float-right">
                        <ul class="pagination">
                            <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div> --}}
            
        </div>
    </div>
</div>





