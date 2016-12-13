<?php

namespace App\Jobs;

use App\Models\Crm_Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/**
 * 积分邮件
 * @package App\Jobs
 */
class CustomerIntegralChangeJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;


    protected $customer;

    /**
     * 创建任务实例
     *
     * @return void
     */
    public function __construct(Crm_Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * 执行任务
     *
     * @return void
     */
    public function handle()
    {
        Log::info($this->customer->name . '邮件发送成功');
    }
}
