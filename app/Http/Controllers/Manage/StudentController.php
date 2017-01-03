<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Classes;
use App\Models\Role;
use App\Models\Student;
use Exception;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class StudentController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/student']);
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
            $list = Student::where(function ($query) use ($request) {

                if ($request->state) {
                    $query->where('state', $request->state);
                }
                if ($request->classes) {
                    $query->where('classes_id', $request->classes);
                }
                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }
            })->with(['classes' => function ($query) {
                $query->select('id', 'name');
            }])->orderBy('id', 'asc')->paginate($this->pageSize);
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            $classes = Classes::where('state', 0)->get();
            return view('manage.student.index', compact('list', 'classes'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function getCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $student = new Student();
            $classes = Classes::where('state', 0)->get();
            return view('manage.student.create', compact('student', 'classes'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function postCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $student = new Student();
            $input = $request->all();

            $validator = Validator::make($input, $student->Rules(), $student->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg("效验失败");
                $respJson->setData($validator);
                return response()->json($respJson);
            }
            $student->fill($input);
            $student->password = bcrypt($request->password);
            if ($student->save()) {
                $respJson->setData($student);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg("新增失败");
            return response()->json($respJson);
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function getEdit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $student = Student::find($id);
            if (!$student) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            $classes = Classes::where('state', 0)->get();
            return view('manage.student.edit', compact('student', 'classes'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function postEdit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $student = Student::find($id);
            if (!$student) {
                return $respJson->errors('数据加载失败！');
            }
            $input = $request->all();

            $validator = Validator::make($input, $student->Rules(), $student->messages());
            if ($validator->fails()) {
                return $respJson->validator('效验失败！', $validator);
            }
            $student->fill($input);
            if (isset($request->password)) {
                $student->password = bcrypt($request->password);
            }
            if ($student->save()) {
                return $respJson->succeed('修改成功！', $student);
            }
            return $respJson->errors('修改失败！');
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function getDetail(Request $request, $id)
    {
        $respJson = new RespJson();
        try {
            $student = Student::find($id);
            if (!$student) {
                return redirect('/manage/student')->withErrors('数据加载失败！');
            }
            return view('manage.student.detail', compact('student'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function delete(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id=$request->id;
            $student = Student::find($id);
            if (!$student) {
                return redirect('/manage/student')->withErrors('数据加载失败！');
            }
            if ($student->delete()) {
                return $respJson->succeed('删除成功！',1);
            }
            return $respJson->failure('删除失败！');

        } catch (Exception $ex) {
            return $respJson->exception($ex);
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
            $list = Student::where(function ($query) use ($request) {

                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }
            })->orderBy('id', 'ase')->select('id', 'name')->get();

            $respJson->setData($list);
            return response()->json($respJson);
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }
}
