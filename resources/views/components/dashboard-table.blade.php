
<div class="card">
    <div class="card-header">
        <h4>Daily Sales Summary</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-md" id="table-1">
                <thead>
                    <tr class="text-center">
                    <th class="text-center">
                        #
                    </th>
                    <th>Due Date</th>
                    <th>Store Name</th>
                    <th>Total Order</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @foreach ($days as $day)
                        <tr class="text-center">
                            <td>
                                {{ $index }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($day['date'])->format('d/m/Y')}}
                            </td>
                            <td>
                                {{ $day['storeId'] }}
                            </td>
                            <td>
                                <strong>
                                    {{ $day['totalOrders'] }}
                                </strong>
                            </td>
                            <td>
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
                            </td>
                        </tr>
                        @php $index++; @endphp
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
