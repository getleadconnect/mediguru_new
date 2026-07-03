<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseBill extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->details = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
		
    public function build()
    {
        //return $this->view('view.name');

		$mdata=$this->details;
        return $this->subject('Mail from mediguru.co.in')
				->attach($mdata['file'])
				->view('admin.bill_email_template.payment',compact('mdata'));
    }
	
	
}
