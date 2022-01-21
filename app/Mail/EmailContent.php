<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailContent 
{
    public $orderId;
    public $attachmentFile;
    public $orderDetails;
    public $orderItems;
    public $attachmentData;
    public $attachmentMimeType;
    public $attachmentFileName;
}
