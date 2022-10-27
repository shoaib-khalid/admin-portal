@php
    // var_dump($datas);
    // dd($datas);
    $selectedCountry = Session::get('selectedCountry');
@endphp

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      
<script>
         function searchCity() {
           var city = document.getElementById('selectCity').value;
            $.ajax({
               type:'POST',
               url:'/searchCity',
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
                    bodyData+='<td>'+row.stateId+'</td>';
                    bodyData+='<td>'+row.userCityName+'</td>';
                    bodyData+='<td>'+row.storeCityName+'</td>';
                    bodyData+='<td><form action="delete_cityregion" method="post" enctype="multipart/form-data" accept-charset=\'UTF-8\'>{{@csrf_field()}}';
                        bodyData+='<input type="hidden" name="id" value="'+row.id+'">';
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
        <h4>City Region</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col">
                
                <form action="add_cityregion" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}} 

                     <div class="input-group mb-3">
                        <select name="selectState" id="selectState" class="form-control" onchange="filterCity()">   
                            <option value="">Select State</option>                         
                            @foreach ($stateList as $state)
                            <option value="{{$state->id}}" <?php if ($stateSelected==$state->id) echo "selected"; ?>>{{$state->regionCountryId}} - {{$state->name}}</option>                            
                            @endforeach
                        </select>                                 
                    </div> 

                    <div class="input-group mb-3">
                        <select name="selectCity" id="selectCity" class="form-control" onchange="searchCity()">   
                            <option value="">Select City</option>                         
                            @foreach ($cityList as $city)
                            <option value="{{$city->id}}" <?php if ($citySelected==$city->id) echo "selected"; ?>>{{$city->regionStateId}} - {{$city->name}}</option>                            
                            @endforeach
                        </select>                                     
                    </div> 

                    <div class="input-group mb-3">
                        <select name="selectNCity" id="selectNCity" class="form-control">   
                            <option value="">Select Neighbour</option>                         
                            @foreach ($cityList as $city)
                            <option value="{{$city->id}}" <?php if ($citySelected==$city->id) echo "selected"; ?>>{{$city->regionStateId}} - {{$city->name}}</option>                            
                            @endforeach
                        </select> 
                        <div class="input-group-append">
                            @if(checkPermission('add_cityregion','POST')) 
                            <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> <span>Add</span></button>
                            @endif
                        </div>               
                    </div>                                   
                </form>
            </div>
          
        </div>
        <div class="input-group mb-3">  
                <div class="col-5"></div>
                    </div>     
                    <form action="filter_cityregion" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}  
                        <div class="input-group mb-3">
                        <div class="col-3">Select By Country</div>
                                <div class="col-2">
                                    <select class="form-control" id="region" name="region">
                                    <option  value="MYS"<?php if ($selectedCountry=="MYS") echo "selected"; ?>>Malaysia</option>
                                    <option  value="PAK"<?php if ($selectedCountry=="PAK") echo "selected"; ?>>Pakistan</option>
                                    </select>
                                </div>
                            <div class="input-group-append">
                                    <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                            </div>  
                        </div>                   
                   </form>


        <div class="table-responsive">



        <div class="table-responsive">

            <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th style="width: 20%;">State</th>
                        <th style="width: 20%;">City</th>
                        <th style="width: 20%;">Neighbour (Max 5 per city)</th>     
                        <th style="width: 20%;"></th>                 
                    </tr>
                </thead>      
                <tbody id="areaList">

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data['stateId'] }}</td>
                            <td>{{ $data['userCityName'] }}</td>
                            <td>{{ $data['storeCityName'] }}</td>
                            <td>
                                 <form action="delete_cityregion" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <input type="hidden" name="cityId" value="{{ $data['userLocationCityId'] }}">
                                     <input type="hidden" name="stateId" value="{{ $data['stateId'] }}">

                                     @if(checkPermission('delete_cityregion','POST')) 
                                     <button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="return confirm('Are you sure want to delete this city?')"><i class="fas fa-window-close"></i> 
                                    </button>
                                    @endif
                                    
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





