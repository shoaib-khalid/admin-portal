
<div class="card section">
    <div class="card-header">
        <h4>Daily Details Sales</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-md" id="table-2">
                <thead>
                    <tr class="text-center">
                    <th>
                        #
                    </th>
                    <th>Customer Name</th>
                    <th>Store Name</th>
                    <th>Date</th>
                    <th>Order Status</th>
                    <th>Delivery Status</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @foreach ($datas as $data)
                        @if (count($data['sales']) > 0)
                            @php $date = $data['date']  @endphp
                            @foreach ($data['sales'] as $item)
                                <tr class="text-center">
                                    <td>
                                        {{ $index }}
                                    </td>
                                    <td>
                                        {{ $item['customerName'] }}
                                    </td>
                                    <td>
                                        {{ $item['storeName'] }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($date)->format('d/m/Y')}}
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
                                    <td>
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
                                        {{-- id="toggle-modal" --}}
                                        >
                                            <i class="far fa-check-circle"></i>
                                            Details
                                        </button>
                                    </td>
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





