<!DOCTYPE html>
<head>
    <title>Successful Refund</title>
</head>
<body>
<div style="text-align: center;">
    <img src="{{ $emailContent->orderDetails['storeLogo'] }}" alt="store-logo" width="200">
    <br>
    <h3>Your refund has been completed</h3>
</div>
<!--Store details-->
<div style="background-color: #F8F8F8; padding: 5px; margin: 2;">
    <div>
        <h1>{{ $emailContent->orderDetails['storeName'] }}</h1>
        <h4>{{ $emailContent->orderDetails['storeAddress'] }}</h4>
    </div>
</div>
<!--Message-->
<div style="background-color: #F8F8F8; padding: 5px; margin: 2;">
    <div>
        <span>
            Dear customer,
        </span>
    </div>
</div>


<div style="background-color: #F8F8F8; padding: 5px; margin: 2;">
    <div>
        <span>
            We're glad to inform you that we have completed the refund process for your  canceled item(s) listed below. The amount has been transferred to the bank account based on the information provided to us. It may take 1 to 2 working days before it is reflected in your account.
        </span>
    </div>
</div>
<hr>
<!--Purchase Details-->
<div style="background-color: #F8F8F8; padding: 5px; margin: 2;">
    <div>
        <h4>
            Purchase Details:
        </h4>
        <span>
            <span style="font-weight: bold;">Invoice Number: </span>{{ $emailContent->orderDetails['invoiceId'] }}
        </span>
        <br/>
    <span>
            <span style="font-weight: bold;">Purchase Date: </span>{{ $emailContent->orderDetails['created'] }}
        </span>
        <br><br/>
        <table style="text-align: left;">
            <thead>
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col" style="text-align: center;">&nbsp;Price(RM)&nbsp;</th>
                    <th scope="col" style="text-align: center;">&nbsp;Quantity&nbsp;</th>
                    <th scope="col" style="text-align: right;">&nbsp;Total</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($emailContent->orderItems as $item)
                <tr>
                    <?php 
                    if (count($item->subItems)>0) {                   
                        $productSubItem="";
                        foreach ($item->subItems as $subItem) {
                            if ($productSubItem=="")
                                $productSubItem = $subItem->name;
                            else
                                $productSubItem = $productSubItem ."| ". $subItem->name;
                        }                    
                    ?>
                    <td><?php echo $item->name; ?> | <?php echo $productSubItem; ?></td>
                    <?php } else if ($item->productVariant != null) { ?>
                    <td>{{ $item->name }} | {{ $item->productVariant }}</td>
                    <?php } else { ?>
                    <td>{{ $item->name }}</td>
                    <?php } ?>
                    <td  style="text-align: center;">{{ $item->productPrice }}</td>
                    <td  style="text-align: center;">{{ $item->quantity }}</td>
                    <td  style="text-align: right;">{{ $item->price }}</td>
                </tr>
                @endforeach

        <tr><td colspan="4"><hr></td></tr>
    
        <tr>
                    <td style="font-weight: bold;">Sub Total</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{ $emailContent->orderDetails['subTotal'] }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Applied Discount</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{ $emailContent->orderDetails['appliedDiscount'] }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Takeaway Fee</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{ $emailContent->orderDetails['storeServiceCharges'] }}</td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Delivery Charges</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{ $emailContent->orderDetails['deliveryCharges'] }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Delivery Discount</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{ $emailContent->orderDetails['deliveryDiscount'] }}</td>
                </tr>
                <tr><td colspan="4"><hr></td></tr>
                <tr>
                    <td style="font-weight: bold;">Grand Total</td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{ $emailContent->orderDetails['total'] }}</td>
                </tr>
        <tr><td colspan="4"><hr></td></tr>
            </tbody>
        </table>
    </div>
</div>

<!--Delivery address-->
<div style="background-color: #F8F8F8; padding: 5px; margin: 2;">
    <div>
        <h4>
            Delivery Details:
        </h4>
        <span>
            <span style="font-weight: bold;">Address: </span>{{ $emailContent->orderDetails['shipmentAddress'] }}
        </span>
        <br>
        <span>
            <span style="font-weight: bold;">City: </span>{{ $emailContent->orderDetails['shipmentCity'] }}
        </span>
    </div>
</div>

<div style="background-color: #F8F8F8; padding: 5px; margin: 2;">
    <div>
        <h4>
            Payment Details:
        </h4>
        <span>
            <span style="font-weight: bold;">Channel: </span>{{ $emailContent->orderDetails['paymentChannel'] }}
        </span>
        <br>
        <span>
            <span style="font-weight: bold;">Payment Date: </span>{{ $emailContent->orderDetails['paymentDate'] }}
        </span>
    </div>
</div>


<!--Customer support messsage payment-confirmation-->
<div style="background-color: #F8F8F8; padding: 5px; margin: 2;">
    <div>
        <span>
            If there is any discrepancy in your order, please contact us at: store_contact
        </span>
    </div>
</div>
<!--Thanks messsage payment-confirmation-->
<div style="background-color: #F8F8F8; padding: 5px; margin: 2;">
    <div>
        <span>
            Thank you for your support. We look forward to serving you again in the future.
        </span>
    </div>
</div>


<!--Policy messsage refund-->
<div style="background-color: #F8F8F8; padding: 5px; margin: 2;">
    <div>
        <span>
            Is there something wrong with your Purchase?
            Call store_contact for your request.
        </span>
    </div>
</div>

<hr>
<div style="background-color: #F8F8F8; padding: 5px; margin: 0.5;">
    <span>
        Powered by <a href="https://symplified.biz/">SYMplified</a>
    </span>
</div>
</body>
</html>