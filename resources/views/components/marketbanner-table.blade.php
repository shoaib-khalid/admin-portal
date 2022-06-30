@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Marketplace banner</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col-12">
                
                
                        <form action="add_marketbanner" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>                                        
                        {{@csrf_field()}}  
                        <div class="input-group mb-3">  
                            <div class="col-3">Select Country</div>
                            <div class="col-7">
                            <select name="selectCountry" id="selectCountry" class="form-control">   
                                <option></option>                         
                                @foreach ($countryList as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>                            
                                @endforeach
                            </select>
                            </div>
                        </div> 
                        <div class="input-group mb-3">  
                            <div class="col-3">Select Country</div>
                            <div class="col-7">
                            <select name="selectType" id="selectType" class="form-control">   
                               <option value="DESKTOP">DESKTOP</option>
                               <option value="MOBILE">MOBILE</option>
                            </select>
                            </div>
                        </div>                         
                        <div class="input-group mb-3">  
                            <div class="col-3">Upload Banner</div>
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
            <div class="col-1">
                
            </div>
            
        </div>

    

        <div class="table-responsive">

            <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th>Url</th>
                        <th>Preview</th>
                        <th>Region</th>  
                        <th>Type</th>    
                        <th></th>                  
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data['bannerUrl'] }}</td>
                            <td><img src="{{ $basepreviewurl.$data['bannerUrl'] }}" height="100px"></td>
                            <td>{{ $data['regionCountryId'] }}</td>
                            <td>{{ $data['type'] }}</td>
                            <td>
                                <form action="delete_marketbanner" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="return confirm('Are you sure want to remove this?')"><i class="fas fa-window-close"></i> 
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





