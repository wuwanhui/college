<?php

namespace App\Http\Controllers\Manage\Crm;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Manage\BaseController;
use App\Jobs\SyllabusChangeJob;
use App\Jobs\SendSyllabusChangeEmail;
use App\Jobs\SendIntegralEmail;
use App\Models\Syllabus;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SyllabusController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/syllabus']);
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
            $list = Syllabus::where(function ($query) use ($request) {
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }

                if (isset($request->key)) {
                    $query->Where('name', 'like', '%' . $request->key . '%');
                }
            })->orderBy('id', 'desc')->paginate($this->pageSize);

            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.syllabus.index', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function getCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $syllabus=new Syllabus();
            return view('manage.syllabus.create', compact('syllabus'));
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
            $syllabus = new Syllabus();
            $inputs = $request->all();
            $validator = Validator::make($inputs, $syllabus->Rules(), $syllabus->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg("效验失败");
                $respJson->setData($validator);
                return response()->json($respJson);
            }
            $syllabus->fill($inputs);
            if ($syllabus->save()) {
                $respJson->setData($syllabus);
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

    public function getEdit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $id = $request->id;
            $syllabus = Syllabus::find($id);
            if (!$syllabus) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }

            return view('manage.syllabus.edit', compact('syllabus'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function postEdit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $id = $request->id;
            $syllabus = Syllabus::find($id);
            if (!$syllabus) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            $syllabus->fill($request->all());
            if ($syllabus->save()) {

//                $job =new SyllabusChangeJob($syllabus);
//                $job->onQueue('emails') ->delay(Carbon::now()->addMinutes(1));
//
//                dispatch($job);
                $respJson->setData($syllabus);
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


    public function getDetail(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $id = $request->id;
            $syllabus = Syllabus::find($id);
            if (!$syllabus) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            if ($request->isMethod('POST')) {

                $syllabus->fill($request->all());
                $syllabus->save();
                if ($syllabus) {
                    $respJson->setData($syllabus);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改失败");
                return response()->json($respJson);
            }
            return view('manage.syllabus.detail', compact('syllabus'));
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
            $count = Syllabus::destroy($ids);

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


    /**
     * API
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Syllabus::where(function ($query) use ($request) {
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
