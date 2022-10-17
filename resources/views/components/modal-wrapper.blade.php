@php
    // var_dump($datas);
    // dd($datas);
@endphp

<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sales Order Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <div class="modal-body">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Date</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="date">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Customer Name</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="cust_name">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Store Name</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="store_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Store Owner</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="merchant_name">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Sub-Total (RM)</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="sub_total">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Total (RM)</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="total">
                    </div>
                </div>
                    
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Service Charge (RM)</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="service_charge">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Delivery Charge (RM)</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="delivery_charge">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Commision (RM)</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="commision">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Order Status</label>
                    <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="order_status">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Delivery Status</label>
                    <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="delivery_status">
                    </div>
                </div>

                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
            </div>
            
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="dailySalesModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daily Sales Summary</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <div class="modal-body">

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Date</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="date2">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Settlement Ref ID</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="settlement_id2">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Total Order</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="total_order2">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Commision</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="commision2">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Successful Order</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="success_order2">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Canceled Order</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="cancel_order2">
                    </div>
                </div>
                    
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Total Amount (RM)</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="total_amount2">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Earning (RM)</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="amount_earn2">
                    </div>
                </div>

                <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
            </div>
            
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="DailyDetailsModal">
    <div class="modal-dialog" role="document" style="max-width: 800px!important;">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Product Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <div class="modal-body">

                <form action="filter_daily_group_details" method="post" enctype="multipart/form-data" onload="document.getElementById('btnComplete').disabled=false;" >
                    {{@csrf_field()}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Total</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="Total2" name="Total2">
                    </div>
                </div>    
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Product Name</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="productname" name="productname">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Quantity</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="productquantity" name="productquantity">
                    </div>
                </div>                   
                </form>
                
            </div>
            
        </div>
    </div>
</div>

<!-- <div class="modal" tabindex="-1" role="dialog" id="ProductModal">
    <div class="modal-dialog" role="document" style="max-width: 900px!important;">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Customer Incomplete Order Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <div class="modal-body">

                <form action="userincompleteorder" method="post" enctype="multipart/form-data" onload="document.getElementById('btnComplete').disabled=false;" >
                    {{@csrf_field()}}
                    <table class="table table-bordered table-striped">
                        <thead class="btn-light">
                            <tr>
                            <th  width="50%">Product ID</th>
                            <th  width="40%">Product Name</th>
                            <th  width="10%">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td> <input type="text" class="form-control-plaintext font-weight-bold"  readonly="" id="productid2" name="productid2"></td>
                            <td> <input type="text" class="form-control-plaintext font-weight-bold"  readonly="" id="productname2" name="productname2"></td>
                            <td> <input type="text" class="form-control-plaintext font-weight-bold"  readonly="" id="productquantity2" name="productquantity2"></td>
                        </tbody>
                    </table>
                </form>
                
            </div>
            
        </div>
    </div>
</div> -->

<div class="modal" tabindex="-1" role="dialog" id="ProductModalDetails">
    <div class="modal-dialog" role="document" style="max-width: 900px!important;">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Customer Incomplete Order Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <!-- call product info from view -->
            <div class="modal-body">
            <table class="w-100" id="productinfo">
                      <tbody></tbody>
                   </table>
            </div>
            
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="IncompleteOrderDetails">
    <div class="modal-dialog" role="document" style="max-width: 900px!important;">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Incomplete Order - Product Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <!-- call product info from view -->
            <div class="modal-body">
            <table class="w-100" id="productincompleteinfo">
            <thead class="btn-light">
                            <tr>
                            <th  width="50%">Product ID</th>
                            <th  width="40%">Product Name</th>
                            <th  width="10%">Quantity</th>
                            </tr>
                        </thead>
                      <tbody>
                      </tbody>
                   </table>
            </div>
            
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" role="dialog" id="CompleteOrderDetails">
    <div class="modal-dialog" role="document" style="max-width: 900px!important;">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Complete Order - Product Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <!-- call product info from view -->
            <div class="modal-body">
            <table class="w-100" id="productcompleteinfo">
            <thead class="btn-light">
                            <tr>
                            <th  width="50%">Product ID</th>
                            <th  width="40%">Product Name</th>
                            <th  width="10%">Quantity</th>
                            </tr>
                        </thead>
                      <tbody>
                      </tbody>
                   </table>
            </div>
            
        </div>
    </div>
</div>



<div class="modal" tabindex="-1" role="dialog" id="AbandonCartDetails">
    <div class="modal-dialog" role="document" style="max-width: 900px!important;">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Abandon Cart - Product Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <!-- call product info from view -->
            <div class="modal-body">
            <table class="w-100" id="abandoncartinfo">
            <thead class="btn-light">
                            <tr>
                            <th  width="50%">Product ID</th>
                            <th  width="40%">Product Name</th>
                            <th  width="10%">Quantity</th>
                            </tr>
                        </thead>
                      <tbody>
                      </tbody>
                   </table>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="RefundDetailsModal">
    <div class="modal-dialog" role="document" style="max-width: 1000px!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Refund Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <div class="modal-body">

                <form action="update_refund" method="post" enctype="multipart/form-data" onload="document.getElementById('btnComplete').disabled=false;" >
                    {{@csrf_field()}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Date Created</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="created">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Refund Id</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="refund_id" name="refund_id">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Invoice No</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="invoice_id">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Store Name</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="storename">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Customer Name</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="customer_name">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Refund Type</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="refund_type">
                    </div>
                </div>
                    
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Refund Amount</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="refund_amount">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Payment Channel</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="payment_channel">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="text-primary">Remarks<span style="color:red" class="required">*</span></label>
                        <input type="text" class="form-control font-weight-bold" required="" id="remarks" name="remarks" required>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="text-primary">Upload Refund Proof<span style="color:red" class="required">*</span></label>
                        <input type="file" class="form-control font-weight-bold" required="" id="proof" name="proof" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button id="btnComplete" name="submit" type="submit" class="btn btn-success float-left" onClick="this.form.submit(); this.disabled=true;">Refund Completed</button>  
                    </div>
                    <div class="form-group col-md-6">
                        <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                    </div>  
                </div>
                
                </form>
                
            </div>
            
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" id="RefundHistoryDetailsModal">
    <div class="modal-dialog" role="document" style="max-width: 1000px!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Refund History Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <div class="modal-body">

                <form action="update_refund" method="post" enctype="multipart/form-data" >
                    {{@csrf_field()}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Date Created</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="created2">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Refund Id</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="refund_id2" name="refund_id">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Invoice No</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="invoice_id2">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Store Name</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="storename2">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Customer Name</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="customer_name2">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Refund Type</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="refund_type2">
                    </div>
                </div>
                    
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Refund Amount</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="refund_amount2">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Payment Channel</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="payment_channel2">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="text-primary">Remarks</label>
                        <input type="text" class="form-control font-weight-bold" readonly="" id="remarks2" name="remarks2">
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="text-primary">Refund Proof</label>
                        <img id="prooffile" src="">
                    </div>
                </div>

               
                </form>
                
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="SettlementDetailsModal">
    <div class="modal-dialog" role="document" style="max-width: 1000px!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Settlement Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <div class="modal-body">

                <form action="update_settlement2" method="post" enctype="multipart/form-data" onload="document.getElementById('btnSComplete').disabled=false;" >
                    {{@csrf_field()}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Payout Date</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="spayoutdate">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Store Name</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="sstorename">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Start Date</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="sstartdate">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Cut-Off Date</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="scutoffdate">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Gross Amount</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="sgrossamount">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Service Charge</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="sservicecharge">
                    </div>
                </div>
                    
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Delivery Charge</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="sdeliverycharge">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Commission</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="scommission">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Nett Amount</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="snettamount">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Settlement Id</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="sid" name="sid">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="text-primary">Remarks</label>
                        <input type="text" class="form-control font-weight-bold" id="sremarks" name="sremarks">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button id="btnSComplete" type="submit" class="btn btn-success float-left" onClick="this.form.submit(); this.disabled=true;">Update Details</button>  
                    </div>
                    <div class="form-group col-md-6">
                        <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                    </div>  
                </div>
                
                </form>
                
            </div>
            
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="ActivityModal">
    <div class="modal-dialog" role="document" style="max-width: 1000px!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Customer Activity Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <div class="modal-body">

                <table class="w-100" id="activitydetails">
                    <thead class="btn-light">
                            <tr>
                            <th  width="50%">Page Visited</th>
                            <th  width="20%">Store</th>
                            <th  width="10%">Channel</th>
                            <th  width="20%">Created</th>
                            </tr>
                        </thead>
                      <tbody>
                      </tbody>
                   </table>
                
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="CartDetailsModal">
    <div class="modal-dialog" role="document" style="max-width: 1000px!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cart Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <div class="modal-body">

                <table class="w-100" id="cartdetails">
                    <thead class="btn-light">
                            <tr>
                            <th  width="45%">CartId</th>
                            <th  width="45%">Store</th>
                            <th  width="10%">Item Added</th>                            
                            </tr>
                        </thead>
                      <tbody>
                      </tbody>
                   </table>
                
            </div>
            
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="OrderDetailsModal">
    <div class="modal-dialog" role="document" style="max-width: 1000px!important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <a href="#" class="btn btn-icon btn-sm btn-danger" data-dismiss="modal" aria-label="Close" style="border-radius: 100px;"><i class="fas fa-times"></i></a> --}}
            </div>
            <div class="modal-body">

                <table class="w-100" id="orderdetails">
                    <thead class="btn-light">
                            <tr>
                            <th  width="10%">OrderId</th>
                            <th  width="20%">Store</th>
                            <th  width="20%">Status</th>
                            <th  width="10%">InvoiceId</th>
                            <th  width="20%">Payment Status</th>
                            <th  width="10%">Created</th>
                            </tr>
                        </thead>
                      <tbody>
                      </tbody>
                   </table>
                
            </div>
            
        </div>
    </div>
</div>