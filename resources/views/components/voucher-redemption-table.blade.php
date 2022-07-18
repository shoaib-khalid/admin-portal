
<div class="card section">
    <div class="card-header">
        <h4>Voucher Redemption</h4>
    </div>
    <div class="card-body">

        <div class="form-group">

            <div class="row">
                <div class="col">
                    
                    <form action="/filter_voucherredemption" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <div class="input-group mb-3">
                            <input type="text" name="date_chosen2" id="date_chosen2" class="form-control daterange-btn2" value="{{$datechosen}}">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-1">
                    
                </div>
                <div class="col">
                    <form action="/export_voucherredemption" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
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
                    <th>Sales Amount</th>
                    <th>Voucher Amount</th>
                    <th>Voucher Code</th>
                    <th>Voucher Name</th>                    
                    </tr>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @foreach ($datas as $data)                       
                        <tr class="text-center">
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
                            <td>{{ $data['customer']['name'] }}</td>
                            <td>{{ $data['total'] }}</td>
                            <td>{{ $data['platformVoucherDiscount'] }}</td>
                            <td>{{ $data['voucher']['name'] }}</td>
                            <td>{{ $data['voucher']['voucherCode'] }}</td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>





