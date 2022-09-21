@php
    // var_dump($datas);
    // dd($datas);
    $selectedCountry = Session::get('selectedCountry');
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Customer Site Map</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col-12">
                
            <form action="filter_usersitemap" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
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
                        <div class="col-2">Device</div>
                        <div class="col-4">
                        <input type="text" name="device_chosen" id="device_chosen" class="form-control" value="{{$device}}">
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-2">Browser</div>
                        <div class="col-4">
                        <input type="text" name="browser_chosen" id="browser_chosen" class="form-control" value="{{$browser}}">
                        </div>
                        <div class="col-2">Country</div>
                        <div class="col-4">
                        <input type="text" name="device_chosen" id="device_chosen" class="form-control" value="">
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label class="col-2" for="region">Select By Country</label>
                        <div class="col-4">
                        <select class="form-select form-select-lg mb-3" id="region" name="region">
                        <option  value="MYS"<?php if ($selectedCountry=="MYS") echo "selected"; ?>>Malaysia</option>
                         <option  value="PAK"<?php if ($selectedCountry=="PAK") echo "selected"; ?>>Pakistan</option>
                        </select>
                        </div>
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
                <form action="export_usersitemap" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        
                            <input type="text" name="date_chosen4_copy" id="date_chosen4_copy" class="form-control daterange-btn4" value="{{$datechosen}}" hidden>
                            <button type="submit" class="btn btn-success icon-left btn-icon float-right" style="margin-bottom: 1rem!important;"><i class="fas fa-file"></i> <span>Export Excel</span>
                            </button>
                        
                    </form>
            </div>
        </div>    

        <div class="table-responsive">

            <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">                        
                        <th>Session ID</th>
                        <th>Location</th>
                        <th>Customer</th>
                        <th>Store</th>
                        <th>Start Timestamp</th>                        
                        <th>End Timestamp</th>
                        <th>Time Spent</th>
                        <th>First Page Visited</th>
                        <th>Last Page Visited</th>
                        <th>Item Added</th>                        
                        <th>Order Created</th>
                        <th>Order Status</th>
                        <th></th>
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">                            
                            <td>{{ $data['sessionId'] }}</td>
                            <td>{{ $data['location'] }}</td>
                            <td>{{ $data['customerName'] }}</td>
                            <td>{{ $data['storeName'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($data['startTimestamp'])->format('d/m/Y H:i:s') }}</td>
                            <td>{{ \Carbon\Carbon::parse($data['endTimestamp'])->format('d/m/Y H:i:s') }}</td>                            
                            <td>{{ number_format($data['timeSpent'],2) }}</td>
                            <td>{{ $data['firstPage'] }}</td>
                            <td>{{ $data['lastPage'] }}</td>
                            <td>{{ $data['itemAdded'] }}</td>
                            <td>
                            <?php if ($data['orderCreated']=="YES") { ?>
                            <a href="#" class="btn btn-primary view_order" sessionId="{{ $data['sessionId'] }}">
                            {{ $data['orderCreated'] }}
                            </a>
                            <?php } ?>
                            </td>
                            <td>{{ $data['orderStatus'] }}</td>
                            <td>
                                <a href="#" class="btn btn-primary view_store" clientId="{{ $data['sessionId'] }}">
                                    <i class="far fa-check-circle"></i>
                                    Details
                                </a>
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





