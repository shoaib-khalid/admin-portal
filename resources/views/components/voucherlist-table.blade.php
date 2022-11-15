@php
    // var_dump($datas);
    // dd($datas);
    $selectedCountry = Session::get('selectedCountry');
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Available Voucher</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col-12">
                
                <form action="filter_voucherlist" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}
                    <div class="input-group mb-3">
                        <div class="col-2">Date</div>
                        <div class="col-4">
                        <input type="text" name="date_chosen4" id="date_chosen4" class="form-control daterange-btn4" value="{{$datechosen}}">
                        </div>
                        <div class="col-2">Voucher Code</div>
                        <div class="col-4">
                        <input type="text" name="code_chosen" id="code_chosen" class="form-control" value="{{$codechosen}}">
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-2">Select By Country</div>
                        <div class="col-4">
                            <select class="form-control" id="region" name="region">
                            <option  value="MYS"<?php if ($selectedCountry=="MYS") echo "selected"; ?>>Malaysia</option>
                            <option  value="PAK"<?php if ($selectedCountry=="PAK") echo "selected"; ?>>Pakistan</option>
                            </select>
                        </div> 
                        <div class="col-2">Service Type</div>
                        <div class="col-4">
                             <select class="form-control" id="serviceType" name="serviceType">
                                <option  value=""></option>
                                <option  value="DELIVERIN"<?php if ($serviceType=="DELIVERIN") echo "selected"; ?>>DELIVERIN</option>
                                <option  value="DINEIN"<?php if ($serviceType=="DINEIN") echo "selected"; ?>>DINEIN</option>
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
                <form action="export_voucherlist" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
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
                        <th>Created</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Voucher For</th>
                        <th>Store Name</th>
                        <th>Discount Type</th>
                        <th>Discount Value</th>
                        <th>Capped Amt</th>
                        <th>Voucher Code</th> 
                        <th>Total Claim</th>
                        <th>Available Qty</th>
                        <th></th> 
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ \Carbon\Carbon::parse($data['created_at'])->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['status'] }}</td>
                            <td>{{ $data['startDate'] }}</td>
                            <td>{{ $data['endDate'] }}</td>
                            <td>{{ $data['voucherType'] }}</td>
                            <td>{{ $data['storeName'] }}</td>
                            <td>{{ $data['discountType'] }}</td>
                            <td>{{ $data['discountValue'] }} {{ $data['calculationType'] }}</td>     
                            <td>{{ $data['maxDiscountAmount'] }}</td>                       
                            <td>{{ $data['voucherCode'] }}</td>  
                            <td><a href="voucherclaim/{{$data['id']}}">{{ $totalClaim[$data['id']] }}</a></td>  
                            <td><a href="voucherredeem/{{$data['id']}}">{{ $data['totalQuantity']-$data['totalRedeem'] }} / {{ $data['totalQuantity'] }}</a></td>  
                            <td>
                                <form action="voucheredit" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="voucherId" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-wrench"></i> 
                                    </button>
                                </form>
                                <!--<form action="voucherdelete" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="voucherId" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-window-close"></i> 
                                    </button>
                                </form>!-->
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





