<x-app-layout>
    <x-slot name="header_content">
        <h1>Tags Details</h1>        
    </x-slot>
    <div>

@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Create New Tag Details</h4>
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
                
                <form action="post_tag_add_details" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}
                    
                    <div class="input-group mb-3">
                        <div class="col-3">Keyword</div>
                        <div class="col-7">
                        <?php echo $datas[0]->keyword; ?>
                        <input type="hidden" id="keywordId" name="keywordId" value="<?php echo $datas[0]->id; ?>" >
                        </div>                          
                    </div>

                    <div class="input-group mb-3">
                        <div class="col-3">Search</div>
                        <div class="col-7">
                            <input type="radio" id="store" name="searchBy" value="store" checked>
                                <label for="store">Store</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="product" name="searchBy" value="product">
                                <label for="product">Product</label>&nbsp;&nbsp;&nbsp;&nbsp; 
                            <input type="radio" id="category" name="searchBy" value="category">
                                <label for="category">Category</label>                            
                        </div>                          
                    </div>

                    <div class="input-group mb-3">
                        <div class="col-3"></div>
                        <div class="col-7">
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="searchKeyword" id="searchKeyword" value="">
                                <div class="input-group-append">
                                    <button class="btn btn-danger" type="button" onclick="searchData()"><i class="fas fa-search"></i> <span>Search</span></button>
                                </div  
                            </div>                          
                        </div>                                              
                    </div>

                    <div id="searchResultList">                        
                    </div>

                    <div class="table-responsive">
                        <table id="table-4" class="table table-striped">        
                            <thead>
                                <tr class="text-center">
                                    <th>Store</th>
                                    <th>Product</th>
                                    <th>Category</th> 
                                    <th>FoodCourt Owner</th>                 
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
                                 <button type="button" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="saveDetails()"><span>Save Details</span> 
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
           
           if (searchBy=="store") {
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
                      showSearchResultStore(resultData);
                   }
                });

            } else if (searchBy=="product") {
                $.ajax({
                   type:'POST',
                   url:'/filter_product',
                   headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type' : 'application/x-www-form-urlencoded'
                    },
                   data:{
                        store_name : searchKeyword,                   
                    },
                   success:function(data) {
                      $("#msg").html(data.productList);
                      //console.log(data);
                      var resultData = data.productList;
                      showSearchResultProduct(resultData);
                   }
                });
            } else if (searchBy=="category") {
                $.ajax({
                   type:'POST',
                   url:'/filter_category',
                   headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type' : 'application/x-www-form-urlencoded'
                    },
                   data:{
                        name : searchKeyword,                   
                    },
                   success:function(data) {
                      $("#msg").html(data.categoryList);
                      //console.log(data);
                      var resultData = data.categoryList;
                      showSearchResultCategory(resultData);
                   }
                });
            }
    }


    function showSearchResultStore(resultData) {
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


      function showSearchResultProduct(resultData) {
          var bodyData = '';
          var i=1;
          $.each(resultData,function(index,row){
            console.log(row);

            bodyData+='<tr class="text-center">';                         
                    bodyData+='<td style="padding: 0">'+row.name+'</td>';                    
                    bodyData+='<td style="padding: 0">'+row.storeName+'</td>';
                    bodyData+='<td style="padding: 0">'+row.storeCity+'</td>';
                    bodyData+='<td style="padding: 0">';                                 
                             bodyData+='<button type="button" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="addProduct(\''+row.id+'\')"><i class="fas fa-plus"></i>';
                            bodyData+='</button>';
                    bodyData+='</td>';                    
            bodyData+='</tr>';
                                             
          })

          var tableData = '<table id="table-4" class="table table-striped" style="font-size:11px !important">';       
                tableData+='<thead>';
                    tableData+='<tr class="text-center">';
                    tableData+='<th>Product Name</th>';
                    tableData+='<th>Store Name</th>';
                    tableData+='<th>Store City</th>';
                    tableData+='<th></th>';
                    tableData+='</tr>';
                tableData+='</thead>';  
           tableData+='<tbody id="filterStoreList">';
           tableData+=bodyData;
                tableData+='</tbody>';
            tableData+='</table>';

          $("#searchResultList").html(tableData);
     }


     function showSearchResultCategory(resultData) {
          var bodyData = '';
          var i=1;
          $.each(resultData,function(index,row){
            console.log(row);

            bodyData+='<tr class="text-center">';                         
                    bodyData+='<td style="padding: 0">'+row.name+'</td>';                    
                    bodyData+='<td style="padding: 0">'+row.verticalCode+'</td>';
                    if (row.parentCategoryId==null) {
                        bodyData+='<td style="padding: 0"></td>';    
                    } else {
                        bodyData+='<td style="padding: 0">'+row.parentCategoryId+'</td>';
                    }                    
                    bodyData+='<td style="padding: 0">';                                 
                             bodyData+='<button type="button" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="addCategory(\''+row.id+'\')"><i class="fas fa-plus"></i>';
                            bodyData+='</button>';
                    bodyData+='</td>';                    
            bodyData+='</tr>';
                                             
          })

          var tableData = '<table id="table-4" class="table table-striped" style="font-size:11px !important">';       
                tableData+='<thead>';
                    tableData+='<tr class="text-center">';
                    tableData+='<th>Category Name</th>';
                    tableData+='<th>Vertical</th>';
                    tableData+='<th>Parent Category</th>';
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


    function addProduct(productId) {
            
            var keywordId = document.getElementById("keywordId").value;

            $.ajax({
               type:'POST',
               url:'/save_tag_details',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    productId : productId,
                    keywordId : keywordId,
                },
               success:function(data) {
                  alert('Details added!');
                  queryDetails();
               }
            });
        }

    function addCategory(categoryId) {
            
            var keywordId = document.getElementById("keywordId").value;

            $.ajax({
               type:'POST',
               url:'/save_tag_details',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    categoryId : categoryId,
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
               url:'/query_tag_details',
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
                   
                    if (row.storeName==null) {
                        bodyData+='<td></td>';
                    }  else {
                        bodyData+='<td>'+row.storeName+'</td>';
                    }  

                    if (row.productName==null) {
                        bodyData+='<td></td>';
                    }  else {
                        bodyData+='<td>'+row.productName+'</td>';
                    }    

                    if (row.categoryName==null) {
                        bodyData+='<td></td>';
                    }  else {
                        bodyData+='<td>'+row.categoryName+'</td>';
                    } 

                    if (row.isFoodCourtOwner==null) {
                        bodyData+='<td></td>';
                    }  else {
                        if (row.isFoodCourtOwner=="1") {
                            bodyData+='<td><input name="isFoodCourtOwner" type="radio" value="'+row.id+'" checked></td>';
                        } else {
                            bodyData+='<td><input name="isFoodCourtOwner" type="radio" value="'+row.id+'"></td>';    
                        }                        
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
               url:'/deletemultiple_tag_details',
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
                   alert('Details deleted!');
                  var resultData = data.storeList;
                  showData(resultData);
               }
            });
        }


    function saveDetails() {
            
            var keywordId = document.getElementById("keywordId").value;
            var checkboxes = document.getElementsByName("isFoodCourtOwner");  

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
               url:'/update_tag_details',
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
                   alert('Details updated!');
                  var resultData = data.storeList;
                  showData(resultData);
               }
            });
        }

    function back() {
        window.location.href="/tag";
    }

    queryDetails();
</script>