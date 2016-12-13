<?php

namespace App\Mail;

use App\Models\Crm_Customer;
use App\Models\Crm_Customer_Integral;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddIntegralMail extends Mailable
{
    use Queueable, SerializesModels;

    public $integral;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Crm_Customer_Integral $integral)
    {
        $this->integral = $integral;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (isset($this->integral->customer->email)) {
            return $this->to($this->integral->customer->email, $this->integral->customer->name)->subject('积分变更通知')->view('emails.addIntegral');
        }
    }
}
