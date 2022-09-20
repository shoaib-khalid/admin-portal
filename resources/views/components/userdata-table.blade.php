@php
    // var_dump($datas);
    // dd($datas);
    $selectedCountry = Session::get('selectedCountry');
@endphp
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        function showMov(val) {
        sessionStorage.setItem('SelectedRegion', val);

            switch (val) {
                case 'MYS':
                {
                    $('#PAK_form').hide();
                    $('#MYS_form').show();
                    $('#moveform').attr('action', 'userdata-table.blade.php');
                    break;
                }
                case 'PAK':
                {
                    $('#MYS_form').hide();
                    $('#PAK_form').show();
                    $('#moveform').attr('action', 'userdata-table.blade.php');
                    break;
                }
            }
        }

        $(function() {
            var selMovType = document.getElementById('region');
            var selectedRegion = sessionStorage.getItem('SelectedRegion');

                if (selectedRegion) {
                selMovType.value = selectedRegion;
            }

            var btnSubmit = document.getElementById('submit');

            btnSubmit.addEventListener('click', function() {
                window.location.reload();
            });
        });

    </script>
<div class="card section">
    <div class="card-header">
        <h4>Customer Data</h4>
    </div>
    <div class="card-body">
    <div class="form-group">

    <div class="row">
        <div class="col">
        
            <form action="filter_userdata" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                {{@csrf_field()}}
             <div class="input-group mb-3">
                <div class="col-2">Customer Name</div>
                    <div class="col-4">
                        <input type="text" name="custname_chosen" id="custname_chosen" class="form-control" value="{{$custnamechosen}}">
                    </div>
                </div>  
            <div class="input-group mb-3">
            <div class="col-2">By Country</div>
                <div class="col-4">
                <select class="form-select form-select-lg mb-3" id="region" name="region" onchange="showMov(this.value);">
                    <option  value="MYS" <?php if ($selectedCountry=="MYS") echo "selected"; ?>>Malaysia</option>
                    <option  value="PAK" <?php if ($selectedCountry=="PAK") echo "selected"; ?>>Pakistan</option>
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
            <form action="export_userdata" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                {{@csrf_field()}}
                <button type="submit" class="btn btn-success icon-left btn-icon float-right"><i class="fas fa-file"></i> <span>Export Excel</span>
                </button>
            </form>
        </div>
    </div>

    </div>

        <div class="table-responsive">

           
        <table class="table table-striped" id="table-3">        
                <thead>
                    <tr class="text-center">                       
                        <th colspan="2" rowspan="2">Customer Name</th>
                        <th colspan="2" rowspan="2">Email</th>
                        <th colspan="2" rowspan="2">Phone No</th>
                        <th colspan="2" rowspan="2">Created Date</th> 
                        <th colspan="3">Order History</th>
                    </tr>
                    <tr>
                        <th>Abandon Cart</th>
                        <th>Completed Order</th>
                        <th>Incompleted Order</th>
                    </tr>
                </thead>      
                <tbody>
                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td  colspan="2" rowspan="2">{{ $data['name'] }}</td>
                            <td  colspan="2" rowspan="2">{{ $data['email'] }}</td>
                            <td  colspan="2" rowspan="2">{{ $data['phoneNumber'] }}</td>
                            <td  colspan="2" rowspan="2">{{ \Carbon\Carbon::parse($data['created'])->format('d/m/Y') }}</td>
                            <td  rowspan="2">{{ $data['abandonCart'] }}</td>
                            <td  rowspan="2">{{ $data['Completed'] }}</td>
                            <td  rowspan="2">{{ $data['Incomplete'] }}</td>
                        </tr>
                        <tr></tr>
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





