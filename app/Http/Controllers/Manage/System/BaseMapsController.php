<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Base_Maps;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class BaseMapsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/maps']);
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
            if ($request->isMethod('POST')) {
                $inputs = $request->maps;
                foreach ($inputs as $key => $item) {
                    $map = Base_Maps::firstOrNew([
                        'key' => $item['key'],
                    ]);
                    $map->tag = $item['tag'];
                    $map->value = $item['value'];
                    $map->save();
                }
                $respJson->setMsg("保存成功");
                $respJson->setData(Base_Maps::all());
                return response()->json($respJson);
            }

            if (isset($request->json)) {

                $maps = Base_Maps::all();
                $mapItem = new Base_Maps();
                $obj = new stdClass();
                $obj->data = $maps;
                $obj->type = $mapItem->type();
                $obj->control = $mapItem->control();
                $respJson->setData($obj);
                return response()->json($respJson);
            }
            return view('manage.system.basemaps.index');
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function create(Request $request)
    {
        $respJson = new RespJson();
        try {
            $maps = new Base_Maps();
            if ($request->isMethod('POST')) {
                $input = $request->all();
                $validator = Validator::make($input, $maps->Rules(), $maps->messages());
                if ($validator->fails()) {
                    $respJson->setCode(2);
                    $respJson->setMsg("效验失败");
                    $respJson->setData($validator);
                    return response()->json($respJson);
                }
                $maps->fill($input);
                $maps->save();
                if ($maps) {
                    $respJson->setData($maps);
                    return response()->json($respJson);
                }
                $respJson->setCode(1);
                $respJson->setMsg("失败");
                return response()->json($respJson);
            }
            return view('manage.system.basemaps.create', compact('maps'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function edit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $maps = Base_Maps::find($id);
            if (!$maps) {
                $respJson->setCode(3);
                $respJson->setMsg("无效数据");
                return response()->json($respJson);
            }
            $input = $request->all;
            $validator = Validator::make($input, $maps->Rules(), $maps->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg("效验失败");
                $respJson->setData($validator);
                return response()->json($respJson);
            }
            $maps->fill($input);
            $maps->id = $id;
            $maps->editId = Base::user('id');
            $maps->editName = Base::user('name');
            $maps->save();


            if ($maps) {
                $respJson->setData($maps);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg("失败");
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    /**
     * 删除
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $respJson = new RespJson();
        try {
            $respJson = new RespJson();
            $id = $request->id;
            $maps = Base_Maps::find($id);
            if ($maps->delete()) {
                $respJson->setMsg("删除成功");
            } else {
                $respJson->setCode(1);
                $respJson->setMsg("删除失败");
            }

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
        }
        return response()->json($respJson);
    }

}
