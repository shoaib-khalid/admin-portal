@php
    // var_dump($datas);
    // dd($datas);
@endphp

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
      
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card section">
    <div class="card-header">
        <h4>Parent Category</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col">
                              
                <form action="add_parentcategory" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>                                        
                        {{@csrf_field()}}  
                        
                        <div class="input-group mb-3">  
                            <div class="col-3">Select Vertical</div>
                            <div class="col-7">
                            <select name="selectVertical" id="selectVertical" class="form-control">   
                                <option></option>                         
                                @foreach ($verticallist as $vertical)
                                <option value="{{$vertical->code}}">{{$vertical->code}}</option>                            
                                @endforeach
                            </select>
                            </div>
                        </div> 

                        <div class="input-group mb-3">  
                            <div class="col-3">Parent Category Name</div>
                            <div class="col-7">
                            <input type="text" name="parentCategory" class="form-control" >
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
                        <th style="width: 20%;">Vertical Code</th> 
                        <th style="width: 20%;">Id</th>                        
                        <th style="width: 20%;">Name</th> 
                        <th style="width: 20%;">Logo</th>                        
                        <th style="width: 20%;"></th> 
                        <th style="width: 20%;"></th>                                            
                        <th style="width: 20%;"></th>                 
                    </tr>
                </thead>      
                <tbody id="areaList">

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data['verticalCode'] }}</td>
                            <td>{{ $data['id'] }}</td>
                            <td>{{ $data['name'] }}</td>                            
                            <td><img src="{{ $basepreviewurl.$data['imageUrl'] }}" height="100px"></td>                        
                            <form action="edit_parentcategory" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
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
                                 <form action="delete_parentcategory" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="return confirm('Are you sure want to delete this category?')"><i class="fas fa-window-close"></i> 
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





