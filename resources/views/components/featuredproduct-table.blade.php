@php
    // var_dump($datas);
    // dd($datas);
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card section">
    <div class="card-header">
        <h4>Featured Product</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col">
                
                <form action="filter_product" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}
                     <div class="input-group mb-3">
                        <input type="text" name="store_name" id="store_name" class="form-control"  value="{{$storename}}" placeholder="Store name">                      
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="product_name" id="product_name" class="form-control"  value="{{$productname}}" placeholder="Product name">
                        <div class="input-group-append">
                            <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                        </div>
                    </div>
                </form>
            </div>
          
        </div>


        <div class="table-responsive">

            <table id="table-4" class="table table-striped" style="font-size:11px !important">        
                <thead>
                    <tr class="text-center">
                        <th style="width: 30%;">Product Name</th>
                        <th style="width: 30%;">Category</th>
                        <th style="width: 30%;">Store</th>     
                        <th style="width: 5%;">Sequence</th>    
                        <th style="width: 5%;"></th>                       
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($searchresult as $data)
                        <tr class="text-center">
                             <form action="add_featuredproduct" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                            <td style="padding: 0">{{ $data->name }}</td>
                            <td style="padding: 0">{{ $data->category }}</td>
                            <td style="padding: 0">{{ $data->storeName }}</td>
                            <td style="padding: 0"> <input type="text" name="sequence" value="{{ $data->sequence }}" class="form-control"></td>
                            <td style="padding: 0">
                                     <?php if ($data->sequence=="") { ?>                              
                                     <input type="hidden" name="id" value="{{ $data->id }}">
                                     <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;" onclick="return confirm('Are you sure want to add this product?')"><i class="fas fa-plus"></i> 
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
                        <th style="width: 30%;">Product Name</th>
                        <th style="width: 30%;">Category</th>
                        <th style="width: 25%;">Store</th>  
                        <th style="width: 5%;">Sequence</th>    
                        <th style="width: 5%;"></th>                         
                        <th style="width: 5%;"></th>                         
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data->productName }}</td>
                            <td>{{ $data->category }}</td>
                            <td>{{ $data->storeName }}</td>
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





