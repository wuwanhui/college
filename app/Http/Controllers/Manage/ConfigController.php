<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Config;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ConfigController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/system/config']);
    }

    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $respJson = new RespJson();
        try {
            $config = Config::first();
            if (!$config) {
                $config = new Config();
            }
            if ($request->isMethod('POST')) {
                $input = $request->all();
                $validator = Validator::make($input, $config->Rules(), $config->messages());
                if ($validator->fails()) {
                    $respJson->setCode(2);
                    $respJson->setMsg("效验失败");
                    Log::info(json_encode($validator));
                    $respJson->setData($validator);
                    return response()->json($respJson);
                }
                $config->fill($input);
                $config->editId = Base::user('id');
                $config->editName = Base::user('name');


                if ($config->save()) {
                    Cache::pull('config');
                    $respJson->setData($config);
                    return response()->json($respJson);
                }
                $respJson->setCode(1);
                $respJson->setMsg("失败");
                return response()->json($respJson);
            }
            if (isset($request->json)) {
                $respJson->setData($config);
                return response()->json($respJson);
            }
            return view('manage.config.index', compact('config'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }
}
