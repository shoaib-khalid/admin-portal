@php
    // var_dump($datas);
    // dd($datas);
@endphp
<script type="text/javascript">
    function exportToExcel() {
        document.getElementById("exportExcel").value=1;
        document.getElementById("searchForm").submit();
    }
    function viewReport() {
        document.getElementById("exportExcel").value=0;
        document.getElementById("searchForm").submit();
    }
</script>
<div class="card section">
    <div class="card-header">
        <h4>Customer Summary by Date</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col-12">
                
                <form action="filter_useractivitysummarydate" method="post" enctype="multipart/form-data" accept-charset='UTF-8' id="searchForm">
                    {{@csrf_field()}}
                    <div class="input-group mb-3">
                        <div class="col-2">Date</div>
                        <div class="col-4">
                        <input type="text" name="date_chosen4" id="date_chosen4" class="form-control daterange-btn4" value="{{$datechosen}}">
                        </div>
                        <div class="col-2">Store</div>
                        <div class="col-4">
                        <input type="text" name="storename_chosen" id="storename_chosen" class="form-control" value="{{$storename}}">
                        </div>
                    </div>                   
                    <div class="input-group mb-3">
                        <div class="col-2">Browser</div>
                        <div class="col-4">
                        <input type="text" name="browser_chosen" id="browser_chosen" class="form-control" value="{{$browser}}">
                        </div>  
                        <div class="col-2">OS</div>
                        <div class="col-4">
                        <input type="text" name="device_chosen" id="device_chosen" class="form-control" value="{{$device}}">
                        </div>                  
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-2">Group By</div>
                        <div class="col-2">
                        <input type="checkbox" name="groupstore" id="groupstore" value="groupstore" <?php if ($groupstore<>"") echo "checked"; ?>>
                        Store
                        </div>
                        <div class="col-2">
                        <input type="checkbox" name="groupbrowser" id="groupbrowser" value="groupbrowser" <?php if ($groupbrowser<>"") echo "checked"; ?>>
                        Browser
                        </div>
                        <div class="col-2">
                        <input type="checkbox" name="groupdevice" id="groupdevice" value="groupdevice" <?php if ($groupdevice<>"") echo "checked"; ?>>
                        Device
                        </div>
                        <div class="col-2">
                        <input type="checkbox" name="groupos" id="groupos" value="groupos" <?php if ($groupos<>"") echo "checked"; ?>>
                        OS
                        </div>
                        <div class="col-2">
                        <input type="checkbox" name="grouppage" id="grouppage" value="grouppage" <?php if ($grouppage<>"") echo "checked"; ?>>
                        Page
                        </div>                      
                    </div>
                    <div class="input-group mb-3">
                        <label class="col-2" for="region">Choose:</label>
                        <div class="col-4">
                        <select class="form-select form-select-lg mb-3"  id="region" name="region">
                        <option  value="malaysia">Malaysia</option>
                        <option  value="pakistan">Pakistan</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-4"><button class="btn btn-danger" type="button" onclick="viewReport()"><i class="fas fa-search"></i> <span>Search</span></button>
                        </div>
                        <input type="hidden" name="exportExcel" id="exportExcel" value="0">
                        <div class="col-4"><button type="button" class="btn btn-success icon-left btn-icon float-right" onclick="exportToExcel()"><i class="fas fa-file"></i> <span>Export Excel</span>
                            </button>
                        </div>                  
                    </div>
                    
                </form>
            </div>
            <div class="col-1">
                
            </div>
            
        </div>


        <div class="table-responsive">

            <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th>Date</th>
                        <?php if ($groupstore<>"") { ?>
                        <th>Store</th>
                        <?php } ?>
                        <?php if ($groupdevice<>"") { ?>
                        <th>Device</th>
                        <?php } ?>
                        <?php if ($groupos<>"") { ?>
                        <th>OS</th>
                        <?php } ?>
                        <?php if ($groupbrowser<>"") { ?>
                        <th>Browser</th>
                        <?php } ?>
                        <?php if ($grouppage<>"") { ?>
                        <th>Page</th>
                        <?php } ?>
                        <th>Total Hits</th> 
                        <?php if ($groupstore<>"") { ?> 
                        <th>Total Unique Guest By Store</th>    
                        <th>Total Unique User By Store</th>    
                        <?php } else { ?>
                        <th>Total Unique Guest</th>    
                        <th>Total Unique User</th>    
                        <?php } ?>   
                    </tr>
                </thead>      
                <tbody>                    
                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data->dt }}</td>
                            <?php if ($groupstore<>"") { ?>
                            <td>{{ $data->storeName }}</td>
                            <?php } ?>
                            <?php if ($groupdevice<>"") { ?>
                            <td>{{ $data->device }}</td>
                            <?php } ?>
                            <?php if ($groupos<>"") { ?>
                            <td>{{ $data->os }}</td>
                            <?php } ?>
                            <?php if ($groupbrowser<>"") { ?>
                            <td>{{ $data->browser }}</td>
                            <?php } ?>
                            <?php if ($grouppage<>"") { ?>
                            <td>{{ $data->page }}</td>
                            <?php } ?>
                            <td>{{ $data->total }}</td>                                               
                            <td>{{ $data->totalGuest }}</td> 
                            <td>{{ $data->totalUser }}</td> 
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