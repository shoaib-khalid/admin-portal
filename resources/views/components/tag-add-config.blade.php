<x-app-layout>
    <x-slot name="header_content">
        <h1>Tags Configs</h1>        
    </x-slot>
    <div>

@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Create New Tag Config</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="row">
            <div class="col-12">
                
                <form action="save_tag_config" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}
                    
                    <div class="input-group mb-3">
                        <div class="col-3">Keyword</div>
                        <div class="col-7">
                        <?php echo $datas[0]->keyword; ?>
                        <input type="hidden" id="keywordId" name="keywordId" value="<?php echo $datas[0]->id; ?>" >
                        </div>                          
                    </div>

                    <div class="input-group mb-3">
                        <div class="col-3">Property</div>
                        <div class="col-7">
                            <input type="radio" id="title" name="prop" value="title" checked onchange="handleChange(this);">
                                <label for="title">Title</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="type" name="prop" value="type" onchange="handleChange(this);">
                                <label for="type">Type</label>&nbsp;&nbsp;&nbsp;&nbsp; 
                            <input type="radio" id="bannerMobile" name="prop" value="bannerMobile" onchange="handleChange(this);">
                                <label for="bannerMobile">Banner Mobile</label>&nbsp;&nbsp;&nbsp;&nbsp;    
                            <input type="radio" id="bannerDesktop" name="prop" value="banner" onchange="handleChange(this);">
                                <label for="bannerDesktop">Banner Desktop</label>&nbsp;&nbsp;&nbsp;&nbsp;   
                             <input type="radio" id="sessionTimeout" name="prop" value="sessionTimeout" onchange="handleChange(this);">
                                <label for="sessionTimeout">Session Timeout (in minutes)</label>                         
                        </div>                          
                    </div>


                    <div class="input-group mb-3">
                        <div class="col-3">Content</div>
                        <div class="col-7" id="selectType" style="display:none">
                                <input type="radio" id="foodcourt" name="typeContent" value="foodcourt" checked>
                                <label for="foodcourt">foodcourt</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="restaurant" name="typeContent" value="restaurant">
                                <label for="restaurant">restaurant</label>&nbsp;&nbsp;&nbsp;&nbsp;                                                             
                        </div> 
                        <div class="col-7" id="inputType" style="">
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="txtContent" id="txtContent" value="">                                
                            </div>                          
                        </div>                                               
                    </div>

                     <div class="input-group mb-3">
                        <div class="col-3">Upload File</div>
                        <div class="col-7">
                            <div class="input-group mb-3">
                                <input type="file" name="selectFile">
                                
                                    <button class="btn btn-success" type="submit"><i class="fas fa-search"></i> <span>Save</span></button>
                                
                            </div>                          
                        </div>                                              
                    </div>

                    <div id="searchResultList">                        
                    </div>

                    <div class="table-responsive">
                        <table id="table-4" class="table table-striped">        
                            <thead>
                                <tr class="text-center">
                                    <th>Property</th>
                                    <th>Content</th>
                                    <th></th> 
                                    </th>                         
                                </tr>
                              
                            </thead>      
                            <tbody  id="detailsList">                               
                            </tbody>
                        </table>
                    </div>

                    <div class="input-group mb-3">
                         <div class="col-12">
                          
                            <div class="w-full flex flex-row justify-end">
                                 <button type="button" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="deleteMultiple()"><span>Delete Details</span> 
                                 </button>
                            </div>
                        </div>                                    
                    </div>
                    
                </form>
            </div>
            <div class="col-1">
                
            </div>
            
        </div>       

    </div>
</div>

    </div>
</x-app-layout>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">

    function searchData() {
            var searchBy = "";
           const collection =  document.getElementsByName('searchBy');
           for (let i = 0; i < collection.length; i++) {
              if (collection[i].id == "store" && collection[i].checked) {
                searchBy = "store";
              } else  if (collection[i].id == "category" && collection[i].checked) {
                searchBy = "category";
              } else  if (collection[i].id == "product" && collection[i].checked) {
                searchBy = "product";
              }
            }
           console.log(collection);
           //var selectCategory = document.getElementById('selectCategory').value;
           var searchKeyword = document.getElementById('searchKeyword').value;
           console.log(searchBy+":"+searchKeyword);
           
            $.ajax({
               type:'POST',
               url:'/filter_store',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    store_name : searchKeyword,                   
                },
               success:function(data) {
                  $("#msg").html(data.storeList);
                  //console.log(data);
                  var resultData = data.storeList;
                  showSearchResult(resultData);
               }
            });
         }


    function showSearchResult(resultData) {
          var bodyData = '';
          var i=1;
          $.each(resultData,function(index,row){
            console.log(row);

            bodyData+='<tr class="text-center">';                         
                    bodyData+='<td style="padding: 0">'+row.storeName+'</td>';                    
                    bodyData+='<td style="padding: 0">'+row.storeCity+'</td>';
                    bodyData+='<td style="padding: 0"><input type="checkbox" id="addStore_check_'+row.id+'"></td>';
                    bodyData+='<td style="padding: 0">';                                 
                             bodyData+='<button type="button" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="addStore(\''+row.id+'\')"><i class="fas fa-plus"></i>';
                            bodyData+='</button>';
                    bodyData+='</td>';                    
            bodyData+='</tr>';
                                             
          })

          var tableData = '<table id="table-4" class="table table-striped" style="font-size:11px !important">';       
                tableData+='<thead>';
                    tableData+='<tr class="text-center">';
                    tableData+='<th>Store Name</th>';
                    tableData+='<th>City</th>';
                    tableData+='<th></th>';
                    tableData+='<th></th>';
                    tableData+='</tr>';
                tableData+='</thead>';  
           tableData+='<tbody id="filterStoreList">';
           tableData+=bodyData;
                tableData+='</tbody>';
            tableData+='</table>';

          $("#searchResultList").html(tableData);
     }


     function addStore(storeId) {
            
            var keywordId = document.getElementById("keywordId").value;

            $.ajax({
               type:'POST',
               url:'/save_tag_details',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    storeId : storeId,
                    keywordId : keywordId,
                },
               success:function(data) {
                  alert('Details added!');
                  queryDetails();
               }
            });
        }

     function queryDetails() {
            
            var keywordId = document.getElementById("keywordId").value;

            $.ajax({
               type:'POST',
               url:'/query_tag_config',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    keywordId : keywordId,
                },
               success:function(data) {
                  var resultData = data.storeList;
                  showData(resultData);
               }
            });
        }

    function showData(resultData) {
              var bodyData = '';
              var i=1;
              $.each(resultData,function(index,row){
                console.log(row);

                bodyData+='<form name="saveSeq_'+row.id+'" id="'+row.id+'" method="post" enctype="multipart/form-data" accept-charset=\'UTF-8\'>{{@csrf_field()}}';
                
                bodyData+='<tr class="text-center">';
                   
                    if (row.property==null) {
                        bodyData+='<td></td>';
                    }  else {
                        bodyData+='<td>'+row.property+'</td>';
                    }  

                    if (row.content==null) {
                        bodyData+='<td></td>';
                    }  else {
                        bodyData+='<td>'+row.content+'</td>';
                    }                                
                                                     
                    bodyData+='<td>';
                        bodyData+='<input type="checkbox" name="delete_details" value="'+row.id+'">';
                    bodyData+='</td>';
                bodyData+='</tr>';

                bodyData+='</form>';
                                                 
              })
              $("#detailsList").html(bodyData);
         }


    function deleteMultiple() {
            if (!confirm('Are you sure want to delete selected store?')) {
                return false;
            }
            var keywordId = document.getElementById("keywordId").value;
            var checkboxes = document.getElementsByName("delete_details");  

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
               url:'/deletemultiple_tag_config',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    ids : rowIds,
                    keywordId : keywordId                           
                },
               success:function(data) {
                 $("#msg").html(data.storeList);
                  //console.log(data);
                   alert('Config deleted!');
                  var resultData = data.storeList;
                  showData(resultData);
               }
            });
        }

    function back() {
        window.location.href="/tag";
    }

    queryDetails();

    function handleChange(src) {
        //alert(src.value);
        var x = document.getElementById("selectType");
        var x2 = document.getElementById("inputType");
        if (src.value=="type") {
            x.style.display = "block";
            x2.style.display = "none";
        } else {
            x.style.display = "none";
            x2.style.display = "block";
        }        
    }
</script>