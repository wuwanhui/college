<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Manage\BaseController;
use App\Jobs\TermChangeJob;
use App\Jobs\SendTermChangeEmail;
use App\Jobs\SendIntegralEmail;
use App\Models\Agenda;
use App\Models\Student;
use App\Models\Term;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TermController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/term']);
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
            $list = Term::where(function ($query) use ($request) {
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }

                if (isset($request->key)) {
                    $query->Where('name', 'like', '%' . $request->key . '%');
                }
            })->with(['agendas'=>function($query){
               // $query->select('agenda_id');
            },'students'])->orderBy('id', 'desc')->paginate($this->pageSize);

            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.term.index', compact('list'));
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
            $term = new Term();
            return view('manage.term.create', compact('term'));
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
            $term = new Term();
            $inputs = $request->all();
            $validator = Validator::make($inputs, $term->Rules(), $term->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg("效验失败");
                $respJson->setData($validator);
                return response()->json($respJson);
            }
            $term->fill($inputs);
            if ($term->save()) {
                $respJson->setData($term);
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
            $term = Term::find($id);
            if (!$term) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }

            return view('manage.term.edit', compact('term'));
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
            $term = Term::find($id);
            if (!$term) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            $term->fill($request->all());
            if ($term->save()) {

//                $job =new TermChangeJob($term);
//                $job->onQueue('emails') ->delay(Carbon::now()->addMinutes(1));
//
//                dispatch($job);
                $respJson->setData($term);
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
            $term = Term::find($id);
            if (!$term) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            if ($request->isMethod('POST')) {

                $term->fill($request->all());
                $term->save();
                if ($term) {
                    $respJson->setData($term);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改失败");
                return response()->json($respJson);
            }
            return view('manage.term.detail', compact('term'));
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
            $count = Term::destroy($ids);

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
            $list = Term::where(function ($query) use ($request) {
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


    public function getBindAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Agenda::where(function ($query) use ($request) {

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

            return view('manage.term.bindAgenda', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function postBindAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }

            $ids = $request->ids;
            if (!$ids) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $id = $request->id;
            $term = Term::find($id);
            if (!$term) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }

            if ($term->agendas()->sync($ids)) {
                $respJson->setData($term);
                return response()->json($respJson);
            }

            $respJson->setMsg("绑定失败");
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


    public function getBindStudent(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Student::where(function ($query) use ($request) {

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

            return view('manage.term.bindStudent', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function postBindStudent(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }

            $ids = $request->ids;
            if (!$ids) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $id = $request->id;
            $term = Term::find($id);
            if (!$term) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }

            if ($term->students()->sync($ids)) {
                $respJson->setData($term);
                return response()->json($respJson);
            }

            $respJson->setMsg("绑定失败");
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }
}
