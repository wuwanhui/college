<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Role;
use App\Models\Teacher;
use Exception;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TeacherController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/teacher']);
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
            $list = Teacher::where(function ($query) use ($request) {

                if ($request->state) {
                    $query->where('state', $request->state);
                }
                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }
            })->orderBy('id', 'desc')->paginate($this->pageSize);
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.teacher.index', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


    public function getCreate(Request $request)
    {
        try {
            $teacher = new Teacher();
            return view('manage.teacher.create', compact('teacher'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常：' . $ex->getMessage() . ",行号：" . $ex->getLine());
        }
    }

    public function postCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $teacher = new Teacher();
            $input = $request->all();

            $validator = Validator::make($input, $teacher->Rules(), $teacher->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg("效验失败");
                $respJson->setData($validator);
                return response()->json($respJson);
            }
            $teacher->fill($input);
            if ($teacher->save()) {
                $respJson->setData($teacher);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg("新增失败");
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
            $teacher = Teacher::find($id);
            if (!$teacher) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            return view('manage.teacher.edit', compact('teacher'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function postEdit(Request $request, $id)
    {
        $respJson = new RespJson();
        try {

            $teacher = Teacher::find($id);
            if (!$teacher) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            $input = $request->all();

            $validator = Validator::make($input, $teacher->Rules(), $teacher->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg("效验失败");
                $respJson->setData($validator);
                return response()->json($respJson);
            }
            $teacher->fill($input);
            if ($teacher->save()) {
                $respJson->setData($teacher);
                return response()->json($respJson);
            }
            $respJson->setMsg("修改失败");

            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function getDetail(Request $request, $id)
    {
        try {
            $teacher = Teacher::find($id);
            if (!$teacher) {
                return redirect('/manage/teacher')->withErrors('数据加载失败！');
            }
            return view('manage.teacher.detail', compact('teacher'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $teacher = Teacher::find($id);
            if (!$teacher) {
                return redirect('/manage/teacher')->withErrors('数据加载失败！');
            }
            $teacher->delete();
            if ($teacher) {
                return redirect('/manage/teacher')->withSuccess('删除成功！');
            }
            return Redirect::back()->withErrors('删除失败！');

        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }


    /**
     * API
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Teacher::where(function ($query) use ($request) {
                if (isset($request->createId)) {
                    $query->where('createId', $request->createId);
                }
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }
            })->orderBy('id', 'desc')->select('id', 'name')->get();

            $respJson->setData($list);
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

}
