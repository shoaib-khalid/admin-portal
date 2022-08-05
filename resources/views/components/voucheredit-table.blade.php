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
                        <div class="col-3">
                         <input type="radio" id="deliverin" name="voucherType" value="PLATFORM" <?php if ($voucher->voucherType=="PLATFORM") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="deliverin">PLATFORM</label>&nbsp;&nbsp;
                        <input type="radio" id="store" name="voucherType" value="STORE" <?php if ($voucher->voucherType=="STORE") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="store">Store</label>
                        </div>     
               
                    </div> 

                     <div class="input-group mb-3">                        

                        <div class="col-3">Vertical Code</div>
                        <div class="col-7">
                            <?php 
                            foreach ($verticalList as $vertical) {
                                $checked[$vertical->code] = "";
                            }
                            foreach ($voucherVerticalList as $verticalCode) {
                                $checked[$verticalCode] = "checked";    
                            }     
                            //dd($checked);                       
                            ?>
                            @foreach ($verticalList as $vertical)
                            <input type="checkbox" value="{{$vertical->code}}" name="verticalList[]"{{$checked[$vertical->code]}} <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>> 
                            <label for="verticalList[]">{{$vertical->code}}</label>&nbsp;&nbsp;&nbsp;                       
                            @endforeach
                        
                        </div>                      
                    </div>  

                     <div class="input-group mb-3">
                        <div class="col-3">Select Store</div>

                        <div class="col-7">

                            <div class="input-group mb-3">
                                <select name="selectStore" id="selectStore" <?php if ($voucher->voucherType!="STORE") { ?> disabled="true" <?php } ?> class="form-control" <?php if ($voucher->totalRedeem>0) echo "disabled"; ?> >
                                <option></option>                            
                                @foreach ($storelist as $store)
                                <option value="{{$store->id}}" <?php if ($voucher->storeId==$store->id) echo "selected"; ?>>{{$store->name}}</option>                            
                                @endforeach
                            </select>
                                <div class="input-group-append">
                                    <button class="btn btn-success" id="addStore" type="button"><i class="fas fa-plus"></i> <span>Add</span></button>
                                </div>
                            </div>   

                        
                        </div>
                       
                    </div>

                     <div class="input-group mb-3">
                        <div class="col-3"></div>
                        <div class="col-7">
                                 <ul name="selectedStoreList" id="selectedStoreList">
                                    @foreach ($selectedStorelist as $store)
                                    <li><?php echo $store['name']; ?>&nbsp;&nbsp;<button type="button" class="delete btn btn-danger icon-left btn-icon" onclick="deleteStore(this)">Delete</button><input type="hidden" name="addStoreList[]" value="<?php echo $store['storeId']; ?>"/></li>
                                    @endforeach
                                 </ul>                
                        </div>
                       
                    </div>   

                  <div class="input-group mb-3">
                        
                         <div class="col-3">Currency Label</div>
                        <div class="col-3">                    
                         <input type="radio" id="rm" name="currencyLabel" value="RM" <?php if ($voucher->currencyLabel=="RM") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="rm">RM</label>&nbsp;&nbsp;
                        <input type="radio" id="rs" name="currencyLabel" value="Rs." <?php if ($voucher->currencyLabel=="Rs.") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="rs">Rs.</label>
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
                        <input type="text" name="name" id="name" class="form-control" value="{{ $voucher->name }}" <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                        </div>                       
                    </div>
                     <div class="input-group mb-3">
                        <div class="col-3">Minimum Spend</div>
                        <div class="col-3">
                        <input type="text" name="minimumSpend" id="minimumSpend" class="form-control" value="{{ $voucher->minimumSpend }}" <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                        </div>  
                    </div> 
                     
                    <div class="input-group mb-3">
                        <div class="col-3">Discount On</div>
                        <div class="col-7">
                        <input type="radio" id="totalsales" name="discountType" value="TOTALSALES" <?php if ($voucher->discountType=="TOTALSALES") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="totalsales">Total Sales</label>&nbsp;&nbsp;
                        <input type="radio" id="shipping" name="discountType" value="SHIPPING" <?php if ($voucher->discountType=="SHIPPING") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="shipping">Shipping</label>&nbsp;&nbsp;                        
                        </div>                     
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Discount Calculation</div>
                        <div class="col-7">
                        <input type="radio" id="calculationType" name="calculationType" value="FIX" <?php if ($voucher->calculationType=="FIX") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="FIX">Fix</label>&nbsp;&nbsp;
                        <input type="radio" id="calculationType" name="calculationType" value="PERCENT" <?php if ($voucher->calculationType=="PERCENT") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="PERCENT">Percentage</label>&nbsp;&nbsp; 
                         <input type="radio" id="calculationType" name="calculationType" value="SHIPAMT" <?php if ($voucher->calculationType=="SHIPAMT") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="SHIPAMT">Shipping Amount</label>&nbsp;&nbsp;                        
                        </div>                     
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Discount Value</div>
                        <div class="col-3">
                        <input type="text" name="discountValue" id="discountValue" class="form-control" value="{{ $voucher->discountValue }}" <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                        </div>  
                        <div class="col-3">Discount Capped Amount</div>
                        <div class="col-3">
                        <input type="text" name="maxDiscountAmount" id="maxDiscountAmount" class="form-control" value="{{ $voucher->maxDiscountAmount }}" <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                        </div>                     
                    </div>
                    <div class="input-group mb-3">
                        <div class="col-3">Voucher Code</div>
                        <div class="col-3">
                        <input type="text" name="voucherCode" id="voucherCode" class="form-control" value="{{ $voucher->voucherCode }}" <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                        </div>  
                        <div class="col-3">Quantity Limit</div>
                        <div class="col-3">
                        <input type="text" name="totalQuantity" id="totalQuantity" class="form-control" value="{{ $voucher->totalQuantity }}" <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                        </div>                     
                    </div>

                    <div class="input-group mb-3">
                        <div class="col-3">Allow Double Discount?</div>
                        <div class="col-3">
                        <input type="radio" id="allowdouble" name="allowDoubleDiscount" value="1" <?php if ($voucher->allowDoubleDiscount=="1") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="allowdouble">Yes</label>&nbsp;&nbsp;
                        <input type="radio" id="notallowdouble" name="allowDoubleDiscount" value="0" <?php if ($voucher->allowDoubleDiscount=="0") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="notallowdouble">No</label>&nbsp;&nbsp;                        
                        </div>  

                        <div class="col-3">Limit redeem quantity</div>
                        <div class="col-3">
                        <input type="radio" id="checkredeem" name="checkTotalRedeem" value="1" <?php if ($voucher->checkTotalRedeem=="1") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="checkredeem">Yes</label>&nbsp;&nbsp;
                        <input type="radio" id="notcheckredeem" name="checkTotalRedeem" value="0" <?php if ($voucher->checkTotalRedeem=="0") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="notcheckredeem">No</label>&nbsp;&nbsp;                        
                        </div>                     
                    </div>

                     <div class="input-group mb-3">
                        <div class="col-3">New User Voucher</div>
                        <div class="col-3">
                        <input type="radio" id="isnew" name="isNewUserVoucher" value="1" <?php if ($voucher->isNewUserVoucher=="1") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="isnew">Yes</label>&nbsp;&nbsp;
                        <input type="radio" id="notnew" name="isNewUserVoucher" value="0" <?php if ($voucher->isNewUserVoucher=="0") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="notnew">No</label>&nbsp;&nbsp;                        
                        </div>                    
                    </div>

                     <div class="input-group mb-3">
                        <div class="col-3">Registered User Only</div>
                        <div class="col-3">
                        <input type="radio" id="requireclaim" name="requireToClaim" value="1" <?php if ($voucher->requireToClaim=="1") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="requireclaim">Yes</label>&nbsp;&nbsp;
                        <input type="radio" id="notrequireclaim" name="requireToClaim" value="0" <?php if ($voucher->requireToClaim=="0") echo "checked"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
                            <label for="notrequireclaim">No</label>&nbsp;&nbsp;                        
                        </div>                    
                    </div>

                     <div class="input-group mb-3">
                        <div class="col-3">Status</div>
                        <div class="col-7">
                        <select name="status" class="form-control">
                            <option <?php if ($voucher->status=="ACTIVE") echo "selected"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>ACTIVE</option>
                            <option <?php if ($voucher->status=="INACTIVE") echo "selected"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>INACTIVE</option>
                            <option <?php if ($voucher->status=="DELETED") echo "selected"; ?> <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>DELETED</option>                            
                        </select>
                        </div>
                       
                    </div>                   

                    <div class="input-group mb-3">
                        <div class="col-3">Special Voucher Condition</div>
                        <div class="col-7">
                        <select class="form-control" <?php if ($voucher->totalRedeem>0) echo "disabled"; ?>>
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
                        <textarea name="terms" id="terms" class="form-control" value="" style="height:100px !important"><?php foreach ($termsList as $term) { 
                                echo $term."\n";
                            } ?></textarea>
                        </div>                          
                    </div>
                     <div class="input-group mb-3">
                        <div class="col-3">Update Reason</div>
                        <div class="col-7">
                        <textarea name="reason" id="reason" class="form-control" required>{{$voucher->editReason}}</textarea>
                        </div>                          
                    </div>
                     <div class="input-group mb-3">
                         <div class="col-4">
                        <input type="hidden" name="voucherId" value="{{ $voucher->id }}">
                           <button type="submit" class="btn btn-success icon-left btn-icon" style="margin-bottom: 1rem!important;" ><i class="fas fa-save"></i> <span>Update Voucher</span>
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





