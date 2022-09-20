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
                    <div class="col-2">Client Name</div>
                        <div class="col-4">
                        <input type="text" name="name_chosen" id="name_chosen" class="form-control" value="{{$namechosen}}">
                        </div>
                    </div>   
                    <div class="input-group mb-3">
                      <div class="col-2">By Country</div>
                        <div class="col-4">
                        <select class="form-select form-select-lg mb-3" id="region" name="region">
                         <option  value="all">All</option>
                         <option  value="MYS">Malaysia</option>
                         <option  value="PAK">Pakistan</option>
                        </select>
                      </div>   
                        <div class="input-group mb-3">
                        <div class="col-2"></div>
                        <div class="col-4">
                         <button class="btn btn-danger" id="submit" type="submit"><i class="fas fa-search"></i> <span>Search</span></button>
                        </div>                       
                    </div>
                    </form>
                </div>
                <div class="col-1">
                    
                </div>
                <div class="col">
                    <form action="export_merchantappactivity" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}}
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
                        <th>Registered Date</th>
                        <th>Client Name</th>
                        <th>Last Seen</th>
                        <th>Close</th>
                    </tr>
                </thead>
        
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ \Carbon\Carbon::parse($data['created'])->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($data['LastSeen'])->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $data['CloseTime']}}</td>
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
            {!! $datas->appends(request()->except('page'))->links("pagination::bootstrap-4") !!}      
        </div>
    </div>
</div>





