<?php

namespace App\Jobs;

use App\Http\Facades\Weixin;
use App\Models\Weixin_User;
use App\Models\Weixin_User_Tags;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WeixinSyncJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $tags;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tags = null)
    {
        $this->tags = $tags;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->tags) {
            case 'tags':
                $this->syncTags();
                break;
            default:
                $this->sync();
                break;
        }
    }

    private function sync($openid = null)
    {
        $list = Weixin::userList($openid);
        if (isset($list->data)) {
            foreach ($list->data->openid as $key => $value) {
                $item = Weixin::userInfo($value);
                if (isset($item)) {
                    $user = Weixin_User:: firstOrNew(['openid' => $item->openid]);
                    $user->fill(objectToArray($item));
                    $user->subscribe_time = date('Y-m-d H:i:s', $item->subscribe_time);

                    $user->save();
                }
            }
        }
        if (isset($list->next_openid)) {
            $this->sync($list->next_openid);
        }
    }


    private function syncTags()
    {
        $list = Weixin::userTags();
        if (isset($list->tags)) {
            foreach ($list->tags as $key => $value) {
                $userTags = Weixin_User_Tags:: firstOrNew(['id' => $value->id]);
                $userTags->fill(objectToArray($value));
                $userTags->save();
            }
        }
    }
}
