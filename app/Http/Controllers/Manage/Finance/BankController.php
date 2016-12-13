<?php

namespace App\Http\Controllers\Manage\Finance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Finance_BankList;
use App\Models\Res_LineClass;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\RespJson;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


/*
 * 财务管理-控制器类
 * */

class BankController extends BaseController
{

    /**
     * 银行账号列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Finance_BankList::where(function ($query) use ($request) {
                if ($request->state) {
//                    Log::info($request->state);
                    $query->where('state', $request->state);
                }
                if ($request->key) {
                    $query->orWhere('bankTitle', 'like', '%' . $request->key . '%');
                }
            })->orderBy('sort', 'asc')->orderBy('id', 'desc')->paginate($this->pageSize);
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.finance.bank.index', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    /**
     * 新增线银行账号
     * @param
     * @return
     */
    public function create(Request $request)
    {
        $respJson = new RespJson();
        try {
            if ($request->isMethod('POST')) {
                $item = new Finance_BankList();
                $item->fill($request->all()); //将表单元素内容填充到对象
                $item->created_Id = Base::user()->id; //赋值当前登录用户ID,登录名称
                $item->created_Name = Base::user()->name;
                $item->save(); //提交保存
                if ($item) {
                    $respJson->setMsg('数据保存成功！');
                    $respJson->setData($item);
                    return response()->json($respJson);
                }
                $respJson->setCode(1);
                $respJson->setMsg('线路分类保存失败！');
                return response()->json($respJson);
            }
            return view('manage.finance.bank.create');
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    /**
     * 编辑线路分类
     */
    public function edit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $item = finance_bankList::find($id);
            if (!$item) {
                throw new Exception("数据错误，未找到相关信息！");
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
            return view('manage.finance.bank.edit', compact('item'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

}
