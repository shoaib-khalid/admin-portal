@php
    // var_dump($datas);
    // dd($datas);
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
        <h4>Locations</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col">
                              
                <form action="add_location" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>                                        
                        {{@csrf_field()}}  
                        <div class="input-group mb-3">  
                            <div class="col-3">Select State</div>
                            <div class="col-7">
                            <select name="selectState" id="selectState" class="form-control" onchange="filterCity()">   
                                <option value="">Select State</option>                         
                                @foreach ($stateList as $state)
                                <option value="{{$state->id}}" <?php if ($stateSelected==$state->id) echo "selected"; ?>>{{$state->regionCountryId}} - {{$state->name}}</option>                            
                                @endforeach
                            </select>  
                            </div>
                        </div>   
                        
                        <div class="input-group mb-3">
                            <div class="col-3">Select City</div>
                            <div class="col-7">
                                <select name="selectCity" id="selectCity" class="form-control" onchange="searchCity()">   
                                    <option value="">Select City</option>                         
                                    @foreach ($cityList as $city)
                                    <option value="{{$city->id}}" <?php if ($citySelected==$city->id) echo "selected"; ?>>{{$city->regionStateId}} - {{$city->name}}</option>                            
                                    @endforeach
                                </select>   
                            </div>                                  
                        </div> 

                        <div class="input-group mb-3">  
                            <div class="col-3">Sequence</div>
                            <div class="col-7">
                            <input type="text" name="sequence" class="form-control" >
                            </div>
                        </div>                      
                        <div class="input-group mb-3">  
                            <div class="col-3">Upload Logo</div>
                            <div class="col-7">
                              <input type="file" name="selectFile">
                            </div>
                        </div>                                  
                        <div class="input-group mb-3">                        
                            <div class="col-2">
                                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> <span>Save</span></button>
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
                        <th style="width: 20%;">State</th>
                        <th style="width: 20%;">Locations</th>                        
                        <th style="width: 20%;">Logo</th>
                        <th style="width: 20%;">Neighbour (Max 5)</th>  
                        <th style="width: 20%;"></th> 
                        <th style="width: 20%;"></th>                                            
                        <th style="width: 20%;"></th>                 
                    </tr>
                </thead>      
                <tbody id="areaList">

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data['regionStateId'] }}</td>
                            <td>{{ $data['cityId'] }}</td>                            
                            <td><img src="{{ $basepreviewurl.$data['imageUrl'] }}" height="100px"></td>
                            <td><?php if (array_key_exists($data['cityId'],  $regionCityList)) echo $regionCityList[$data['cityId']] ?>                            
                            </td>

                            <form action="edit_location" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                            <td><input type="text" name="sequence" value="{{ $data['sequence'] }}" class="form-control" >
                                <input type="file" name="selectFile">
                            </td>
                            <td>
                                   
                                         <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-save"></i> 
                                        </button>
                                   
                                   
                            </td>
                            </form>    
                            
                            <td>
                                 <form action="delete_location" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="return confirm('Are you sure want to delete this location?')"><i class="fas fa-window-close"></i> 
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





