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

                <form action="update_refund" method="post" enctype="multipart/form-data" >
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
                        <label class="text-primary">Remarks</label>
                        <input type="text" class="form-control font-weight-bold" id="remarks" name="remarks">
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="text-primary">Upload Refund Proof</label>
                        <input type="file" class="form-control font-weight-bold" id="proof" name="proof">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button type="submit" class="btn btn-success float-left">Refund Completed</button>  
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
                        <img id="proofimage" src="" alt="" title="" style="height: 600px !important;">
                    </div>
                </div>

               
                </form>
                
            </div>
            
        </div>
    </div>
</div>