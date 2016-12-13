<?php

namespace App\Http\Controllers\Manage\Weixin;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Weixin;
use App\Jobs\WeixinSyncJob;
use App\Models\Weixin_User_Tags;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WeixinUserTagsController extends BaseController
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
            $list = Weixin_User_Tags::where(function ($query) use ($request) {
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
            return view('manage.weixin.user.tags.index', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function sync(Request $request)
    {
        $respJson = new RespJson();
        try {
            $job = (new WeixinSyncJob('tags'))->onQueue('weixinSyncTags');
            dispatch($job);
            $respJson->setMsg("成功加入同步队列");
            return response()->json($respJson);
        } catch
        (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function update(Request $request)
    {
        $respJson = new RespJson();
        try {

            $user = Weixin_User_Tags::find($request->id);
            if (!isset($user)) {
                $respJson->setCode(1);
                $respJson->setMsg("数据不存在");
                return response()->json($respJson);
            }
            $openid = $request->openid;
            $item = Weixin::userInfo($openid);
            if (isset($item->errcode)) {
                $respJson->setCode(1);
                $respJson->setMsg("获取用户信息失败：" . $item->errmsg);
                return response()->json($respJson);
            }
            $user->fill(objectToArray($item));

            if ($user->save()) {
                $respJson->setMsg("更新成功");
                $respJson->setData($user);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg("更新失败");
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function remark(Request $request)
    {
        $respJson = new RespJson();
        try {

            $user = Weixin_User_Tags::find($request->id);
            if (!isset($user)) {
                $respJson->setCode(1);
                $respJson->setMsg("数据不存在");
                return response()->json($respJson);
            }
            $openid = $request->openid;
            $remark = $request->remark;
            if (Weixin::userRemark($openid, $remark)) {
                $item = Weixin::userInfo($openid);
                $user->fill(objectToArray($item));
                if ($user->save()) {
                    $respJson->setMsg("更新成功");
                    $respJson->setData($user);
                    return response()->json($respJson);
                }
            }

            $respJson->setCode(1);
            $respJson->setMsg("更新失败");
            return response()->json($respJson);
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
            $user = new Weixin_User_Tags();
            return view('manage.weixin.user.tags.create', compact('customer'));
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
            $user = new Weixin_User_Tags();
            $inputs = $request->all();
            $validator = Validator::make($inputs, $user->Rules(), $user->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg("效验失败");
                $respJson->setData($validator);
                return response()->json($respJson);
            }
            $user->fill($inputs);
            if ($user->save()) {
                $respJson->setData($user);
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
            $user = Weixin_User_Tags::find($id);
            if (!$user) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            if ($request->isMethod('POST')) {

                $user->fill($request->all());
                $user->save();
                if ($user) {
                    $respJson->setData($user);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改失败");
                return response()->json($respJson);
            }
            return view('manage.weixin.user.tags.edit', compact('customer'));
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
            $user = Weixin_User_Tags::find($id);
            if (!$user) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            if ($request->isMethod('POST')) {

                $user->fill($request->all());
                $user->save();
                if ($user) {
                    $respJson->setData($user);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改失败");
                return response()->json($respJson);
            }
            return view('manage.weixin.user.tags.edit', compact('customer'));
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
            $count = Weixin_User_Tags::destroy(1);

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
