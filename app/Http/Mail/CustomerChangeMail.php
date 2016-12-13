<?php

namespace App\Mail;

use App\Models\Crm_Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Crm_Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (isset($this->customer->email)) {
            return $this->to($this->customer->email, $this->customer->name)->subject('客户信息变更通知')->view('emails.customerChang');
        }
    }
}
