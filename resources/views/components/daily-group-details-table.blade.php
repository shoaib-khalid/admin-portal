@php
    // var_dump($datas);
    // dd($datas);
    $selectedCountry = Session::get('selectedCountry');
@endphp
<!--<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        function showMov(val) {
        sessionStorage.setItem('SelectedRegion', val);

            switch (val) {
                case 'MYS':
                {
                    $('#PAK_form').hide();
                    $('#MYS_form').show();
                    $('#moveform').attr('action', 'userdata-table.blade.php');
                    break;
                }
                case 'PAK':
                {
                    $('#MYS_form').hide();
                    $('#PAK_form').show();
                    $('#moveform').attr('action', 'userdata-table.blade.php');
                    break;
                }
            }
        }

        $(function() {
            var selMovType = document.getElementById('region');
            var selectedRegion = sessionStorage.getItem('SelectedRegion');

                if (selectedRegion) {
                selMovType.value = selectedRegion;
            }

            var btnSubmit = document.getElementById('submit');

            btnSubmit.addEventListener('click', function() {
                window.location.reload();
            });
        });

    </script>!-->
<div class="card section">
    <div class="card-header">
        <h4>Daily Detail Sales</h4>
    </div>
    <div class="card-body">

        <div class="form-group">

            <div class="row">
                <div class="col">
                    <div class="col">                        
                        <form class="flex flex-row w-full" action="/filter_groupsales" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
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
                                        </select>
                                    </div>
                                    </div>                   
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <input type="text" name="date_chosen2" id="date_chosen2" class="form-control daterange-btn2" value="{{$datechosen}}">
                                         <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                                     </div> 
                                </div>
                        </form>
                    </div>
                    <div class="col-1"></div>
                    <div class="col">
                        <form action="/export_groupsales" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                            {{@csrf_field()}}
                            <input type="text" name="date_chosen2_copy" id="date_chosen2_copy" class="form-control daterange-btn2" value="{{$datechosen}}" hidden>
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
            <table class="table table-md table-hover table-borderless" id="table-2">
                <thead>
                    <tr class="text-center">
                    {{-- <th>
                        #
                    </th> --}}
                    <th>Date</th>
                    <th>Customer Name</th>                   
                    <th>Store Name</th>                   
                    <th>Sub Total</th>
                    <th>Applied Discount</th>
                    <th>Service Charge</th>
                    <th>Delivery Charge</th>
                    <th>Delivery Discount</th>
                    <th>Platform Voucher Discount</th>
                    <th>Commission</th>   
                    <th>Total</th>   
                    <th>Payment Status</th> 
                    <th>Order Status</th> 
                    <th>Service</th>
                    <th>Channel</th>
                    <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @foreach ($datas as $data)                       
                        <tr class="text-center">
                            <?php 
                            $totalComm = 0;
                            $storeName='';
                            $orderStatus='';
                            foreach ($data['orderList'] as $order) {
                                $totalComm = $totalComm + $order['klCommission'];
                                if ($storeName=='')
                                    $storeName = $order['store']['name'];
                                else
                                    $storeName = $storeName . ", " .$order['store']['name'];

                                if ($orderStatus=='')
                                    $orderStatus = $order['completionStatus'];
                                else
                                    $orderStatus = $orderStatus . ", " .$order['completionStatus'];
                            }
                            ?>

                            <td>
                            <?php
                            $date = $data['created'];
                            $format = 'Y-m-d H:i:s';
                            $userTimeZone = 'Asia/Kuala_Lumpur';
                            $serverTimeZone = 'UTC';
                            $dateTime = new DateTime ($date, new \DateTimeZone($serverTimeZone));
                            $dateTime->setTimezone(new \DateTimeZone($userTimeZone));
                            echo " ".$dateTime->format($format);
                            ?>
                            </td>                            
                            <td><?php if ($data['customer']['name']=="") { 
                                        echo $data['customer']['username'];
                                    } else {
                                        echo $data['customer']['name'];
                                    }
                                ?>
                            </td>
                            <td>{{ $storeName }}</td>
                            <td>{{ number_format($data['subTotal'], 2, '.', ',') ?? '0.00' }}</td>
                            <td>{{ number_format($data['appliedDiscount'], 2, '.', ',') ?? '0.00' }}</td>
                            <td>{{ number_format($data['serviceCharges'], 2, '.', ',') ?? '0.00' }}</td>
                            <td>{{ number_format($data['deliveryCharges'], 2, '.', ',') ?? '0.00' }}</td>
                            <td>{{ number_format($data['deliveryDiscount'], 2, '.', ',') ?? '0.00' }}</td>
                            <td>{{ number_format($data['platformVoucherDiscount'], 2, '.', ',') ?? '0.00' }}</td>
                            
                            <td>{{ number_format($totalComm, 2, '.', ',') ?? '0.00' }}</td>
                            <td>{{ number_format($data['total'], 2, '.', ',') ?? '0.00' }}</td>
                            <td>
                                 @if ($data['paymentStatus'] == "PAID")
                                            <div class="badge badge-success">{{ $data['paymentStatus'] }}</div>
                                        @else 
                                            <div class="badge badge-warning">{{ $data['paymentStatus'] }}</div>
                                        @endif
                            </td>
                            <td>{{ $orderStatus }}</td>
                            <td>{{ $data['serviceType'] }}</td>
                            <td>
                                  
                                 @if ($data['channel'] == "DELIVERIN")
                                    WEBSITE
                                 @else 
                                    {{ $data['channel'] }}
                                 @endif
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>





