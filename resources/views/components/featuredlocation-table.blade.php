@php
    // var_dump($datas);
    // dd($datas);
@endphp
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      
<script>
         function searchStore() {
           var vertical = document.getElementById('selectVertical').value;
            $.ajax({
               type:'POST',
               url:'/searchStore',
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type' : 'application/x-www-form-urlencoded'
                },
               data:{
                    vertical : vertical
                },
               success:function(data) {
                  $("#msg").html(data.storeList);
                  //console.log(data);
                  var resultData = data.storeList;
                  var bodyData = '';
                  var i=1;
                  $.each(resultData,function(index,row){
                    //console.log(row.id+"->"+row.name);
                    bodyData+="<option value="+row.id+">"+row.name+"</option>";
                  })
                  $("#selectStore").html(bodyData);
               }
            });
         }
      </script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card section">
    <div class="card-header">
        <h4>Featured Location</h4>
    </div>
    <div class="card-body">

       <div class="form-group">


        <div class="table-responsive">

        <div class="table-responsive">

            <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th style="width: 70%;">City</th>
                        <th style="width: 10%;">Sequence</th>     
                        <th style="width: 10%;"></th> 
                        <th style="width: 10%;"></th>                 
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data['cityName'] }}</td>
                            <form action="edit_featuredlocation" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                <td><input type="text" name="sequence" value="{{ $data['sequence'] }}" class="form-control" ></td>
                                <td>
                                   
                                         <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-save"></i> 
                                        </button>
                                   
                                   
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
    </div>
</div>





