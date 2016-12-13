<?php

namespace App\Jobs;

use App\Mail\CustomerChangeMail;
use App\Models\Crm_Customer;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class CustomerChangeJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $customer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Crm_Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new CustomerChangeMail($this->customer));
    }

    /**
     * 失败通知
     *
     * @param  Exception $exception
     * @return void
     */
    public function failed(Exception $e)
    {
        // 发送失败通知, etc...
    }
}
