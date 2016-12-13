<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Base_Data;
use App\Models\Base_Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BaseDataController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/basedata']);
    }

    /**
     * 基础数据列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $respJson = new RespJson();
        try {
            $key = $request->key;
            $uid = $request->uid;
            $pid = $request->pid;
            $list = Base_Data::where(function ($query) use ($request) {
                if ($request->pid) {
                    $query->where('baseType_id', $request->pid);
                }

                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }
            })->orderBy('id', 'desc')->paginate($this->pageSize);

            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            $type = Base_Type::all();

            return view('manage.system.basedata.index', compact('list', 'type'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


    /**
     * 基础数据分类列表
     *
     * @return \Illuminate\Http\Response
     */
    public function type(Request $request)
    {
        $respJson = new RespJson();
        try {

            if ($request->isMethod('POST')) {
                $baseType = new Base_Type();
                $input = $request->all();

                $validator = Validator::make($input, $baseType->Rules(), $baseType->messages());
                if ($validator->fails()) {
                    $respJson->setCode(2);
                    $respJson->setMsg('效验失败！');
                    return response()->json($respJson);
                }
                $baseType->fill($input);
//                $baseType->createId = Base::user('id');
//                $baseType->createName = Base::user('name');
                $baseType->save();
                if ($baseType) {
                    $respJson->setData($baseType);
                    return response()->json($respJson);
                }
                $respJson->setCode(1);
                $respJson->setMsg('保存失败！');
                return response()->json($respJson);
            }

            $key = $request->key;
            $list = Base_Type::where(function ($query) use ($key) {

                if ($key) {
                    $query->orWhere('name', 'like', '%' . $key . '%');
                }
            })->orderBy('id', 'desc')->paginate($this->pageSize);
            $respJson->setData($list);
            return response()->json($respJson);
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
            $baseData = new Base_Data();
            $input = $request->all();

            $validator = Validator::make($input, $baseData->Rules(), $baseData->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg('效验失败！');
                return response()->json($respJson);
            }
            $baseData->fill($input);
            $baseData->createId = Base::user('id');
            $baseData->createName = Base::user('name');
            $baseData->save();
            if ($baseData) {
                $respJson->setData($baseData);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg('保存失败！');
            return response()->json($respJson);

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function getEdit(Request $request, $id)
    {
        try {
            $basedata = Base_Data::find($id);
            if (!$basedata) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            return view('manage.system.basedata.edit', compact('basedata'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function postEdit(Request $request, $id)
    {
        try {

            $basedata = Base_Data::find($id);
            if (!$basedata) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            $input = $request->all();

            $validator = Validator::make($input, $basedata->Rules(), $basedata->messages());
            if ($validator->fails()) {
                return redirect('/manage/basedata/create')
                    ->withInput()
                    ->withErrors($validator);
            }
            $basedata->fill($input);
            $basedata->save();
            if ($basedata) {
                return redirect('/manage/basedata')->withSuccess('保存成功！');
            } else {
                return Redirect::back()->withErrors('保存失败！');
            }
            return view('manage.system.basedata.edit', compact('basedata'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function getDetail(Request $request, $id)
    {
        try {
            $basedata = Base_Data::find($id);
            if (!$basedata) {
                return redirect('/manage/basedata')->withErrors('数据加载失败！');
            }
            return view('manage.system.basedata.detail', compact('basedata'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $basedata = Base_Data::find($id);
            if (!$basedata) {
                return redirect('/manage/basedata')->withErrors('数据加载失败！');
            }
            $basedata->delete();
            if ($basedata) {
                return redirect('/manage/basedata')->withSuccess('删除成功！');
            }
            return Redirect::back()->withErrors('删除失败！');

        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }


}
