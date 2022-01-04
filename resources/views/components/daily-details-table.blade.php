
<div class="card section">
    <div class="card-header">
        <h4>Daily Details Sales</h4>
    </div>
    <div class="card-body">

        <div class="form-group">

            <div class="row">
                <div class="col">
                    
                    <form action="/filter_detail" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
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
                    <form action="/export_detail" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
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
                    <th>Store Name</th>
                    <th>Customer Name</th>
                    <th>Sub Total</th>
                    <th>Service Charge</th>
                    <th>Delivery Charge</th>
                    <th>Commision</th>
                    <th>Total</th>
                    <th>Order Status</th>
                    <th>Delivery Status</th>
                    {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @foreach ($datas as $data)
                        @if (count($data['sales']) > 0)
                            @php $date = $data['date']  @endphp
                            @foreach ($data['sales'] as $item)
                                <tr class="text-center">
                                    {{-- <td>
                                        {{ $index }}
                                    </td> --}}
                                    <td>
                                        {{ \Carbon\Carbon::parse($date)->format('d/m/Y')}}
                                    </td>
                                    <td>
                                        {{ $item['storeName'] }}
                                    </td>
                                    <td>
                                        {{ $item['customerName'] }}
                                    </td>
                                    <td>
                                        {{ number_format($item['subTotal'], 2, '.', ',') ?? '0.00' }}
                                    </td>
                                    <td>
                                        {{ number_format($item['serviceCharge'], 2, '.', ',') ?? '0.00' }}
                                    </td>
                                    <td>
                                        {{ number_format($item['deliveryCharge'], 2, '.', ',') ?? '0.00' }}
                                    </td>
                                    <td>
                                        {{ number_format($item['commission'], 2, '.', ',') ?? '0.00' }}
                                    </td>
                                    <td>
                                        {{ number_format($item['total'], 2, '.', ',') ?? '0.00' }}
                                    </td>
                                    <td>
                                        @if ($item['orderStatus'] == "PAID")
                                            <div class="badge badge-success">{{ $item['orderStatus'] }}</div>
                                        @else 
                                            <div class="badge badge-warning">{{ $item['orderStatus'] }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item['deliveryStatus'] == "DELIVERED_TO_CUSTOMER")
                                            <div class="badge badge-success">{{ $item['deliveryStatus'] }}</div>
                                        @elseif($item['deliveryStatus'] == "REJECTED_BY_STORE")
                                            <div class="badge badge-danger">{{ $item['deliveryStatus'] }}</div>
                                        @elseif($item['deliveryStatus'] == "CANCELED_BY_CUSTOMER")
                                            <div class="badge badge-warning">{{ $item['deliveryStatus'] }}</div>
                                        @else 
                                            <div class="badge badge-light">{{ $item['deliveryStatus'] }}</div>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        <button class="btn btn-dark" 
                                        data-toggle="modal" 
                                        data-target="#exampleModal"
                                        data-cust_name="{{ $item['customerName'] }}"
                                        data-date="{{ $date }}"
                                        data-merchant_name="{{ $item['merchantName'] }}"
                                        data-store_name="{{ $item['storeName'] }}"
                                        data-sub_total="{{ $item['subTotal'] }}"
                                        data-total="{{ $item['total'] }}"
                                        data-service_charge="{{ $item['serviceCharge'] }}"
                                        data-delivery_charge="{{ $item['deliveryCharge'] }}"
                                        data-order_status="{{ $item['orderStatus'] }}"
                                        data-delivery_status="{{ $item['deliveryStatus'] }}"
                                        data-commision="{{ $item['commission'] }}"
                                        >
                                            <i class="far fa-check-circle"></i>
                                            Details
                                        </button>
                                    </td> --}}
                                </tr>
                                @php $index++; @endphp
                            @endforeach
                        @endif
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>





