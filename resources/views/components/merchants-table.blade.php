
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
                        <th></th>
                        <th>Client</th>
                        <th>Project</th>
                        <th>Hours</th>
                        <th>Billed</th>
                        <th>Collected</th>
                    </tr>
                </thead>
        
                <tbody>
                    <tr class="text-center">
                        <td></td>
                        <td>ABC Company</td>
                        <td>1001-01</td>
                        <td>100</td>
                        <td>$5000</td>
                        <td>$2500</td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</div>





