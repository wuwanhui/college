<?php

namespace App\Http\Controllers\Manage\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Pro_Cost;
use App\Models\Pro_Cost_Car;
use App\Models\Pro_Cost_Hotel;
use App\Models\Pro_Cost_Meals;
use App\Models\Pro_Cost_Plane;
use App\Models\Pro_Cost_Price;
use App\Models\Pro_Cost_Ticket;
use App\Models\Pro_Cost_Train;
use App\Models\Pro_Cost_Visa;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\RespJson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


/*
 * 成本管理-控制器类
 * */

class CostController extends BaseController
{

    /**
     * 线路列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Pro_Cost::where(function ($query) use ($request) {
//                if ($request->key) {
//                    $query->Where('name', 'like', '%' . $request->key . '%')->orWhere('tag', 'like', '%' . $request->key . '%'); //按名称或标签模糊查询
//                }
//                if ($request->state) {
//                    $query->where('state', $request->state);
//                }
            })->orderBy('id', 'asc')->paginate($this->pageSize);
            $pro=array('id'=>1,'name'=>'胡明海体验十日游');
            //判断需要输出的内容是否为json
            $res=array('list'=>$list,'pro'=>$pro);
            if (isset($request->json)) {
                $respJson->setData($res);
                return response()->json($respJson);
            }

            return view('manage.business.cost.index', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    /**
     * 新增成本
     * @param
     * @return
     */
    public function create(Request $request)
    {
        $respJson = new RespJson();
        try {
            if ($request->isMethod('POST')) {
                $respJson->setData(123);
                return response()->json($respJson);
//                $item = new Pro_Cost();
               // $item->fill($request->all()); //将表单元素内容填充到对象
//                $item->createId = Base::user()->id; //赋值当前登录用户ID,登录名称
//                $item->createName = Base::user()->name;


                ////                $subcost = $request->subCost; // $item->travels;
////                $pricelist = $request->pricelist;
//
//                $item->save(); //提交保存
////                $item->pricelist()->createMany($pricelist); //保存价格
////                if($item['costType']==1){
////                    $item->visaitem()->create($subcost); //保存签证
////                }elseif($item['costType']==2){
////                    $item->planeitem()->create($subcost); //保存机票
////                }elseif($item['costType']==5){
////                    $item->trainitem()->create($subcost); //保存火车票
////                }elseif($item['costType']==6){
////                    $item->mealsitem()->create($subcost); //保存餐费
////                }elseif($item['costType']==7){
////                    $item->caritem()->create($subcost); //保存车费
////                }elseif($item['costType']==8){
////                    $item->hotelitem()->create($subcost); //保存酒店
////                }elseif($item['costType']==9){
////                    $item->ticketitem()->create($subcost); //保存订票
////                }
//
//                if ($item) {
//                    $respJson->setData($item);
//                    return response()->json($respJson);
//                }
//
//                $respJson->setCode(1);
//                $respJson->setMsg('成本保存失败！');
//                return response()->json($respJson);
            }
            $lx = $request->lx;
            $pid=$request->pid;
            $parm=array('lx'=>$lx,'pid'=>$pid);
            return view('manage.business.cost.create',compact('parm'));
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
            $item = Res_LineClass::find($id);
            if (!$item) {
                throw new Exception("数据错误，未找到线路分类！");
            }
            if ($request->isMethod('POST')) {
                $inputs = $request->all();
                $item->fill($inputs);
                $item->save();
                if ($item) {
                    $respJson->setData($item);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改线路分类失败！");
                return response()->json($respJson);
            }
            return view('manage.resources.lineclass.edit', compact('item'));
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
            $item = new Res_LineClass();
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
