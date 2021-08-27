
<div class="card section">
    <div class="card-header">
        <h4>Settlement</h4>
    </div>
    <div class="card-body">

        <div class="form-group">

            <div class="row">
                <div class="col">
                    
                    <form action="/filter_settlement" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <div class="input-group mb-3">
                            <input type="text" name="date_chosen3" id="date_chosen3" class="form-control daterange-btn3">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col">
                    
                </div>
                <div class="col">
                    <form action="/export_settlement" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <input type="text" name="date_chosen3" id="date_chosen3_copy" class="form-control daterange-btn3" hidden>
                        <button type="submit" class="btn btn-success icon-left btn-icon float-right"><i class="fas fa-file"></i> <span>Export Excel</span>
                        </button>
                    </form>
                </div>
            </div>
            
        </div>

        <div class="table-responsive">
            <table class="table table-md table-hover table-borderless" id="table-3">
                <thead>
                    <tr class="text-center">
                    {{-- <th>
                        #
                    </th> --}}
                    <th>Payout Date</th>
                    <th>Start Date</th>
                    <th>Cut-Off Date</th>
                    <th>Gross Amount</th>
                    <th>Service Charge</th>
                    <th>Delivery Charge</th>
                    <th>Commision</th>
                    <th>Nett Amount</th>
                    {{-- <th>Order Status</th> --}}
                    {{-- <th>Delivery Status</th> --}}
                    {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $index = 1; 
                    @endphp
                    @foreach ($datas as $data)
                        @if ($data['totalTransactionValue'] != null)
                            <tr class="text-center">

                                <td>
                                    {{ \Carbon\Carbon::parse($data['settlementDate'])->format('d/m/Y')}}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($data['cycleStartDate'])->format('d/m/Y')}}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($data['cycleEndDate'])->format('d/m/Y')}}
                                </td>
                                <td>
                                    {{ $data['totalServiceCharges'] }}
                                </td>
                                <td>
                                    {{ $data['totalServiceCharges'] }}
                                </td>
                                <td>
                                    {{ $data['totalServiceCharges'] }}
                                </td>
                                <td>
                                    {{ $data['totalCommissionFee'] }}
                                </td>
                                <td>
                                    {{ $data['totalCommissionFee'] }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>





