@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>OG Tags</h4>
    </div>
    <div class="card-body">
    <div class="row">
            <div class="col-12">
        <?php if ($platformdata!=null) { ?>
            <?php //dd($platformdata) ?>
            <form action="post_edit_ogtag" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}} 
                        <input type="hidden" name="id" value="{{ $platformdata->id }}">
                        <div class="input-group mb-3">  
                            <div class="col-3">Select Platform</div>
                            <div class="col-7">
                            <select name="selectPlatform" id="selectPlatform" class="form-control">   
                                <option></option>                         
                                @foreach ($propertylist as $platform)
                                <option value="{{$platform->platformId}}"<?php if ($platformdata->platformId==$platform->platformId) echo "selected"; ?>>{{$platform->platformId}}</option>                            
                                @endforeach
                            </select>
                            </div>
                        </div>  
                        <div class="input-group mb-3">  
                            <div class="col-3">Property</div>
                            <div class="col-7">
                            <input type="text" name="property" id="property" class="form-control" value="{{$platformdata->property}}" required></input>
                            </div>
                        </div>
                        <div class="input-group mb-3">  
                            <div class="col-3">Content</div>
                            <div class="col-7">
                             <input type="text" name="content" id="content" class="form-control" value="{{$platformdata->content}}" required></input>
                            </div>
                        </div>  
                        <div class="input-group mb-3">  
                            <div class="col-3">Name</div>
                            <div class="col-7">
                             <input type="text" name="name" id="name" class="form-control" value="{{$platformdata->name}}"></input>
                            </div>
                        </div>                                                         
                            <div class="col-10">
                                <button class="btn btn-success" style="float: right;" type="submit"><i class="fas fa-save"></i> <span>Save</span></button>
                            </div>
                </form>
                    <?php } else { ?>
                        <form action="add_ogtag" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>                                        
                        {{@csrf_field()}}  
                        <div class="input-group mb-3">  
                            <div class="col-3">Select Platform</div>
                            <div class="col-7">
                            <select name="selectPlatform" id="selectPlatform" class="form-control" required>   
                                <option></option>                         
                                @foreach ($propertylist as $platform)
                                <option value="{{$platform->platformId}}">{{$platform->platformId}}</option>                            
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="input-group mb-3">  
                            <div class="col-3">Property</div>
                            <div class="col-7">
                            <input type="text" name="property" id="property" class="form-control" value=""></input>
                            </div>
                        </div>    
                        <div class="input-group mb-3">  
                            <div class="col-3">Content</div>
                            <div class="col-7">
                             <input type="text" name="content" id="content" class="form-control" value="" required></input>
                            </div>
                        </div>      
                        <div class="input-group mb-3">  
                            <div class="col-3">Name</div>
                            <div class="col-7">
                             <input type="text" name="name" id="name" class="form-control" value=""></input>
                            </div>
                        </div>  
                        <!--                                                 
                            <div class="col-10">
                                <button class="btn btn-success" style="float: right;" type="submit"><i class="fas fa-save"></i> <span>Save</span></button>
                            </div>
                            !-->
                    </form>
                    <?php } ?>
                    <div class="input-group mb-3">  
                            <div class="col-5"></div>
                        </div>     
                    <form action="index_filter" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}  
                    <div class="input-group mb-3">
                       <div class="col-3">Platform Id</div>
                            <div class="col-3">
                                <select class="form-control" id="id_platform" name="id_platform">
                                <option value="">All</option>                         
                                @foreach ($propertylist as $platform)
                                <option value="{{$platform->platformId}}" <?php if ($selectedplatform==$platform->platformId) echo "selected"; ?>>{{$platform->platformId}}</option>                            
                                @endforeach
                                </select>
                            </div>
                        <div class="input-group-append">
                                <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
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
                        <th>Platform Type</th>
                        <th>Platform ID</th>
                        <th>Property</th>
                        <th>Content</th>
                        <th>Name</th>     
                        <th></th>                  
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data->platformType }}</td>
                            <td>{{ $data->platformId }}</td>
                            <td>{{ $data->property }}</td>
                            <td>{{ $data->content }}</td>
                            <td>{{ $data->name }}</td>
                            <td>
                                <!--
                            <form action="edit_ogtag" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-wrench"></i> 
                                    </button>
                                </form>
                            <form action="delete_ogtag" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-window-close" onclick="return confirm('Are you sure want to delete this record?')"></i> 
                                    </button>
                                </form>
                                !-->
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





