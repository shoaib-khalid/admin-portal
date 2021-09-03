@php
    // var_dump();
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Settlement</h4>
    </div>
    <div class="card-body">

        <div class="form-group">

            <div class="row">
                <div class="col">
                    
                    <form action="#" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <div class="input-group mb-3">
                            <input type="text" name="date_chosen4" id="date_chosen4" class="form-control daterange-btn4">
                            <div class="input-group-append">
                                <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col">
                    
                </div>
                <div class="col">
                    <form action="#" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <input type="text" name="date_chosen4" id="date_chosen4_copy" class="form-control daterange-btn4" hidden>
                        <button type="submit" class="btn btn-success icon-left btn-icon float-right"><i class="fas fa-file"></i> <span>Export Excel</span>
                        </button>
                    </form>
                </div>
            </div>
            
        </div>

        <div class="table-responsive">

            <table id="table-4" class="table table-md table-hover table-borderless">
                <thead>
                    <tr class="text-center">
                        <th>Merchant</th>
                        <th>Email</th>
                        <th>Bank Name</th>
                        <th>Account No.</th>
                        <th>Account Name</th>
                        <th></th>
                    </tr>
                </thead>
        
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['email'] }}</td>
                            @if ($data['bank_details'])
                                <td>{{ $data['bank_details'][0]['bankName'] }}</td>
                                <td>{{ $data['bank_details'][0]['bankAccountNumber'] }}</td>
                                <td>{{ $data['bank_details'][0]['bankAccountTitle'] }}</td>
                            @else
                                <td>N/A</td>
                                <td>N/A</td>
                                <td>N/A</td>
                            @endif
                            
                            <td>
                                <a href="#" class="btn btn-primary view_store" storeId="{{ $data['storeId'] }}">
                                    <i class="far fa-check-circle"></i>
                                    Details
                                </a>
                            </td>
                            {{-- <td>{{ $data->bankName }}</td>
                            <td>{{ $data->bankAccountNumber }}</td>
                            <td>{{ $data->bankAccountTitle }}</td> --}}
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





