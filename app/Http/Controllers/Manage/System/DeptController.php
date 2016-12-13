<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Manage\BaseController;
use App\Models\Dept;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DeptController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/dept']);
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

            $lists = Dept::where(function ($query) use ($request) {

                if ($request->pid) {
                    $query->where('parent_id', $request->pid);
                }
                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }
                // $query->where('children_count', '>', 0);
            })->with(['parent' => function ($query) {
                $query->select('id', 'name');
            }])->withCount(['children' => function ($query) {
//                $query->where(this, '>', 0);
            }])->orderBy('sort', 'desc')->orderBy('id', 'desc')->get();
//            if (isset($request->page)) {
//                $lists = $lists->paginate($this->pageSize);
//            } else {
//                $lists = $lists->get();
//            }
            if (isset($request->json)) {
                $respJson->setData($lists);
                return response()->json($respJson);
            }
            return view('manage.system.dept.index', compact('lists'));
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
            $dept = new Dept();
            if ($request->isMethod('POST')) {
                $respJson = new RespJson();
                $inputs = $request->all();
                $dept->fill($inputs);
                $dept->save();
                if ($dept) {
                    $respJson->setData($dept);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改失败");
                return response()->json($respJson);
            }
            return view('manage.system.dept.create', compact('dept'));
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
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $id = $request->id;
            $dept = Dept::find($id);
            if (!$dept) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            if ($request->isMethod('POST')) {

                $dept->fill($request->all());
                $dept->save();
                if ($dept) {
                    $respJson->setData($dept);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改失败");
                return response()->json($respJson);
            }
            return view('manage.system.dept.edit', compact('dept'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function delete(Request $request)
    {
        $respJson = new RespJson();
        try {
            $ids = $request->ids;
            if (!$ids) {
                $respJson->setCode(2);
                $respJson->setMsg('参数错误');
                return response()->json($respJson);
            }
            $count = Dept::destroy(1);

            if ($count > 0) {
                $respJson->setMsg('删除成功');
                $respJson->setData($count);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg('删除失败');
            return response()->json($respJson);

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


}
