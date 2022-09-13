@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Merchant App Activity</h4>
    </div>
    <div class="card-body">

        <div class="form-group">

            <div class="row">
                <div class="col">
                    
                    <form action="filter_merchantappactivity" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
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
                    <form action="export_merchant" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
                        <input type="text" name="date_chosen4_copy" id="date_chosen4_copy" class="form-control daterange-btn4" value="{{$datechosen}}" hidden>
                        <button type="submit" class="btn btn-success icon-left btn-icon float-right"><i class="fas fa-file"></i> <span>Export Excel</span>
                        </button>
                    </form>
                </div>
            </div>
            
        </div>

        <div class="table-responsive">

            <table id="table-4" class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>Created</th>
                        <th>Store Name</th>
                        <th>App Status</th>
                        <th>Last Seen</th>
                        <th>Store Operating Hour</th>
                        <th>Close</th>
                    </tr>
                </thead>
        
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ \Carbon\Carbon::parse($data['created'])->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['merchantstatus'] }}</td>
                            <td>{{ $data['lastseen'] }}</td>
                            <td>{{ $data['opentime'] }}-{{ $data['closetime'] }}</td>
                            <td>{{ $data['closing'] }}</td>
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





