@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Refund History</h4>
    </div>
    <div class="card-body">

        <div class="form-group">

            <div class="row">
                <div class="col">
                    
                    <form action="filter_refundhistory" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
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
                    <form action="export_refundhistory" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <input type="text" name="date_chosen4_copy" id="date_chosen4_copy" class="form-control daterange-btn4" value="{{$datechosen}}" hidden>
                        <button type="submit" class="btn btn-success icon-left btn-icon float-right"><i class="fas fa-file"></i> <span>Export Excel</span>
                        </button>
                    </form>
                </div>
            </div>
            
        </div>

        <div class="table-responsive">

            <table id="table-4"  class="table table-md table-hover table-borderless">
                <thead>
                    <tr class="text-center">
                        <th>Date created</th>
                        <th>Invoice No</th>
                        <th>Store Name</th>
                        <th>Customer Name</th>
                        <th>Refund Type</th>
                        <th>Refund Amount</th>
                        <th>Payment Channel</th>
                        <th>Refund Status</th>
                        <th>Done Date</th>
                        <th>Remarks</th>                        
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center" data-toggle="modal" data-target="#RefundHistoryDetailsModal"
                                    data-created="{{ \Carbon\Carbon::parse($data['created'])->format('d/m/Y H:i:s') }}"
                                    data-refundid="{{ $data['id'] }}"
                                    data-invoiceid="{{ $data['invoiceId'] }}"
                                    data-storename="{{ $data['storeName'] }}"
                                    data-customername="{{ $data['customerName'] }}"
                                    data-refundtype="{{ $data['refundType'] }}"
                                    data-refundamount="{{ $data['refundAmount'] }}"
                                    data-paymentchannel="{{ $data['paymentChannel'] }}"
                                    data-refundstatus="{{ $data['refundStatus'] }}"
                                    data-remarks="{{ $data['remarks'] }}"
                                    data-proof="{{ asset('storage/refund').'/'.$data['proof'] }}"
                                    >
                            <td>{{ \Carbon\Carbon::parse($data['created'])->format('d/m/Y') }}</td>
                            <td>{{ $data['invoiceId'] }}</td>
                            <td>{{ $data['storeName'] }}</td>
                            <td>{{ $data['customerName'] }}</td>
                            <td>{{ $data['refundType'] }}</td>
                            <td>{{ $data['refundAmount'] }}</td>
                            <td>{{ $data['paymentChannel'] }}</td>
                            <td>{{ $data['refundStatus'] }}</td>
                            <td>{{ $data['refunded'] }}</td>
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




