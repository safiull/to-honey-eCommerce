<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order_details_infos = '';
    public function __construct($invoice)
    {
        $this->order_details_infos = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->markdown('mail.PurchaseConfirmMail')->subject('Purchase confirmation mail');
        return $this->view('mail.PurchaseConfirmMail',[
            'order_details_infos' => $this->order_details_infos
        ]);
    }
}
