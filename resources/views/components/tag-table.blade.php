@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Tags</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <?php if ($keyworddata==null) { 
                    $keyword="";
                    $longitude="";
                    $latitude="";
                    ?>
                <form action="add_tag" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                <?php } else { 
                        $keyword=$keyworddata->keyword;
                        $longitude=$keyworddata->longitude;
                        $latitude=$keyworddata->latitude;
                    ?>
                <form action="save_edit_tag" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    <input type="hidden" name="id" value="<?php echo $keyworddata->id; ?>">
                <?php } ?>
                        {{@csrf_field()}} 
                        <div class="input-group mb-3">  
                            <div class="col-3">Keyword</div>
                            <div class="col-7">
                            <input type="text" name="keyword" id="keyword" class="form-control" value="<?php echo $keyword; ?>" required></input>
                            </div>
                        </div>
                        <div class="input-group mb-3">  
                            <div class="col-3">Longitude</div>
                            <div class="col-7">
                             <input type="text" name="longitude" id="longitude" class="form-control" value="<?php echo $longitude; ?>"></input>
                            </div>
                        </div>  
                        <div class="input-group mb-3">  
                            <div class="col-3">Latitude</div>
                            <div class="col-7">
                             <input type="text" name="latitude" id="latitude" class="form-control" value="<?php echo $latitude; ?>"></input>
                            </div>
                        </div>                                                         
                            <div class="col-10">
                                <button class="btn btn-success" style="float: right;" type="submit"><i class="fas fa-save"></i> <span>Save</span></button>
                            </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">

            <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Keyword</th>
                        <th>Url</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th></th>
                        <th></th>
                        <th style="width: 40%;">Details</th>  
                        <th style="width: 40%;">Config</th>     
                                          
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->keyword }}</td>
                            <td>{{$tagurl}}/{{ $data->keyword }}<br><br>
{{$tagurl}}/{{ $data->keyword }}?tableno=1</td>
                            <td>{{ $data->longitude }}</td>
                            <td>{{ $data->latitude }}</td>
                            <td>
                            <form action="edit_tag" method="get" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-wrench"></i> 
                                    </button>
                                </form>
                            </td>
                            <td>
                            <form action="delete_tag" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-window-close" onclick="return confirm('Are you sure want to delete this record?')"></i> 
                                    </button>
                                </form>
                            </td>
                            <td>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Store</th>
                                            <th>Category</th>
                                            <th>
                                                 <button class="btn btn-success" style="float: right;" type="button" onclick="addDetails('{{ $data['id'] }}')"><i class="fas fa-wrench"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach ($data->details as $detail)
                                        <tr class="text-center">                                           
                                            <td>{{ $detail->productName }}</td>
                                            <td>{{ $detail->storeName }}</td>
                                            <td>{{ $detail->categoryName }}</td> 
                                            <td>                                              
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Property</th>
                                            <th>Content</th>
                                            <th>
                                                 <button class="btn btn-success" style="float: right;" type="button" onclick="addConfig('{{ $data['id'] }}')"><i class="fas fa-wrench"></i></button>
                                            </th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach ($data->configs as $config)
                                        <tr class="text-center">                                           
                                            <td>{{ $config->property }}</td>
                                            <td>{{ $config->content }}</td> 
                                            <td>                                               
                                            </td>                                   
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
<script type="text/javascript">
    function addDetails(keywordId) {
        //alert(keywordId);
        window.location.href="/add_tag_details?keywordId="+keywordId;        
    }

     function addConfig(keywordId) {
        //alert(keywordId);
        window.location.href="/add_tag_config?keywordId="+keywordId;        
    }
</script>




