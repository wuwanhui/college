<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Manage\BaseController;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PermissionController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/permission']);
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
            $key = $request->key;
            $pid = $request->pid;
            $list = Permission::where(function ($query) use ($key, $pid) {

                if ($pid) {
                    $query->where('parent_name', $pid);
                } else {
                    $query->where('parent_name', 0);
                }
                if ($key) {
                    $query->orWhere('name', 'like', '%' . $key . '%');//商品名称
                }
            })->with(['parent' => function ($query) {
                $query->select('id', 'name', 'display_name');
            }])->with(['children'])->orderBy('id', 'asc');
            if ($pid) {
                $list = $list->paginate($this->pageSize);
            } else {
                $list = $list->get();
            }

            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.system.permission.index', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    protected function getTree($data, $pid = 0)
    {


    }

    public function getCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $permission = new Permission();
            return view('manage.system.permission.create', compact('permission'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function postCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $permission = new Permission();
            $input = $request->all();

            $validator = Validator::make($input, $permission->Rules(), $permission->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg('效验失败！' . json_encode($validator));
                return response()->json($respJson);
            }
            $permission->fill($input);
            if ($permission->save()) {
                $respJson->setData($permission);
                $respJson->setMsg('保存成功！');
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
            $permission = Permission::find($id);
            if (!$permission) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            return view('manage.system.permission.edit', compact('permission'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function postEdit(Request $request, $id)
    {
        try {

            $permission = Permission::find($id);
            if (!$permission) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            $input = $request->all();

            $validator = Validator::make($input, $permission->Rules(), $permission->messages());
            if ($validator->fails()) {
                return redirect('/manage/permission/create')
                    ->withInput()
                    ->withErrors($validator);
            }
            $permission->fill($input);
            $permission->save();
            if ($permission) {
                return redirect('/manage/permission')->withSuccess('保存成功！');
            } else {
                return Redirect::back()->withErrors('保存失败！');
            }
            return view('manage.system.permission.edit', compact('permission'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function getDetail(Request $request, $id)
    {
        try {
            $permission = Permission::find($id);
            if (!$permission) {
                return redirect('/manage/permission')->withErrors('数据加载失败！');
            }
            return view('manage.system.permission.detail', compact('permission'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $permission = Permission::find($id);
            if (!$permission) {
                return redirect('/manage/permission')->withErrors('数据加载失败！');
            }
            $permission->delete();
            if ($permission) {
                return redirect('/manage/permission')->withSuccess('删除成功！');
            }
            return Redirect::back()->withErrors('删除失败！');

        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }


}
