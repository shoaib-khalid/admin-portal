@php
    // var_dump($datas);
    // dd($datas);
@endphp
<div class="card section">
    <div class="card-header">
        <h4>Create New Voucher</h4>
    </div>
    <div class="card-body">

       <div class="form-group">

        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="row">
            <div class="col-12">
                
                <form action="post_voucheradd" method="post" enctype="multipart/form-data" accept-charset='UTF-8'>
                    {{@csrf_field()}}
                    <div class="input-group mb-3">
                        <div class="col-3">Voucher For</div>
                        <div class="col-3" class="form-control">
                        <input type="radio" id="deliverin" name="voucherType" value="PLATFORM">
                            <label for="deliverin">PLATFORM</label>&nbsp;&nbsp;
                        <input type="radio" id="store" name="voucherType" value="STORE">
                            <label for="store">Store</label>
                        </div>

                        <div class="col-3">Vertical Code</div>
                        <div class="col-3">
                        <select name="selectVertical" id="selectVertical" class="form-control" >   
                            <option></option>                         
                            @foreach ($verticalList as $vertical)
                            <option value="{{$vertical->code}}">{{$vertical->code}}</option>                            
                            @endforeach
                        </select>
                        </div>                      
                    </div> 

                    
                     <div class="input-group mb-3">
                        <div class="col-3">Select Store</div>
                        <div class="col-7">
                        <select name="selectStore" id="selectStore" disabled="true" class="form-control">   
                            <option></option>                         
                            @foreach ($storelist as $store)
                            <option value="{{$store->id}}">{{$store->name}}</option>                            
                            @endforeach
                        </select>
                        </div>
                       
                    </div> 

                    <div class="input-group mb-3">
                        
                         <div class="col-3">Currency Label</div>
                        <div class="col-3">
                        <input type="text" name="currencyLabel" id="currencyLabel" class="form-control" value="">
                        </div>                          
                    </div> 

                    <div class="input-group mb-3">
                        <div class="col-3">Start & End Date</div>
                        <div class="col-7">
                        <input type="text" name="date_range" id="date_range" class="form-control daterange-btn4" value="">
                        </div>                        
                    </div>                                
                    <div class="input-group mb-3">
                        <div class="col-3">Voucher Name</div>
                        <div class="col-7">
                        <input type="text" name="name" id="name" class="form-control" value="">
                        </div>                       
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Minimum Spend</div>
                        <div class="col-3">
                        <input type="text" name="minimumSpend" id="minimumSpend" class="form-control" value="">
                        </div>  
                    </div>                    
                    <div class="input-group mb-3">
                        <div class="col-3">Discount On</div>
                        <div class="col-7" >
                        <input type="radio" id="totalsales" name="discountType" value="TOTALSALES" >
                            <label for="totalsales">Total Sales</label>&nbsp;&nbsp;
                        <input type="radio" id="shipping" name="discountType" value="SHIPPING">
                            <label for="shipping">Shipping</label>&nbsp;&nbsp;                        
                        </div>                     
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Discount Calculation</div>
                        <div class="col-7">
                        <input type="radio" id="calculationType" name="calculationType" value="FIX">
                            <label for="FIX">Fix</label>&nbsp;&nbsp;
                        <input type="radio" id="calculationType" name="calculationType" value="PERCENT">
                            <label for="PERCENT">Percentage</label>&nbsp;&nbsp; 
                         <input type="radio" id="calculationType" name="calculationType" value="SHIPAMT">
                            <label for="SHIPAMT">Shipping Amount</label>&nbsp;&nbsp;                        
                        </div>                     
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Discount Value</div>
                        <div class="col-3">
                        <input type="text" name="discountValue" id="discountValue" class="form-control" value="">
                        </div>  
                        <div class="col-3">Discount Capped Amount</div>
                        <div class="col-3">
                        <input type="text" name="maxDiscountAmount" id="maxDiscountAmount" class="form-control" value="">
                        </div>                     
                    </div>
                    
                    <div class="input-group mb-3">
                        <div class="col-3">Voucher Code</div>
                        <div class="col-3">
                        <input type="text" name="voucherCode" id="voucherCode" class="form-control" value="">
                        </div>  
                        <div class="col-3">Quantity Limit</div>
                        <div class="col-3">
                        <input type="text" name="totalQuantity" id="totalQuantity" class="form-control" value="">
                        </div>                     
                    </div>

                    <div class="input-group mb-3">
                        <div class="col-3">Allow Double Discount?</div>
                        <div class="col-3">
                        <input type="radio" id="allowdouble" name="allowDoubleDiscount" value="1">
                            <label for="allowdouble">Yes</label>&nbsp;&nbsp;
                        <input type="radio" id="notallowdouble" name="allowDoubleDiscount" value="0">
                            <label for="notallowdouble">No</label>&nbsp;&nbsp;                        
                        </div>  

                        <div class="col-3">Limit redeem quantity</div>
                        <div class="col-3">
                        <input type="radio" id="checkredeem" name="checkTotalRedeem" value="1">
                            <label for="checkredeem">Yes</label>&nbsp;&nbsp;
                        <input type="radio" id="notcheckredeem" name="checkTotalRedeem" value="0">
                            <label for="notcheckredeem">No</label>&nbsp;&nbsp;                        
                        </div>                     
                    </div>
                    
                    <div class="input-group mb-3">
                        <div class="col-3">New User Voucher</div>
                        <div class="col-3">
                        <input type="radio" id="isnew" name="isNewUserVoucher" value="1">
                            <label for="isnew">Yes</label>&nbsp;&nbsp;
                        <input type="radio" id="notnew" name="isNewUserVoucher" value="0">
                            <label for="notnew">No</label>&nbsp;&nbsp;                        
                        </div>                    
                    </div>
                     <div class="input-group mb-3">
                        <div class="col-3">Special Voucher Condition</div>
                        <div class="col-7">
                        <select class="form-control">
                            <option>None</option>
                            <option>First Order transaction discount</option>
                            <option>Second Order transaction discount</option>
                            <option>Third Order transaction discount</option>
                        </select>
                        </div>
                       
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Terms and Conditions</div>
                        <div class="col-7">
                        <textarea name="terms" id="terms" class="form-control" value="" style="height:100px !important"></textarea>
                        </div>                          
                    </div>
                     <div class="input-group mb-3">
                         <div class="col-4">
                           <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;"><i class="fas fa-save"></i> <span>Create Voucher</span>
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





