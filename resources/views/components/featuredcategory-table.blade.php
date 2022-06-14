@php
    // var_dump($datas);
    // dd($datas);
@endphp

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
         function searchByVertical() {
           var vertical = document.getElementById('selectVertical').value;
            $.ajax({
               type:'POST',
               url:'/searchByVertical',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    vertical : vertical
                },
               success:function(data) {
                  $("#msg").html(data.cityList);
                  //console.log(data);
                  var resultData = data.cityList;
                  var bodyData = '';
                  var i=1;
                  $.each(resultData,function(index,row){
                    //console.log(row.stateId+"->"+row.cityName);

                    bodyData+='<form action="edit_featuredcategory" method="post" enctype="multipart/form-data" accept-charset="UTF-8">{{@csrf_field()}}';
                    bodyData+='<tr class="text-center">';
                    bodyData+='<td>'+row.verticalCode+'</td>';
                   
                    if (row.stateId==undefined) {
                        bodyData+='<td></td>';
                    } else {
                        bodyData+='<td>'+row.stateId+'</td>';    
                    }
                    if (row.cityName==undefined) {
                        bodyData+='<td></td>';
                    } else {
                        bodyData+='<td>'+row.cityName+'</td>';    
                    }
                    
                    bodyData+='<td>'+row.categoryName+'</td>';                   
                        bodyData+='<td><input type="hidden" name="id" value="'+row.id+'">';
                        bodyData+='<input type="text" name="sequence" value="'+row.sequence+'" class="form-control" >';
                        bodyData+='</td>';
                        bodyData+='<td><div class="input-group-append"><button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-save"></i></button></div></td>';                        
                        bodyData+='<td></td>';                        
                    bodyData+='</tr>';
                    bodyData+='</form>';
                  })
                  $("#areaList").html(bodyData);
               }
            });
         }
      </script>

<script>
         function searchCityCategory() {
           var city = document.getElementById('selectCity').value;
            $.ajax({
               type:'POST',
               url:'/searchCityCategory',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    city : city
                },
               success:function(data) {
                  $("#msg").html(data.cityList);
                  //console.log(data);
                  var resultData = data.cityList;
                  var bodyData = '';
                  var i=1;
                  $.each(resultData,function(index,row){
                    console.log(row.userCityName+"->"+row.userCityName);
                    bodyData+='<tr class="text-center">';
                    bodyData+='<td>'+row.verticalCode+'</td>';
                    bodyData+='<td>'+row.stateId+'</td>';
                    bodyData+='<td>'+row.cityName+'</td>';
                    bodyData+='<td>'+row.categoryName+'</td>';
                    bodyData+='<form action="edit_featuredcategory" method="post" enctype="multipart/form-data" accept-charset=\'UTF-8\'>{{@csrf_field()}}';
                        bodyData+='<td><input type="hidden" name="id" value="'+row.id+'">';
                        bodyData+='<input type="text" name="sequence" value="'+row.sequence+'" class="form-control" >';
                        bodyData+='</td>';
                        bodyData+='<td><div class="input-group-append"><button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-save"></i></button></div></td>';
                        bodyData+='</form>';
                    bodyData+='<td><form action="delete_featuredcategory" method="post" enctype="multipart/form-data" accept-charset=\'UTF-8\'>{{@csrf_field()}}';
                        bodyData+='<input type="hidden" name="id" value="'+row.id+'">';
                        bodyData+='<input type="hidden" name="cityId" value="'+row.cityId+'">';
                        bodyData+='<button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="return confirm(\'Are you sure want to delete this city?\')"><i class="fas fa-window-close"></i></button>';
                        bodyData+='</form>';
                        bodyData+='</td>';
                    bodyData+='</tr">';
                  })
                  $("#areaList").html(bodyData);
               }
            });
         }
      </script>

      <script>
         function filterCity() {
           var stateId = document.getElementById('selectState').value;
            $.ajax({
               type:'POST',
               url:'/filterCity',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    stateId : stateId
                },
               success:function(data) {
                  var resultData = data.cityList;
                  var bodyData = '';
                  var i=1;
                  $.each(resultData,function(index,row){
                    //console.log(row.id+"->"+row.name);
                    bodyData+="<option value="+row.id+">"+row.regionStateId+" - "+row.name+"</option>";
                  })
                  $("#selectCity").html(bodyData);
               }
            });
         }
      </script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card section">
    <div class="card-header">
        <h4>Category Sequence</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col">
                
                <form action="add_featuredcategory" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}} 

                    <div class="input-group mb-3">
                        <select name="selectVertical" id="selectVertical" class="form-control" onchange="searchByVertical()">   
                            <option value="">Select Vertical</option>                         
                            @foreach ($verticalList as $vertical)
                            <option value="{{$vertical->code}}" <?php if ($verticalSelected==$vertical->code) echo "selected"; ?>>{{$vertical->code}}</option>                            
                            @endforeach
                        </select>                                 
                    </div>

                     <div class="input-group mb-3">
                        <select name="selectState" id="selectState" class="form-control" onchange="filterCity()">   
                            <option value="">Select State</option>                         
                            @foreach ($stateList as $state)
                            <option value="{{$state->id}}" <?php if ($stateSelected==$state->id) echo "selected"; ?>>{{$state->regionCountryId}} - {{$state->name}}</option>                            
                            @endforeach
                        </select>                                 
                    </div> 

                    <div class="input-group mb-3">
                        <select name="selectCity" id="selectCity" class="form-control" onchange="searchCityCategory()">   
                            <option value="">Select City</option>                         
                            @foreach ($cityList as $city)
                            <option value="{{$city->id}}" <?php if ($citySelected==$city->id) echo "selected"; ?>>{{$city->regionStateId}} - {{$city->name}}</option>                            
                            @endforeach
                        </select>                                     
                    </div> 

                    <div class="input-group mb-3">
                        <select name="selectCategory" id="selectCategory" class="form-control" >   
                            <option value="">Select Category</option>                         
                            @foreach ($categoryList as $category)
                            <option value="{{$category->id}}" <?php if ($categorySelected==$category->id) echo "selected"; ?>>{{$category->verticalCode}} - {{$category->name}}</option>                            
                            @endforeach
                        </select>                                     
                    </div> 

                    <div class="input-group mb-3">
                        <input type="text" name="sequence" id="sequence" class="form-control"  value="" placeholder="Sequence">  
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> <span>Add</span></button>
                        </div>
                    </div>
                               
                </form>
            </div>
          
        </div>


        <div class="table-responsive">



        <div class="table-responsive">

            <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th style="width: 10%;">Vertical Code</th>
                        <th style="width: 20%;">State</th>
                        <th style="width: 20%;">City</th>
                        <th style="width: 20%;">Category</th>  
                        <th style="width: 20%;">Sequence</th>     
                        <th style="width: 5%;"></th> 
                        <th style="width: 5%;"></th> 
                    </tr>
                </thead>      
                <tbody id="areaList">

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data['verticalCode'] }}</td>
                            <td>{{ $data['stateId'] }}</td>
                            <td>{{ $data['cityName'] }}</td>
                            <td>{{ $data['categoryName'] }}</td>                            
                            <form action="edit_featuredcategory" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="cityName" value="{{ $data['cityName'] }}">
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <input type="hidden" name="cityId" value="{{ $data['cityId'] }}">
                                <td><input type="text" name="sequence" value="{{ $data['sequence'] }}" class="form-control" ></td>
                                <td>
                                   
                                         <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-save"></i> 
                                        </button>
                                   
                                   
                                </td>
                             </form>                             
                            <td>
                                <?php if ($data['cityName']<>"") { ?>
                                 <form action="delete_featuredcategory" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <input type="hidden" name="cityId" value="{{ $data['cityId'] }}">
                                     <input type="hidden" name="stateId" value="{{ $data['stateId'] }}">
                                     <button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="return confirm('Are you sure want to delete this city?')"><i class="fas fa-window-close"></i> 
                                    </button>
                                </form>
                                <?php } ?>
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





