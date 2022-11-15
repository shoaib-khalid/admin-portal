<x-app-layout>
    <x-slot name="header_content">
        <h1>Tags Featured Product</h1>        
    </x-slot>
    <div>

@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Add Featured Product</h4>
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
                    
                    <input type="hidden" name="keywordId" id="keywordId" value="{{$keywordId}}">
                    <div class="row">
                        <div class="col">
                                  <div class="input-group mb-3">
                                    <select name="storeName" id="storeName" class="form-control" onchange="changeLocation()">   
                                        <option value="">Select Store</option>  
                                        @foreach ($storelist as $store)
                                        <option value="{{$store->storeName}}">{{$store->storeName}}</option>                  
                                        @endforeach
                                    </select>                
                                </div>
                                
                                <div class="input-group mb-3">
                                    <input type="text" name="productName" id="productName" class="form-control"  value="" placeholder="Product name">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" type="button" onclick="filterProduct()"><i class="fas fa-search"></i> <span>Search</span></button>
                                    </div>
                                </div>
                           
                        </div>
                      
                    </div>

                    <div class="table-responsive">
                        <table id="table-4" class="table table-striped" style="font-size:11px !important">        
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 20%;">Product Name</th>
                                    <th style="width: 20%;">Parent Category</th>
                                    <th style="width: 20%;">Category</th>
                                    <th style="width: 20%;">Store</th> 
                                    <th style="width: 20%;">Store Location</th> 
                                    <th style="width: 10%;">Sequence</th>  
                                    <th style="width: 10%;"></th>                       
                                </tr>
                            </thead>      
                            <tbody id="filterProductList">

                            </tbody>
                        </table>
                    </div>

                    <div id="searchResultList">                        
                    </div>

                    <div class="table-responsive">
                        <table id="table-4" class="table table-striped">        
                            <thead>
                                <tr class="text-center">
                                    <th>Product</th>
                                    <th>Sequence</th>
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

 

     function queryDetails() {
            
            var keywordId = document.getElementById("keywordId").value;

            $.ajax({
               type:'POST',
               url:'/query_tag_product',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    keywordId : keywordId,
                },
               success:function(data) {
                  var resultData = data.productList;
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
                   
                    bodyData+='<td>'+row.productName+'</td>';
                    bodyData+='<td>'+row.sequence+'</td>';                                                             
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
               url:'/deletemultiple_tag_product',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    ids : rowIds,
                    keywordId : keywordId                           
                },
               success:function(data) {
                 $("#msg").html(data.productList);
                  //console.log(data);
                   alert('Config deleted!');
                  var resultData = data.productList;
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


    function filterProduct() {
           var storeName = document.getElementById('storeName').value;
           var productName = document.getElementById('productName').value;
           var tagId = document.getElementById("keywordId").value;
           
            $.ajax({
               type:'POST',
               url:'/filter_tag_product',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    store_name : storeName,
                    product_name : productName,
                    tagId : tagId
                },
               success:function(data) {
                  $("#msg").html(data.productList);
                  //console.log(data);
                  var resultData = data.productList;
                  showFilterProduct(resultData);
               }
            });
         }


          function showFilterProduct(resultData) {
              var bodyData = '';
              var i=1;
              $.each(resultData,function(index,row){
                //console.log(row.stateId+"->"+row.cityName);

                bodyData+='<tr class="text-center">';                         
                        bodyData+='<td style="padding: 0">'+row.name+'</td>';
                        bodyData+='<td style="padding: 0">'+row.parentcategory+'</td>';
                        bodyData+='<td style="padding: 0">'+row.category+'</td>';
                        bodyData+='<td style="padding: 0">'+row.storeName+'</td>';
                        bodyData+='<td style="padding: 0">'+row.storeCity+'</td>';
                        if (row.sequence) {
                            bodyData+='<td style="padding: 0"><input type="text" name="sequence" id="addProd_sequence_'+row.id+'" class="form-control" value="'+row.sequence+'"></td>';
                            bodyData+='<td style="padding: 0"><input type="checkbox"></td>';
                            bodyData+='<td style="padding: 0"></td>';
                        } else {
                            bodyData+='<td style="padding: 0"><input type="text" name="sequence" id="addProd_sequence_'+row.id+'" class="form-control"></td>';
                            bodyData+='<td style="padding: 0"><input type="checkbox" id="addProd_check_'+row.id+'"></td>';
                            bodyData+='<td style="padding: 0">';                                 
                                 bodyData+='<button type="button" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="addProduct(\''+row.id+'\')"><i class="fas fa-plus"></i>';
                                bodyData+='</button>';
                            bodyData+='</td>';
                        }

                        
                        bodyData+='</form>';                
                bodyData+='</tr>';
                                                 
              })
              $("#filterProductList").html(bodyData);
         }


         function addProduct(productId) {
            
            var oForm = document.forms["addProd_"+productId];
            var sequence = document.getElementById("addProd_sequence_"+productId).value;
            var tagId = document.getElementById('keywordId').value;

            if (sequence=="") {
                alert("Please insert sequence");
                return false;
            }

            $.ajax({
               type:'POST',
               url:'/save_tag_product',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    productId : productId,
                    sequence : sequence,
                    tagId : tagId                    
                },
               success:function(data) {
                  $("#msg").html(data.productList);
                  //console.log(data);
                  var resultData = data.productList;
                  showData(resultData);
                  alert('Product added!')
               }
            });
        }


</script>