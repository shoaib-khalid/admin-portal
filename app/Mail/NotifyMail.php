<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Mail\EmailContent;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $emailContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EmailContent $emailContent)
    {
        //
         $this->emailContent = $emailContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('finance@symplified.biz', 'Symplified')
                ->subject('Your refund has been completed')
                ->view('emails.notificationMail')
                ->with('emailContent', $this->emailContent)
                ->attachData($this->emailContent->attachmentData, $this->emailContent->attachmentFileName, [
                    'mime' => $this->emailContent->attachmentMimeType]
                );
    }
}
