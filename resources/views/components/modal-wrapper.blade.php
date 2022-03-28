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
                        <button id="btnComplete" type="submit" class="btn btn-success float-left" onClick="this.form.submit(); this.disabled=true;">Refund Completed</button>  
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


<div class="modal fade" tabindex="-1" role="dialog" id="ActivityDetailsModal">
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

                <form  enctype="multipart/form-data" >
                    {{@csrf_field()}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Timestamp</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="acttimestamp">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Store Name</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="actstorename" name="refund_id">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Customer Name</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="actcustomername">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">Session Id</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="actsessionId">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Page Visited</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="actpagevisited">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">IP</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="actip">
                    </div>
                </div>
                    
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Device</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="actdevice">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="text-primary">OS</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="actos">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="text-primary">Browser</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="actbrowser" name="actbrowser">
                    </div>
                     <div class="form-group col-md-6">
                        <label class="text-primary">Error Type</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="acterrorType" name="acterrortype">
                    </div>
                </div>


                <div class="form-row">                   
                    <div class="form-group col-md-12">
                        <label class="text-primary">Error Message</label>
                        <input type="text" class="form-control-plaintext font-weight-bold" readonly="" id="acterrorType" name="acterroroccur">
                    </div>
                </div>

               
                </form>
                
            </div>
            
        </div>
    </div>
</div>