<?php

namespace App\Http\Controllers\Manage\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Res_BigTraffic;
use App\Models\Res_Line;
use App\Models\Res_Line_Info;
use App\Models\Res_Line_Travel;
use App\Models\Res_LineClass;
use App\Models\Td_TourGroup;
use App\Models\Td_TourLine;
use App\Models\Td_TourLine_Info;
use App\Models\Td_TourLine_Travel;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\RespJson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Array_;


/*
 * 团期管理-控制器类
 * */

class TourGroupController extends BaseController
{

    /**
     * 团期列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Td_TourGroup::where(function ($query) use ($request) {
                if($request->tid){
                    //是否传了线路ID
                    $query->where('tourline_id',$request->tid);
                }
                if ($request->key) {
                    $query->Where('name', 'like', '%' . $request->key . '%')->orWhere('number', 'like', '%' . $request->key . '%'); //按名称或团号查询
                }
                if (isset($request->state)&&$request->state!=-1) {
                    $query->where('state', $request->state);
                }
            })->with(['tourline','tourline.lineclass'])->orderBy('sort', 'asc')->orderBy('id', 'desc')->paginate($this->pageSize);
            //判断需要输出的内容是否为json
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.business.group.index', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }
    /**
     * 团期线路列表
     */
    public function tourline(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Td_TourLine::where(function ($query) use ($request) {
                if ($request->key) {
                    $query->Where('name', 'like', '%' . $request->key . '%'); //按名称查询
                }
                if (isset($request->state)&&$request->state!=-1) {
                    $query->where('state', $request->state);
                }
            })->with(['lineclass','groups'=>function($query){
                $query->select('id','tourline_id','departureDate');
            }])->orderBy('sort', 'asc')->orderBy('id', 'desc')->paginate($this->pageSize);

            //判断需要输出的内容是否为json
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.business.group.tourline', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    /**
     * 新增散拼团期计划
     */
    public function createSan(){
        return view('manage.business.group.createsan');
    }
    /**
     * 新增独立成团
     */
    public function createDan(){
        return view('manage.business.group.craetedan');
    }

    /**
     * 选择线路列表
     * @return \Illuminate\Http\Response
     */
    public function chooseLine(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Res_Line::where(function ($query) use ($request) {
                $query->where('state', 0);
                if ($request->key) {
                    $query->Where('name', 'like', '%' . $request->key . '%')->orWhere('code', 'like', '%' . $request->key . '%'); //按名称或标签模糊查询
                }
            })->with(['lineclass' => function ($query) {
                $query->select('id', 'name');
            },'travels','otherinfo'])->orderBy('sort', 'asc')->orderBy('id', 'desc')->paginate($this->pageSize);
            //判断需要输出的内容是否为json
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.business.group.chooseline', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    /**
     * 选择大交通列表
     * @return \Illuminate\Http\Response
     */
    public function chooseTraffic(Request $request)
    {
        return view('manage.business.group.choosetraffic');
    }
    /**
     * 选择常用集合地
     * @return \Illuminate\Http\Response
     */
    public function chooseGatherPlace(Request $request)
    {
        return view('manage.business.group.choosegatherplace');
    }


    /**
     * 保存团期线路信息
     */
    public function saveLine(Request $request)
    {
        $respJson = new RespJson();
        try {
            DB::beginTransaction();
            $item = new Td_TourLine();
            if ($request->id==0) {
                //新增保存
                $item->fill($request->all()); //将表单元素内容填充到对象
                $item->createId = Base::user()->id; //赋值当前登录用户ID,登录名称
                $item->createName = Base::user()->name;

                //判断录入行程方式是按天录入还是按文档录入
                $otherinfo=$request->otherinfo; //线路备注说明

                if ($request->lrfs == 0) {
                    $travels = $request->travels; //线路行程
                    $item->save(); //提交保存
                    $item->travels()->createMany($travels); //保存行程子表
                    $item->otherinfo()->createMany($otherinfo); //保存其他信息
                } else {
                    $item->xcontent = $request->xcontent;
                    $item->save(); //提交保存
                    $item->otherinfo()->createMany($otherinfo); //保存其他信息
                }
            }
            else{
                //编辑保存
                $item= Td_TourLine::find($request->id);
                $item->fill($request->all()); //将表单元素内容填充到对象
            }
            DB::commit();

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
            DB::rollback();
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
            $formItem = Td_TourLine::find($lineid);

            DB::beginTransaction();
            //判断录入行程方式是按天录入还是按文档录入
            if ($request->lrfs == 0) {
                $travels = $request->travels;
                Td_TourLine_Travel::where('tourline_id', $lineid)->forceDelete();
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
            $respJson->setMsg('保存失败！');
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
            $formItem = Td_TourLine::find($lineid); //查询线路信息
            $otherinfo = $request->otherinfo;

            Td_TourLine_Info::where('tourline_id', $lineid)->forceDelete();
            $formItem->ohterinfo()->createMany($otherinfo); //保存线路其他信息表

            if ($formItem) {
                $respJson->setData($formItem);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg('保存失败！');
            return response()->json($respJson);

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            Log::info(json_encode($ex->getMessage()));
            return response()->json($respJson);
        }
    }

    /**
     * 发布团期保存方法
     */
    public function saveGroup(Request $request)
    {
        $respJson = new RespJson();
        try {
            if (!isset($request->id)) {
                //新增保存
                $dateArray=array();
                if ($request->tqxz==1){
                    //指定日期
                    $dateArray = explode(',', $request->zddate);
                }else{

                    //区间日期
                    $beginDate=strtotime($request->begindate);
                    $endDate=strtotime($request->enddate);
                    $weeks=$request->weeks; //选择周几集合过滤

                    //选择区间日期
                    while ($beginDate<=$endDate){

                        $week=date('w',$beginDate); //出团日期为星期几

                        if(count($weeks)>0 && !in_array($week,$weeks)){
                            $beginDate = strtotime('+1 day',$beginDate);
                            continue;
                        }
                        $dateArray[]=date('Y-m-d',$beginDate);
                        $beginDate = strtotime('+1 day',$beginDate);
                    }

                }
                DB::beginTransaction();
                $days=$request->days; //行程天数
                $name=$request->name; //团期名称
                //循环保存团期
                foreach ($dateArray as $godate) {
                    $newItem=new Td_TourGroup();
                    $newItem->fill($request->all()); //将表单元素内容填充到对象
                    $newItem->createId = Base::user()->id; //赋值当前登录用户ID,登录名称
                    $newItem->createName = Base::user()->name;
                    $newItem->operator = Base::user()->id;  //指定计调
                    $newItem->seller = Base::user()->id; //指定销售
                    $newItem->name=$name;
                    $newItem->type=1; //1为散拼
                    $backdate=date('Y-m-d',strtotime('+'.$days.' day',strtotime($godate))); //date('Y-m-d',strtotime('$godate +5 day')); //回团日期
                    $newItem->number=$this->getNumber($request->thqz); //生成团号
                    $newItem->departureDate=$godate;
                    $newItem->backDate=$backdate;

                    $newItem->save(); //提交保存
                    $newItem->traffics()->createMany($request->traffic); //保存团期大交通
                    $newItem->prices()->createMany($request->prices); //保存团期价格类型
                }
                DB::commit();
            }

            return response()->json($respJson);

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            DB::rollback();
            return response()->json($respJson);
        }
    }

    /*
     * 生成编号的方法
     * */
    public function getNumber($qz)
    {
        $num=substr(date('ymdHis'),2,8).mt_rand(100000,999999);
        return $qz.$num;
    }

//
//    /**
//     * 编辑线路
//     */
//    public function edit(Request $request)
//    {
//        $respJson = new RespJson();
//        try {
//            $id = $request->id;
//            $line = Res_Line::find($id);
//            if (!$line) {
//                throw new Exception("数据错误，未找到线路信息！");
//            }
//            return view('manage.resources.line.edit', compact('line'));
//        } catch (Exception $ex) {
//            $respJson->setCode(-1);
//            $respJson->setMsg('异常！' . $ex->getMessage());
//            return response()->json($respJson);
//        }
//    }
//
//    /**
//     *删除线路
//     */
//    public function delete(Request $request)
//    {
//        $respJson = new RespJson();
//        try {
//            $item = new Res_Line();
//            $ret = $item->destroy($request->ids);
//            if ($ret > 0) {
//                $respJson->setMsg("成功删除.$ret.条记录！");
//            } else {
//                $respJson->setCode(1);
//                $respJson->setMsg("未删除任何记录！");
//            }
//            return response()->json($respJson);
//
//        } catch (Exception $ex) {
//            $respJson->setCode(-1);
//            $respJson->setMsg('异常！' . $ex->getMessage());
//            return response()->json($respJson);
//        }
//    }


}
