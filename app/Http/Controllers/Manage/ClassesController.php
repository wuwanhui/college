<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Role;
use App\Models\Classes;
use Exception;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ClassesController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/classes']);
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
            $list = Classes::where(function ($query) use ($request) {

                if ($request->state) {
                    $query->where('state', $request->state);
                }
                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }
            })->withCount('students')->orderBy('id', 'asc')->paginate($this->pageSize);
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.classes.index', compact('list'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function getCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $classes = new Classes();
            return view('manage.classes.create', compact('classes'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function postCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $classes = new Classes();
            $input = $request->all();

            $validator = Validator::make($input, $classes->Rules(), $classes->messages());
            if ($validator->fails()) {
                return $respJson->validator('效验失败', $validator);
            }
            $classes->fill($input);
            if ($classes->save()) {
                return $respJson->succeed('新增成功', $classes);
            }
            return $respJson->failure('新增失败');
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function getEdit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $classes = Classes::find($id);
            if (!$classes) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            return view('manage.classes.edit', compact('classes'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function postEdit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $classes = Classes::find($id);
            if (!$classes) {
                return $respJson->errors('数据加载失败！');
            }
            $input = $request->all();

            $validator = Validator::make($input, $classes->Rules(), $classes->messages());
            if ($validator->fails()) {
                return $respJson->validator('效验失败！', $validator);
            }
            $classes->fill($input);
            if ($classes->save()) {
                return $respJson->succeed('修改成功！', $classes);
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
            $classes = Classes::find($id);
            if (!$classes) {
                return redirect('/manage/classes')->withErrors('数据加载失败！');
            }
            return view('manage.classes.detail', compact('classes'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function delete(Request $request, $id)
    {
        $respJson = new RespJson();
        try {
            $classes = Classes::find($id);
            if (!$classes) {
                return redirect('/manage/classes')->withErrors('数据加载失败！');
            }
            $classes->delete();
            if ($classes) {
                return redirect('/manage/classes')->withSuccess('删除成功！');
            }
            return Redirect::back()->withErrors('删除失败！');

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
            $list = Classes::where(function ($query) use ($request) {

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
