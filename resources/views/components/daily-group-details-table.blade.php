
<div class="card section">
    <div class="card-header">
        <h4>Daily Detail Sales</h4>
    </div>
    <div class="card-body">

        <div class="form-group">

            <div class="row">
                <div class="col">
                    
                    <form action="/filter_groupsales" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <div class="input-group mb-3">
                            <input type="text" name="date_chosen2" id="date_chosen2" class="form-control daterange-btn2" value="{{$datechosen}}">
                            </div>
                            <select class="form-select form-select-lg mb-3"  id="dev">
                            <option  value="malaysia">Malaysia</option>
                            <option  value="pakistan">Pakistan</option>
                             </select>
   
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                            </div>
                        
                    </form>
                </div>
                <div class="col-1">
                    
                </div>
                <div class="col">
                    <form action="/export_groupsales" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <input type="text" name="date_chosen2_copy" id="date_chosen2_copy" class="form-control daterange-btn2" value="{{$datechosen}}" hidden>
                        <button type="submit" class="btn btn-success icon-left btn-icon float-right"><i class="fas fa-file"></i> <span>Export Excel</span>
                        </button>
                    </form>
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
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>





