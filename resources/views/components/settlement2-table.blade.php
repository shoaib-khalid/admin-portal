@php
    // var_dump($datas);
    // dd($datas);
    $selectedCountry = Session::get('selectedCountry');
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Settlement</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col">
            <div class="col">
                
                <form class="flex flex-row w-full" action="filter_settlement2" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}

                    <div class="col">                       
                        <div class="input-group mb-3">
                            <div class="col-3">Country</div>
                            <div class="col">                                
                                    <select class="form-control" id="region" name="region">
                                        <option  value="MYS"<?php if ($selectedCountry=="MYS") echo "selected"; ?>>Malaysia</option>
                                        <option  value="PAK"<?php if ($selectedCountry=="PAK") echo "selected"; ?>>Pakistan</option>
                                    </select>                                    
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="col-3">Service</div>
                            <div class="col">
                                <select  class="form-control" name="selectService">
                                    <option <?php if ($selectedService=="DELIVERIN") echo "selected"; ?>>DELIVERIN</option>
                                    <option <?php if ($selectedService=="DINEIN") echo "selected"; ?>>DINEIN</option>
                                </select>
                            </div>
                        </div>                   
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="col-3">Channel</div>
                            <div class="col">
                            <select  class="form-control" name="selectChannel">
                                <?php if (Auth::user()->channel=="ALL" || Auth::user()->channel=="DELIVERIN" ) { ?>
                                <option <?php if ($selectedChannel=="DELIVERIN") echo "selected"; ?> value="DELIVERIN">WEBSITE</option>
                                <?php } ?>
                                <?php if (Auth::user()->channel=="ALL" || Auth::user()->channel=="PAYHUB2U" ) { ?>
                                <option <?php if ($selectedChannel=="PAYHUB2U") echo "selected"; ?> value="PAYHUB2U">PAYHUB2U</option>
                                <?php } ?>
                                <?php if (Auth::user()->channel=="ALL" || Auth::user()->channel=="EKEDAI" ) { ?>
                                <option <?php if ($selectedChannel=="EKEDAI") echo "selected"; ?> value="EKEDAI">EKEDAI</option>
                                <?php } ?>
                            </select>
                        </div>
                        </div>                   
                    </div>

                    <div class="col">             
                        <div class="input-group mb-3">
                            <input type="text" name="date_chosen4" id="date_chosen4" class="form-control daterange-btn4" value="{{$datechosen}}">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-1">
                
            </div>
            <div class="col">
                <form action="export_settlement2" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <input type="text" name="date_chosen4_copy" id="date_chosen4_copy" class="form-control daterange-btn4" value="{{$datechosen}}" hidden>
                        <input type="text" name="service_copy" id="service_copy" class="" value="{{$selectedService}}" hidden>
                        <input type="text" name="channel_copy" id="channel_copy" class="" value="{{$selectedChannel}}" hidden>
                        <input type="text" name="country_copy" id="country_copy" class="" value="{{$selectedCountry}}" hidden>
                        <button type="submit" class="btn btn-success icon-left btn-icon float-right"><i class="fas fa-file"></i> <span>Export Excel</span>
                        </button>
                    </form>
            </div>
            </div>
        </div>
            

        <div class="table-responsive">

            <table id="table-5" class="table table-md table-hover table-borderless">
                <thead>
                    <tr class="text-center">
                        <th>Payout Date</th>
                        <th>Store Name</th>
                        <th>Start Date</th>
                        <th>Cut-Off Date</th>
                        <th>Gross Amount</th>
                        <th>Service Charge</th>
                        <th>Delivery Charge</th>
                        <th>Commission</th>
                        <th>Payment Fee</th>
                        <th>Nett Amount</th>
                        <th>Remarks</th>
                        <!-- <th>Service</th> -->
                        <!-- <th>Channel</th>     -->
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center" data-toggle="modal" data-target="#SettlementDetailsModal"
                                    data-payoutdate="{{ \Carbon\Carbon::parse($data['settlementDate'])->format('Y-m-d') }}"
                                    data-storename="{{ $data['storeName'] }}"
                                    data-startdate="{{ \Carbon\Carbon::parse($data['cycleStartDate'])->format('Y-m-d H:i:s') }}"
                                    data-cutoffdate="{{ \Carbon\Carbon::parse($data['cycleEndDate'])->format('Y-m-d H:i:s') }}"
                                    data-grossamount="{{ $data['totalTransactionValue'] }}"
                                    data-servicecharge="{{ $data['totalServiceFee'] }}"
                                    data-deliverycharge="{{ $data['totalDeliveryFee'] }}"
                                    data-commission="{{ $data['totalCommisionFee'] }}"
                                    data-nettamount="{{ $data['totalStoreShare'] }}"
                                    data-remarks="{{ $data['remarks'] }}"
                                    data-id="{{ $data['id'] }}"
                                    data-paymentfee="{{ $data['totalPaymentFee'] }}"
                                    data-orderurl="{{ config('services.report_svc.order_url') }}"
                                    data-storeid="{{ $data['storeId'] }}"
                                    >
                            <td>{{ \Carbon\Carbon::parse($data['settlementDate'])->format('Y-m-d') }}</td>
                            <td>{{ $data['storeName'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($data['cycleStartDate'])->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($data['cycleEndDate'])->format('Y-m-d') }}</td>
                            <td>{{ $data['totalTransactionValue'] }}</td>
                            <td>{{ $data['totalServiceFee'] }}</td>
                            <td>{{ $data['totalDeliveryFee'] }}</td>
                            <td>{{ $data['totalCommisionFee'] }}</td>
                            <td>{{ $data['totalPaymentFee'] }}</td>
                            <td>{{ $data['totalStoreShare'] }}</td>
                            <td>{{ $data['remarks'] }}</td>  
                            <!-- <td>{{ $data['serviceType'] }}</td>   -->
                            <!-- <td><?php if ($data['channel']=="DELIVERIN") echo "WEBSITE"; else echo $data['channel']; ?></td>                             -->
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





