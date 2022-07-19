@php
    // var_dump($datas);
    // dd($datas);
@endphp

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
        function saveSequence(rowId) {
            var oForm = document.forms["saveSeq_"+rowId];
            var sequence = document.getElementById("saveSeq_sequence_"+rowId).value;
            var locationId = document.getElementById('selectLocation').value;

            $.ajax({
               type:'POST',
               url:'/edit_featuredproduct',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    id : rowId,
                    sequence : sequence,
                    locationId : locationId,
                },
               success:function(data) {
                 $("#msg").html(data.productList);
                  //console.log(data);
                  var resultData = data.productList;
                  showData(resultData);
               }
            });
        }

        function deleteSequence(rowId) {
            if (!confirm('Are you sure want to delete this product?')) {
                return false;
            }

            var oForm = document.forms["saveSeq_"+rowId];
            var locationId = document.getElementById('selectLocation').value;
            
            $.ajax({
               type:'POST',
               url:'/delete_featuredproduct',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    id : rowId,
                    locationId : locationId,                
                },
               success:function(data) {
                 $("#msg").html(data.productList);
                  //console.log(data);
                  var resultData = data.productList;
                  showData(resultData);
               }
            });
        }

        function addProduct(productId) {
            
            var oForm = document.forms["addProd_"+productId];
            var sequence = document.getElementById("addProd_sequence_"+productId).value;
            var mainLevel = document.getElementById("addProd_check_"+productId).checked;
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
               url:'/add_featuredproduct',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    id : productId,
                    sequence : sequence,
                    mainPage : mainPage,
                    locationId : locationId,
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

        function changeLocation() {
           var locationId = document.getElementById('selectLocation').value;
            $.ajax({
               type:'POST',
               url:'/searchByLocation',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    locationId : locationId
                },
               success:function(data) {
                  $("#msg").html(data.productList);
                  //console.log(data);
                  var resultData = data.productList;
                  showData(resultData);
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
                    bodyData+='<td>'+row.productName+'</td>';
                    bodyData+='<td>'+row.category+'</td>';
                    bodyData+='<td>'+row.storeName+'</td>';
                    if (row.isMainLevel==1) {
                        bodyData+='<td>MainPage / '+row.storeCity+'</td>';
                    } else {
                        bodyData+='<td>'+row.storeCity+'</td>';                            
                    }
                    
                            bodyData+='<input type="hidden" id="saveSeq_id_'+row.id+'" value="'+row.id+'">';
                        bodyData+='<td>';
                            bodyData+='<input type="text" id="saveSeq_sequence_'+row.id+'" value="'+row.sequence+'" class="form-control" >';
                        bodyData+='</td>';
                        bodyData+='<td>';
                             bodyData+='<button type="button" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="saveSequence('+row.id+')"><i class="fas fa-save"></i>';
                                bodyData+='</button>';                                
                        bodyData+='</td>';                        
                    bodyData+='<td>';
                        bodyData+='<button type="button" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="deleteSequence('+row.id+')"><i class="fas fa-window-close"></i>';
                            bodyData+='</button>';
                    bodyData+='</td>';
                bodyData+='</tr>';

                bodyData+='</form>';
                                                 
              })
              $("#productList").html(bodyData);
         }

         function filterProduct() {
           var locationId = document.getElementById('selectLocation').value;
           var selectCategory = document.getElementById('selectCat').value;
           var storeName = document.getElementById('storeName').value;
           var productName = document.getElementById('productName').value;
          // alert(storeName);

            $.ajax({
               type:'POST',
               url:'/filter_product',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    locationId : locationId,
                    selectCategory : selectCategory,
                    store_name : storeName,
                    product_name : productName
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
                                bodyData+='<td style="padding: 0"><input type="checkbox" checked></td>';                            
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
</script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card section">
    <div class="card-header">
        <h4>Featured Product</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <form accept-charset='UTF-8'>
                    {{@csrf_field()}}
            

            <div class="row">
                <div class="col">
                          <div class="input-group mb-3">
                            <select name="selectLocation" id="selectLocation" class="form-control" onchange="changeLocation()">   
                                <option value="">Select Location</option>  
                                <option value="main">Main Page</option>                       
                                @foreach ($locationlist as $location)
                                <option value="{{$location->cityId}}" <?php if ($locationselected==$location->cityId) echo "selected"; ?>>{{$location->cityId}}</option>                            
                                @endforeach
                            </select>                
                        </div>
                         <div class="input-group mb-3">
                            <select name="selectCat" id="selectCat" class="form-control">   
                                <option value="">Select Parent Category</option>                         
                                @foreach ($categorylist as $category)
                                <option value="{{$category->id}}" <?php if ($categoryselected==$category->id) echo "selected"; ?>>{{$category->name}} - {{$category->verticalCode}}</option>                            
                                @endforeach
                            </select>                
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="storeName" id="storeName" class="form-control"  value="" placeholder="Store name">                      
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="productName" id="productName" class="form-control"  value="{{$productname}}" placeholder="Product name">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="button" onclick="filterProduct()"><i class="fas fa-search"></i> <span>Search</span></button>
                            </div>
                        </div>
                   
                </div>
              
            </div>

         </form>

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
                        <th style="width: 10%;">MainPage</th>  
                        <th style="width: 10%;"></th>                       
                    </tr>
                </thead>      
                <tbody id="filterProductList">

                    @foreach ($searchresult as $data)                    
                        <tr class="text-center">
                             <form method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                            <td style="padding: 0">{{ $data->name }}</td>
                            <td style="padding: 0">{{ $data->parentcategory }}</td>
                            <td style="padding: 0">{{ $data->category }}</td>
                            <td style="padding: 0">{{ $data->storeName }}</td>
                            <td style="padding: 0">{{ $data->storeCity }}</td>
                            <td style="padding: 0"> <input type="text" name="sequence" id="addProd_sequence_{{ $data->id }}" value="{{ $data->sequence }}" class="form-control"></td>
                            <td style="padding: 0">
                                     <?php if ($data->sequence=="") { ?>                              
                                     <input type="hidden" name="id" value="{{ $data->id }}">
                                     <button type="button" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="addProduct('{{ $data->id }}')"><i class="fas fa-plus"></i> 
                                    </button>
                                    <?php } ?>
                               
                            </td> 

                            </form>                          
                        </tr>
                    @endforeach

                </tbody>
            </table>

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


        <div class="table-responsive">

            <table id="table-5" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th style="width: 20%;">Product Name</th>
                        <th style="width: 20%;">Category</th>
                        <th style="width: 25%;">Store</th> 
                        <th style="width: 25%;">Location</th> 
                        <th style="width: 10%;">Sequence</th>    
                        <th style="width: 5%;"></th>                         
                        <th style="width: 5%;"></th>                         
                    </tr>
                </thead>      
                <tbody id="productList">

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data->productName }}</td>
                            <td>{{ $data->category }}</td>
                            <td>{{ $data->storeName }}</td>
                            <?php
                            if ($data->isMainLevel==1) {
                                echo '<td>MainPage / '.$data->storeCity.'</td>';
                            } else {
                                echo '<td>'.$data->storeCity.'</td>';
                            }
                            ?>
                            
                            <form action="edit_featuredproduct" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                <td>
                                    <input type="text" name="sequence" value="{{ $data->sequence }}" class="form-control" >
                                </td>
                                <td>                                                                                            
                                     <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-save"></i> 
                                        </button>
                                    
                                </td>
                            </form>
                            <td>
                                <form action="delete_featuredproduct" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data->id }}">
                                     <button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="return confirm('Are you sure want to delete this product?')"><i class="fas fa-window-close"></i> 
                                    </button>
                                </form>
                               
                            </td>                           
                        </tr>
                    @endforeach

                </tbody>
            </table>

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





