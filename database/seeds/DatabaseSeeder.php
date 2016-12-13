<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => '后台管理员',
            'email' => 'admin@yeah.net',
            'password' => bcrypt('admin'),
        ]);

        User::create([
            'name' => '业务管理员',
            'email' => 'manage@yeah.net',
            'password' => bcrypt('manage'),
        ]);


        //系统参数
        $config = new Config();
        $config->name = "千番旅行";
        $config->logo = "logo.jpg";
        $config->domain = "http://www.1000fun.com";
        $config->assetsDomain = "http://assets.4255.cn";
        $config->tel = "023-68089477";
        $config->fax = "023-68692402";
        $config->email = "admin@4255.cn";
        $config->qq = "93894949";
        $config->addres = "重庆市九龙坡区奥体路1号";


        $config->save();

        $enterprise = new Enterprise();
        $enterprise->name = "重庆易游通科技有限公司";
        $enterprise->shortName = "易游通";
        $enterprise->linkMan = "吴红";
        $enterprise->mobile = "13983087661";
        $enterprise->tel = "023-68089455";
        $enterprise->fax = "023-68692402";
        $enterprise->qq = "93894949";
        $enterprise->email = "wuhong@yeah.net";
        $enterprise->address = "重庆市九龙坡区奥体路1号";
        $enterprise->save();

        $this->call(BaseDataSeeder::class);

    }
}
