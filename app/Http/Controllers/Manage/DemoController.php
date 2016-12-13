<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Facades\Base;
use App\Models\Demo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DemoController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/demo']);
    }

    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $key = $request->key;
        $uid = $request->uid;
        $pid = $request->pid;
        $lists = Demo::where(function ($query) use ($key, $uid, $pid) { 
            if ($uid) {
                $query->where('liable_id', $uid);
            }
            if ($uid) {
                $query->where('parent_id', $pid);
            }
            if ($key) {
                $query->orWhere('name', 'like', '%' . $key . '%');//商品名称
            }
        })->orderBy('id', 'desc')->paginate($this->pageSize);
        if (isset($request->json)) {
            return response()->json($lists);
        }
        return view('manage.demo.index', compact('lists'));
    }


    public function getCreate(Request $request)
    {
        try {
            $demo = new Demo();
            $id = $request->id;
            if (isset($id)) {
                $demo = Demo::find($id);
                if (!$demo) {
                    return Redirect::back()->withErrors('数据加载失败！');
                }
                $demo->name = $demo->name . "-复制";
            }
            $demos = Demo::all();;
            return view('manage.demo.create', compact('demo', 'demos'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常：' . $ex->getMessage() . ",行号：" . $ex->getLine());
        }
    }

    public function postCreate(Request $request)
    {
        try {
            $demo = new Demo();
            $input = $request->all();

            $validator = Validator::make($input, $demo->Rules(), $demo->messages());
            if ($validator->fails()) {
                return redirect('/manage/demo/create')
                    ->withInput()
                    ->withErrors($validator);
            }
            $demo->fill($input);
            $demo->liable_id = Base::user("id");
            $demo->save();
            if ($demo) {
                return redirect('/manage/demo')->withSuccess('保存成功！');
            }
            return Redirect::back()->withErrors('保存失败！');
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function getEdit(Request $request, $id)
    {
        try {
            $demo = Demo::find($id);
            if (!$demo) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            return view('manage.demo.edit', compact('demo'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function postEdit(Request $request, $id)
    {
        try {

            $demo = Demo::find($id);
            if (!$demo) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            $input = $request->all();

            $validator = Validator::make($input, $demo->Rules(), $demo->messages());
            if ($validator->fails()) {
                return redirect('/manage/demo/create')
                    ->withInput()
                    ->withErrors($validator);
            }
            $demo->fill($input);
            $demo->save();
            if ($demo) {
                return redirect('/manage/demo')->withSuccess('保存成功！');
            } else {
                return Redirect::back()->withErrors('保存失败！');
            }
            return view('manage.demo.edit', compact('demo'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function getDetail(Request $request, $id)
    {
        try {
            $demo = Demo::find($id);
            if (!$demo) {
                return redirect('/manage/demo')->withErrors('数据加载失败！');
            }
            return view('manage.demo.detail', compact('demo'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $demo = Demo::find($id);
            if (!$demo) {
                return redirect('/manage/demo')->withErrors('数据加载失败！');
            }
            $demo->delete();
            if ($demo) {
                return redirect('/manage/demo')->withSuccess('删除成功！');
            }
            return Redirect::back()->withErrors('删除失败！');

        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }


}
