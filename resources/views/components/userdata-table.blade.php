@php
    // var_dump($datas);
    // dd($datas);
    $selectedCountry = Session::get('selectedCountry');
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Customer Data</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col-12">
                
            <form action="filter_userdata" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}
                    <div class="input-group mb-3">
                        <div class="col-2">Date</div>
                        <div class="col-4">
                        <input type="text" name="date_chosen4" id="date_chosen4" class="form-control daterange-btn4" value="{{$datechosen}}">
                        </div>
                        <div class="col-2">Store</div>
                        <div class="col-4">
                        <input type="text" name="storename_chosen" id="storename_chosen" class="form-control" value="{{$storename}}">
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-2">Customer</div>
                        <div class="col-4">
                        <input type="text" name="customer_chosen" id="customer_chosen" class="form-control" value="{{$customername}}">
                        </div>
                        <label class="col-2" for="region">By Country</label>
                        <div class="col-4">
                        <select class="form-select form-select-lg mb-3" id="region" name="region">
                        <option  value="all">All</option>
                        <option  value="MYS"<?php if ($selectedCountry=="MYS") echo "selected"; ?>>Malaysia</option>
                        <option  value="PAK"<?php if ($selectedCountry=="PAK") echo "selected"; ?>>Pakistan</option>
                        </select>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-2">
                            <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-1">
                
            </div>
            
        </div>

        <div class="row">
            <div class="col">
                <form action="export_userdata" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        
                            <input type="text" name="date_chosen4_copy" id="date_chosen4_copy" class="form-control daterange-btn4" value="{{$datechosen}}" hidden>
                            <button type="submit" class="btn btn-success icon-left btn-icon float-right" style="margin-bottom: 1rem!important;"><i class="fas fa-file"></i> <span>Export Excel</span>
                            </button>
                        
                    </form>
            </div>
        </div>    

        <div class="table-responsive">

            <table class="table table-striped" id="table-3">        
                <thead>
                    <tr class="text-center">                        
                        <th colspan="2" rowspan="2">Customer Name</th>
                        <th colspan="2" rowspan="2">Store Name</th>
                        <th colspan="2" rowspan="2">Email</th>
                        <th colspan="2" rowspan="2">Phone No</th>
                        <th colspan="3">Order History</th>
                    </tr>
                    <tr>
                        <th>Abandon Cart</th>
                        <th>Completed Order</th>
                        <th>Incompleted Order</th>
                    </tr>
                </thead>      
                <tbody>
                    @foreach ($datas as $data)
                        <tr class="text-center">                            
                            <td  colspan="2" rowspan="2">{{ $data['name'] }}</td>
                            <td  colspan="2" rowspan="2">{{$data['storeName']}}</td>
                            <td  colspan="2" rowspan="2">{{ $data['email'] }}</td>
                            <td  colspan="2" rowspan="2">{{ $data['phoneNumber'] }}</td>
                            <td  rowspan="2">{{ $data['itemCart'] }}</td>
                            <td  rowspan="2">{{ $data['orderCompleted'] }}</td>
                            <td  rowspan="2">{{ $data['orderIncomplete'] }}</td>
                        </tr>
                        <tr></tr>
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




