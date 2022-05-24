@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Available Promo Text</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col-12">
                
                <?php if ($promodata!=null) { ?>
                    <?php //dd($promodata) ?>
                    <form action="post_editpromotext" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                        {{@csrf_field()}} 
                        <input type="hidden" name="id" value="{{ $promodata->id }}">
                        <div class="input-group mb-3">  
                            <div class="col-3">Select Vertical</div>
                            <div class="col-7">
                            <select name="selectVertical" id="selectVertical" class="form-control">   
                                <option></option>                         
                                @foreach ($verticallist as $vertical)
                                <option value="{{$vertical->code}}" <?php if ($promodata->verticalCode==$vertical->code) echo "selected"; ?>>{{$vertical->code}}</option>                            
                                @endforeach
                            </select>
                            </div>
                        </div>  
                        <div class="input-group mb-3">  
                            <div class="col-3">Select Event</div>
                            <div class="col-7">
                            <select name="selectEvent" id="selectEvent" class="form-control">   
                                <option></option>                         
                                @foreach ($eventlist as $event)
                                <option value="{{$event}}" <?php if ($promodata->eventId==$event) echo "selected"; ?>>{{$event}}</option>                            
                                @endforeach
                            </select>
                            </div>
                        </div> 
                        <div class="input-group mb-3">  
                            <div class="col-3">Display Text</div>
                            <div class="col-7">
                             <textarea name="displayText" id="displayText" class="form-control" value="" style="height:100px !important">{{$promodata->displayText}}</textarea>
                            </div>
                        </div>                                  
                        <div class="input-group mb-3">                        
                            <div class="col-2">
                                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> <span>Save</span></button>
                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                        <form action="add_promotext" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>                                        
                        {{@csrf_field()}}  
                        <div class="input-group mb-3">  
                            <div class="col-3">Select Vertical</div>
                            <div class="col-7">
                            <select name="selectVertical" id="selectVertical" class="form-control">   
                                <option></option>                         
                                @foreach ($verticallist as $vertical)
                                <option value="{{$vertical->code}}">{{$vertical->code}}</option>                            
                                @endforeach
                            </select>
                            </div>
                        </div>  
                        <div class="input-group mb-3">  
                            <div class="col-3">Select Event</div>
                            <div class="col-7">
                            <select name="selectEvent" id="selectEvent" class="form-control">   
                                <option></option>                         
                                @foreach ($eventlist as $event)
                                <option value="{{$event}}">{{$event}}</option>                            
                                @endforeach
                            </select>
                            </div>
                        </div> 
                        <div class="input-group mb-3">  
                            <div class="col-3">Display Text</div>
                            <div class="col-7">
                             <textarea name="displayText" id="displayText" class="form-control" value="" style="height:100px !important"></textarea>
                            </div>
                        </div>                                  
                        <div class="input-group mb-3">                        
                            <div class="col-2">
                                <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> <span>Save</span></button>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
            <div class="col-1">
                
            </div>
            
        </div>

    

        <div class="table-responsive">

            <table id="table-4" class="table table-striped">        
                <thead>
                    <tr class="text-center">
                        <th>Vertical Code</th>
                        <th>Event Id</th>
                        <th>DisplayText</th>     
                        <th></th>                  
                    </tr>
                </thead>      
                <tbody>

                    @foreach ($datas as $data)
                        <tr class="text-center">
                            <td>{{ $data['verticalCode'] }}</td>
                            <td>{{ $data['eventId'] }}</td>
                            <td>{{ $data['displayText'] }}</td>
                            <td>
                                <form action="edit_promotext" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-wrench"></i> 
                                    </button>
                                </form>
                                <form action="delete_promotext" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                                    {{@csrf_field()}}
                                     <input type="hidden" name="id" value="{{ $data['id'] }}">
                                     <button type="submit" class="btn btn-danger icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-window-close"></i> 
                                    </button>
                                </form>
                            </td>
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





