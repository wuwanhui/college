<?php

namespace App\Http\Controllers\Manage\CRM;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Manage\BaseController;
use App\Mail\AddIntegral;
use App\Mail\AddIntegralMail;
use App\Models\Crm_Customer;
use App\Models\Crm_Customer_Integral;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CustomerIntegralController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/customer']);
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
            $id = $request->id;
            $customer = Crm_Customer::find($id);
            $list = Crm_Customer_Integral::where(function ($query) use ($request) {
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }

                if (isset($request->id)) {
                    $query->where('customer_id', $request->id);
                }

                if (isset($request->key)) {
                    $query->Where('name', 'like', '%' . $request->key . '%');
                }
            })->with(['customer' => function ($query) {
                $query->select('id', 'name');
            }])->orderBy('id', 'desc')->paginate($this->pageSize);

            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.crm.customer.integral.index', compact('list', 'customer'));
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
            $integral = new Crm_Customer_Integral();
            $customer = new Crm_Customer();
            if ($request->id) {
                $customer = Crm_Customer::find($request->id);
            }
            $initBase = Crm_Customer_Integral::initBase();
            return view('manage.crm.customer.integral.create', compact('integral', 'customer', 'initBase'));
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
            $integral = new Crm_Customer_Integral();
            $inputs = $request->all();
            $validator = Validator::make($inputs, $integral->Rules(), $integral->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg("效验失败");
                $respJson->setData($validator);
                return response()->json($respJson);
            }
            $integral->fill($inputs);
            if ($integral->save()) {
                Mail::queue(new AddIntegralMail($integral));//加入积分通知邮件队列
                $respJson->setData($integral);
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
            $integral = Crm_Customer_Integral::find($id);
            if (!$integral) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            if ($request->isMethod('POST')) {

                $integral->fill($request->all());
                $integral->save();
                if ($integral) {
                    $respJson->setData($integral);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改失败");
                return response()->json($respJson);
            }
            return view('manage.crm.customer.integral.edit', compact('customer'));
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
            $integral = Crm_Customer_Integral::find($id);
            if (!$integral) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            if ($request->isMethod('POST')) {

                $integral->fill($request->all());
                $integral->save();
                if ($integral) {
                    $respJson->setData($integral);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改失败");
                return response()->json($respJson);
            }
            return view('manage.crm.customer.integral.edit', compact('customer'));
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
            $count = Crm_Customer_Integral::destroy(1);

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


}
