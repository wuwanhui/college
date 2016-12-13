<?php

namespace App\Http\Controllers\Manage\Resources;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Res_Line;
use App\Models\Res_Line_Info;
use App\Models\Res_Line_Travel;
use App\Models\Res_LineClass;
use App\Models\Res_Supplier;
use App\Models\Res_Supplier_Contacts;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\RespJson;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


/*
 * 资源商管理-控制器类
 * */

class SupplierController extends BaseController
{

    /**
     * 供应商列表
     */
    public function index(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Res_Supplier::where(function ($query) use ($request) {
                if ($request->key) {
                    $query->where('name', 'like', '%' . $request->key . '%')->orWhere('code', 'like', '%' . $request->key . '%'); //按名称或单位代码模糊查询
                }
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }
                if (count($request->type) > 0) {
                    foreach ($request->type as $value) {
                        $query->orWhere('type', 'like', '%' . $value . '%');
                    }
                }
            })->orderBy('sort', 'asc')->orderBy('id', 'desc')->paginate($this->pageSize);
            //判断需要输出的内容是否为json
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }

            $sup = new Res_Supplier();
            $typelist = $sup->type_list;

            return view('manage.resources.supplier.index', compact('list', 'typelist'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    /**
     * 新增供应商页面
     */
    public function create()
    {
        $supplier = new Res_Supplier();
        return view('manage.resources.supplier.create', compact('supplier'));
    }

    /**
     * 编辑供应商
     */
    public function edit(Request $request)
    {
        try {
            $id = $request->id;
            $supplier = Res_Supplier::find($id);
            if (!$supplier) {
                throw new Exception("数据错误，未找到信息！");
            }
            return view('manage.resources.supplier.edit', compact('supplier'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常：' . $ex->getMessage() . ",行号：" . $ex->getLine());
        }
    }

    /**
     * 保存资源商基本信息
     */
    public function saveSupplier(Request $request)
    {
        $respJson = new RespJson();
        try {
            $item = new Res_Supplier();
            if (!isset($request->id)) {
                //新增保存
                $item->fill($request->all()); //将表单元素内容填充到对象
                $item->createId = Base::user()->id; //赋值当前登录用户ID,登录名称
                $item->createName = Base::user()->name;
                $typeArray = $request->type;
                $item->type = implode(',', $typeArray);
            } else {
                //编辑保存
                $item = Res_Supplier::find($request->id);
                $item->fill($request->all()); //将表单元素内容填充到对象
                $typeArray = $request->type;
                $item->type = implode(',', $typeArray);
            }
            $item->save(); //提交保存
            if ($item) {
                $respJson->setData($item);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg('供应商保存失败！');
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            Log::info(json_encode($ex->getMessage()));
            return response()->json($respJson);
        }
    }


    /**
     * 保存资源商的更多联系人
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
     * 保存供应商的银行信息
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
     *删除线路
     */
    public function delete(Request $request)
    {
        $respJson = new RespJson();
        try {
            $item = new Res_Supplier();
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
        return view('manage.resources.supplier.detail');
    }
    

}
