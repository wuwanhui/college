<?php
/**
 * Created by PhpStorm.
 * User: QF_TY
 * Date: 2016/12/2
 * Time: 17:45
 */

namespace App\Http\Controllers\Manage\Resources;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Res_BigTraffic;
use App\Models\Res_GatherPlace;
use App\Models\Res_Supplier;
use App\Models\Res_Supplier_Bank;
use App\Models\Res_Supplier_Contacts;
use Exception;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\RespJson;
use Illuminate\Support\Facades\Redirect;
//*
//常用大交通管理
//*/
class BigTrafficController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Res_BigTraffic::where(function ($query) use ($request) {
                if ($request->key) {
                    $query->where('departurePlace', 'like', '%' . $request->key . '%')->orWhere('destination', 'like', '%' . $request->key . '%')->orWhere('flightNumer', 'like', '%' . $request->key . '%'); //按名称模糊查询
                }
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }
                if ($request->trend){
                    $query->where('trend',$request->trend);
                }
            })->orderBy('sort', 'asc')->orderBy('id', 'desc')->paginate($this->pageSize);
            //判断需要输出的内容是否为json
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.resources.bigtraffic.index', compact('list'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常：' . $ex->getMessage() . ",行号：" . $ex->getLine());
        }
    }

    /*
     * 新增
     * */
    public function create()
    {
        return view('manage.resources.bigtraffic.create');
    }

    /*
     * 编辑
     * */
    public function edit(Request $request)
    {
        try {
            $item = Res_BigTraffic::find($request->id);
            if (!$item) {
                throw new Exception("数据错误,未找到常用大交通信息！");
            }
            return view('manage.resources.bigtraffic.edit', compact('item'));

        }catch (Exception $ex){
            return Redirect::back()->withInput()->withErrors('异常：' . $ex->getMessage() . ",行号：" . $ex->getLine());
        }
    }

    /**
     * 保存方法
     */
    public function save(Request $request)
    {
        $respJson = new RespJson();
        try {
            $item = new Res_BigTraffic();
            if (!isset($request->id)) {
                //新增保存
                $item->fill($request->all()); //将表单元素内容填充到对象
                $item->createId = Base::user()->id; //赋值当前登录用户ID,登录名称
                $item->createName = Base::user()->name;
            } else {
                //编辑保存
                $item = Res_BigTraffic::find($request->id);
                $item->fill($request->all()); //将表单元素内容填充到对象
            }
            $item->save(); //提交保存
            if ($item) {
                $respJson->setData($item);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg('保存失败！');
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    /**
     *删除
     */
    public function delete(Request $request)
    {
        $respJson = new RespJson();
        try {
            $item = new Res_BigTraffic();
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
}