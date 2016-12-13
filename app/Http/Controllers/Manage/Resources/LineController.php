<?php

namespace App\Http\Controllers\Manage\Resources;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Res_Line;
use App\Models\Res_Line_Info;
use App\Models\Res_Line_Travel;
use App\Models\Res_LineClass;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\RespJson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


/*
 * 线路管理-控制器类
 * */

class LineController extends BaseController
{

    /**
     * 线路列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Res_Line::where(function ($query) use ($request) {
                if ($request->key) {
                    $query->Where('name', 'like', '%' . $request->key . '%')->orWhere('code', 'like', '%' . $request->key . '%'); //按名称或标签模糊查询
                }
                if (isset($request->state)&&$request->state!=-1) {
                    $query->where('state', $request->state);
                }
            })->with(['lineclass' => function ($query) {
                $query->select('id', 'name');
            }])->orderBy('sort', 'asc')->orderBy('id', 'desc')->paginate($this->pageSize);
            //判断需要输出的内容是否为json
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.resources.line.index', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    /**
     * 新增线路页面
     */
    public function create(){
        return view('manage.resources.line.create');
    }


    /**
     * 保存线路基本信息
     */
    public function saveLine(Request $request)
    {
        $respJson = new RespJson();
        try {
            $item = new Res_Line();
            if (!isset($request->id)) {
                //新增保存
                $item->fill($request->all()); //将表单元素内容填充到对象
                $item->createId = Base::user()->id; //赋值当前登录用户ID,登录名称
                $item->createName = Base::user()->name;
            }
            else{
                //编辑保存
                $item= Res_Line::find($request->id);
                $item->lineclass_id=$request->lineclass_id;
                $item->name=$request->name;
                $item->code=$request->code;
                $item->pic=$request->pic;
                $item->special=$request->special;
                $item->brieflyDesc=$request->brieflyDesc;
            }
            $item->save(); //提交保存
            if ($item) {
                $respJson->setData($item);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg('线路保存失败！');
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            Log::info(json_encode($ex->getMessage()));
            return response()->json($respJson);
        }
    }


    /**
     * 保存线路行程
     */
    public function saveTravel(Request $request)
    {
        $respJson = new RespJson();
        try {
            $lineid = $request->lineid;
            $formItem = Res_Line::find($lineid);
            $formItem->days = $request->days;
            $formItem->lrfs = $request->lrfs;

            DB::beginTransaction();
            //判断录入行程方式是按天录入还是按文档录入
            if ($request->lrfs == 0) {
                $travels = $request->travels;
                Res_Line_Travel::where('line_id', $lineid)->forceDelete();
                $formItem->travels()->createMany($travels); //保存行程子表
            } else {
                $formItem->xcontent = $request->xcontent;
            }
            $formItem->save(); //提交保存
            DB::commit();

            if ($formItem) {
                $respJson->setData($formItem);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg('线路行程保存失败！');
            return response()->json($respJson);

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            Log::info(json_encode($ex->getMessage()));
            return response()->json($respJson);
        }
    }
    /**
     * 保存线路其他信息
     */
    public function saveOtherInfo(Request $request)
    {
        $respJson = new RespJson();
        try {
            $lineid = $request->lineid;
            $formItem = Res_Line::find($lineid); //查询线路信息
            $otherinfo = $request->otherinfo;

            Res_Line_Info::where('line_id', $lineid)->forceDelete();
            $formItem->ohterinfo()->createMany($otherinfo); //保存线路其他信息表

            if ($formItem) {
                $respJson->setData($formItem);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg('线路其他信息保存失败！');
            return response()->json($respJson);

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            Log::info(json_encode($ex->getMessage()));
            return response()->json($respJson);
        }
    }

    /**
     * 编辑线路
     */
    public function edit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $line = Res_Line::find($id);
            if (!$line) {
                throw new Exception("数据错误，未找到线路信息！");
            }
            return view('manage.resources.line.edit', compact('line'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    /**
     *删除线路
     */
    public function delete(Request $request)
    {
        $respJson = new RespJson();
        try {
            $item = new Res_Line();
            $ret = $item->destroy($request->ids);
            if ($ret > 0) {
                $respJson->setMsg("成功删除.$ret.条记录！");
            } else {
                $respJson->setCode(1);
                $respJson->setMsg("未删除任何记录！");
            }
            return response()->json($respJson);

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function detail()
    {
        return view('manage.resources.lineclass.detail');
    }
}
