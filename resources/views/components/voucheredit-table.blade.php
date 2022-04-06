@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Edit Voucher</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        <div class="row">
            <div class="col-12">
                
                <form action="post_voucheredit" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}
                    <div class="input-group mb-3">
                        <div class="col-3">Voucher For</div>
                        <div class="col-7">
                        <input type="radio" id="deliverin" name="voucherType" value="DELIVERIN" <?php if ($voucher->voucherType=="DELIVERIN") echo "checked"; ?>>
                            <label for="deliverin">Deliverin</label>&nbsp;&nbsp;
                        <input type="radio" id="easydukan" name="voucherType" value="EASYDUKAN" <?php if ($voucher->voucherType=="EASYDUKAN") echo "checked"; ?>>
                            <label for="easydukan">Easydukan</label>&nbsp;&nbsp;
                        <input type="radio" id="store" name="voucherType" value="STORE" <?php if ($voucher->voucherType=="STORE") echo "checked"; ?>>
                            <label for="store">Store</label>
                        </div>                      
                    </div>   
                     <div class="input-group mb-3">
                        <div class="col-3">Select Store</div>
                        <div class="col-7">
                        <select name="selectStore" id="selectStore" <?php if ($voucher->voucherType!="STORE") { ?> disabled="true" <?php } ?>>
                            <option></option>                            
                            @foreach ($storelist as $store)
                            <option value="{{$store->id}}" <?php if ($voucher->storeId==$store->id) echo "selected"; ?>>{{$store->name}}</option>                            
                            @endforeach
                        </select>
                        </div>
                       
                    </div>  
                    <div class="input-group mb-3">
                        <div class="col-3">Start & End Date</div>
                        <div class="col-7">
                        <input type="text" name="date_range" id="date_range" class="form-control daterange-btn4" value="{{ $voucher->startDate }} - {{ $voucher->endDate }}">
                        </div>                        
                    </div>                                
                    <div class="input-group mb-3">
                        <div class="col-3">Voucher Name</div>
                        <div class="col-7">
                        <input type="text" name="name" id="name" class="form-control" value="{{ $voucher->name }}">
                        </div>                       
                    </div>
                     <div class="input-group mb-3">
                        <div class="col-3">Special Voucher Condition</div>
                        <div class="col-7">
                        <select>
                            <option>None</option>
                            <option>First Order transaction discount</option>
                            <option>Second Order transaction discount</option>
                            <option>Third Order transaction discount</option>
                        </select>
                        </div>
                       
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Discount On</div>
                        <div class="col-7">
                        <input type="radio" id="totalsales" name="discountType" value="TOTALSALES" <?php if ($voucher->discountType=="TOTALSALES") echo "checked"; ?>>
                            <label for="totalsales">Total Sales</label>&nbsp;&nbsp;
                        <input type="radio" id="shipping" name="discountType" value="SHIPPING" <?php if ($voucher->discountType=="SHIPPING") echo "checked"; ?>>
                            <label for="shipping">Shipping</label>&nbsp;&nbsp;                        
                        </div>                     
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Discount Calculation</div>
                        <div class="col-7">
                        <input type="radio" id="calculationType" name="calculationType" value="FIX" <?php if ($voucher->calculationType=="FIX") echo "checked"; ?>>
                            <label for="FIX">Fix</label>&nbsp;&nbsp;
                        <input type="radio" id="calculationType" name="calculationType" value="PERCENT" <?php if ($voucher->calculationType=="PERCENT") echo "checked"; ?>>
                            <label for="PERCENT">Percentage</label>&nbsp;&nbsp; 
                         <input type="radio" id="calculationType" name="calculationType" value="SHIPAMT" <?php if ($voucher->calculationType=="SHIPAMT") echo "checked"; ?>>
                            <label for="SHIPAMT">Shipping Amount</label>&nbsp;&nbsp;                        
                        </div>                     
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Discount Value</div>
                        <div class="col-3">
                        <input type="text" name="discountValue" id="discountValue" class="form-control" value="{{ $voucher->discountValue }}">
                        </div>  
                        <div class="col-3">Discount Capped Amount</div>
                        <div class="col-3">
                        <input type="text" name="maxDiscountAmount" id="maxDiscountAmount" class="form-control" value="{{ $voucher->maxDiscountAmount }}">
                        </div>                     
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Voucher Code</div>
                        <div class="col-3">
                        <input type="text" name="voucherCode" id="voucherCode" class="form-control" value="{{ $voucher->voucherCode }}">
                        </div>  
                        <div class="col-3">Quantity Limit</div>
                        <div class="col-3">
                        <input type="text" name="totalQuantity" id="totalQuantity" class="form-control" value="{{ $voucher->totalQuantity }}">
                        </div>                     
                    </div>
                     <div class="input-group mb-3">
                        <div class="col-3">Status</div>
                        <div class="col-7">
                        <select name="status">
                            <option <?php if ($voucher->status=="ACTIVE") echo "selected"; ?>>ACTIVE</option>
                            <option <?php if ($voucher->status=="INACTIVE") echo "selected"; ?>>INACTIVE</option>                            
                        </select>
                        </div>
                       
                    </div>
                     <div class="input-group mb-3">
                         <div class="col-4">
                        <input type="hidden" name="voucherId" value="{{ $voucher->id }}">
                           <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-save"></i> <span>Update Voucher</span>
                            </button>
                        </div>                                    
                    </div>
                </form>
            </div>
            <div class="col-1">
                
            </div>
            
        </div>       

    </div>
</div>





