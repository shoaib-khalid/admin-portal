@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Settlement</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col">
                
                <form action="filter_settlement2" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}
                    <div class="input-group mb-3">
                        <input type="text" name="date_chosen4" id="date_chosen4" class="form-control daterange-btn4" value="{{$datechosen}}">
                        <div class="input-group-append">
                            <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
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
                        <button type="submit" class="btn btn-success icon-left btn-icon float-right"><i class="fas fa-file"></i> <span>Export Excel</span>
                        </button>
                    </form>
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
                        <th>Nett Amount</th>
                        <th>Remarks</th>                    
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center" data-toggle="modal" data-target="#SettlementDetailsModal"
                                    data-payoutdate="{{ \Carbon\Carbon::parse($data['settlementDate'])->format('d/m/Y H:i:s') }}"
                                    data-storename="{{ $data['storeName'] }}"
                                    data-startdate="{{ \Carbon\Carbon::parse($data['cycleStartDate'])->format('d/m/Y H:i:s') }}"
                                    data-cutoffdate="{{ \Carbon\Carbon::parse($data['cycleEndDate'])->format('d/m/Y H:i:s') }}"
                                    data-grossamount="{{ $data['totalTransactionValue'] }}"
                                    data-servicecharge="{{ $data['totalServiceFee'] }}"
                                    data-deliverycharge="{{ $data['totalDeliveryFee'] }}"
                                    data-commission="{{ $data['totalCommisionFee'] }}"
                                    data-nettamount="{{ $data['totalStoreShare'] }}"
                                    data-remarks="{{ $data['remarks'] }}"
                                    data-id="{{ $data['id'] }}"
                                    >
                            <td>{{ \Carbon\Carbon::parse($data['settlementDate'])->format('d/m/Y') }}</td>
                            <td>{{ $data['storeName'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($data['cycleStartDate'])->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($data['cycleEndDate'])->format('d/m/Y') }}</td>
                            <td>{{ $data['totalTransactionValue'] }}</td>
                            <td>{{ $data['totalServiceFee'] }}</td>
                            <td>{{ $data['totalDeliveryFee'] }}</td>
                            <td>{{ $data['totalCommisionFee'] }}</td>
                            <td>{{ $data['totalStoreShare'] }}</td>
                            <td>{{ $data['remarks'] }}</td>                            
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





