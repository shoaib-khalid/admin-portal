@php
    // var_dump($datas);
    // dd($datas);
    $selectedCountry = Session::get('selectedCountry');
@endphp
<div class="card">
    <div class="card-header">
        <h4>Daily Sales Summary</h4>
    </div>
    <div class="card-body">

        <div class="form-group">

            <div class="row">

                <div class="col">
                <form class="flex flex-row w-full" action="/filter_dashboard" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
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
                                <option <?php if ($selectedChannel=="DELIVERIN") echo "selected"; ?> value="DELIVERIN">WEBSITE</option>
                                <option <?php if ($selectedChannel=="PAYHUB2U") echo "selected"; ?> value="PAYHUB2U">PAYHUB2U</option>
                            </select>
                        </div>
                        </div>                   
                    </div>                
                    <div class="col">
                            <div class="input-group mb-3">                                
                                <input type="text" name="date_chosen" id="date_chosen" class="form-control daterange-btn" value="{{$datechosen}}">
                                <div class="input-group-append">
                                    <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                                </div>
                            </div>                                                    
                    </div>
                    
                </form>

                <div class="col-1">
                    
                </div>
                <div class="col">
                    <form action="/export_dashboard" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <input type="text" name="date_chosen_copy" id="date_chosen_copy" class="form-control daterange-btn" value="{{$datechosen}}" hidden>
                        <input type="text" name="service_copy" id="service_copy" class="" value="{{$selectedService}}" hidden>
                        <input type="text" name="channel_copy" id="channel_copy" class="" value="{{$selectedChannel}}" hidden>
                        <input type="text" name="country_copy" id="country_copy" class="" value="{{$selectedCountry}}" hidden>
                        <button type="submit" class="btn btn-success icon-left btn-icon float-right"><i class="fas fa-file"></i> <span>Export Excel</span>
                        </button>
                    </form>
                </div>
            </div>

            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-md table-hover table-borderless" id="table-1">
                <thead>
                    <tr class="text-center">
                    {{-- <th class="text-center">
                        #
                    </th> --}}
                    <th>Date</th>
                    <th>Store Name</th>
                    <th>Service</th>
                    <th>Channel</th>
                    <th>Total Order</th>
                    <th>Amount Earned</th>
                    {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @foreach ($days as $day)
                        <tr class="text-center">
                            {{-- <td>
                                {{ $index }}
                            </td> --}}
                            <td>
                                {{ \Carbon\Carbon::parse($day['date'])->format('d/m/Y')}}                              
                            </td>
                            <td>
                                {{ $day['store']['name'] }}
                            </td>
                             <td>
                                {{ $day['serviceType'] }}
                            </td>                           
                            <td>
                                         @if ($day['channel'] == "DELIVERIN")
                                            WEBSITE
                                         @else 
                                            {{ $day['channel'] }}
                                         @endif
                            </td>
                             <td>
                                <strong>
                                    {{ $day['totalOrders'] }}
                                </strong>
                            </td>
                            <td>
                                {{ number_format($day['amountEarned'], 2, '.', ',') ?? '0.00' }}
                            </td>
                            {{-- <td>
                                <button class="btn btn-dark" 
                                data-toggle="modal" 
                                data-target="#dailySalesModal"
                                data-date="{{ $day['date'] }}"
                                data-total_order="{{ $day['totalOrders'] }}"
                                data-success_order="{{ $day['successFullOrders'] }}"
                                data-cancel_order="{{ $day['canceledOrders'] }}"
                                data-amount_earn="{{ $day['amountEarned'] }}"
                                data-commision="{{ $day['commision'] }}"
                                data-total_amount="{{ $day['totalAmount'] }}"
                                data-settlement_id="{{ $day['settlementReferenceId'] }}"
                                >
                                    <i class="far fa-check-circle"></i>
                                    Details
                                </button>
                            </td> --}}
                        </tr>
                        @php $index++; @endphp
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
