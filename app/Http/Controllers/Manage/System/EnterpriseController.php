<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Enterprise;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EnterpriseController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/enterprise']);
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
            $enterprise = Enterprise::first();
            if (!$enterprise) {
                return "数据加载失败";
            }
            if ($request->isMethod('POST')) {
                $input = $request->all();
                $validator = Validator::make($input, $enterprise->Rules(), $enterprise->messages());
                if ($validator->fails()) {
                    echo "效验失败";
                    $respJson->setCode(2);
                    $respJson->setMsg("效验失败");
                    $respJson->setData($validator);
                    return response()->json($respJson);
                }
                $enterprise->fill($input);
                $enterprise->editId = Base::user('id');
                $enterprise->editName = Base::user('name');
                $enterprise->save();


                if ($enterprise) {
                    $respJson->setData($enterprise);
                    return response()->json($respJson);
                }
                $respJson->setCode(1);
                $respJson->setMsg("失败");
                return response()->json($respJson);
            }
            if (isset($request->json)) {
                $respJson->setData($enterprise);
                return response()->json($respJson);
            }
            return view('manage.system.enterprise.index', compact('enterprise'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


    public function getCreate(Request $request)
    {
        try {
            $enterprise = new Enterprise();
            $id = $request->id;
            if (isset($id)) {
                $enterprise = Enterprise::find($id);
                if (!$enterprise) {
                    return Redirect::back()->withErrors('数据加载失败！');
                }
                $enterprise->name = $enterprise->name . "-复制";
            }
            $enterprises = Enterprise::all();;
            return view('manage.system.enterprise.create', compact('enterprise', 'enterprises'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常：' . $ex->getMessage() . ",行号：" . $ex->getLine());
        }
    }

    public function postCreate(Request $request)
    {
        try {
            $enterprise = new Enterprise();
            $input = $request->all();

            $validator = Validator::make($input, $enterprise->Rules(), $enterprise->messages());
            if ($validator->fails()) {
                return redirect('/manage/enterprise/create')
                    ->withInput()
                    ->withErrors($validator);
            }
            $enterprise->fill($input);
            $enterprise->liable_id = Base::user("id");
            $enterprise->save();
            if ($enterprise) {
                return redirect('/manage/enterprise')->withSuccess('保存成功！');
            }
            return Redirect::back()->withErrors('保存失败！');
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function getEdit(Request $request, $id)
    {
        try {
            $enterprise = Enterprise::find($id);
            if (!$enterprise) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            return view('manage.system.enterprise.edit', compact('enterprise'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function postEdit(Request $request, $id)
    {
        try {

            $enterprise = Enterprise::find($id);
            if (!$enterprise) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            $input = $request->all();

            $validator = Validator::make($input, $enterprise->Rules(), $enterprise->messages());
            if ($validator->fails()) {
                return redirect('/manage/enterprise/create')
                    ->withInput()
                    ->withErrors($validator);
            }
            $enterprise->fill($input);
            $enterprise->save();
            if ($enterprise) {
                return redirect('/manage/enterprise')->withSuccess('保存成功！');
            } else {
                return Redirect::back()->withErrors('保存失败！');
            }
            return view('manage.system.enterprise.edit', compact('enterprise'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function getDetail(Request $request, $id)
    {
        try {
            $enterprise = Enterprise::find($id);
            if (!$enterprise) {
                return redirect('/manage/enterprise')->withErrors('数据加载失败！');
            }
            return view('manage.system.enterprise.detail', compact('enterprise'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $enterprise = Enterprise::find($id);
            if (!$enterprise) {
                return redirect('/manage/enterprise')->withErrors('数据加载失败！');
            }
            $enterprise->delete();
            if ($enterprise) {
                return redirect('/manage/enterprise')->withSuccess('删除成功！');
            }
            return Redirect::back()->withErrors('删除失败！');

        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }


}
