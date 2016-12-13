<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/user']);
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
            $lists = User::where(function ($query) use ($request) {

                if ($request->state) {
                    $query->where('state', $request->state);
                }
                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }
            })->with(["roles" => function ($query) {
                $query->select('id', 'name', 'display_name');
            }])->orderBy('id', 'desc')->paginate($this->pageSize);
            if (isset($request->json)) {
                $respJson->setData($lists);
                return response()->json($respJson);
            }
            return view('manage.system.user.index', compact('lists'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


    public function create(Request $request)
    {
        try {
            $user = new User();
            return view('manage.system.user.create', compact('user'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常：' . $ex->getMessage() . ",行号：" . $ex->getLine());
        }
    }

    public function edit(Request $request)
    {
        try {
            $id = $request->id;
            $user = User::find($id);
            if (!$user) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            if ($request->isMethod('POST')) {
                $respJson = new RespJson();
                $inputs = $request->all();
                $user->fill($inputs);
                $user->save();
                if ($user) {
                    $respJson->setData($user);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改失败");
                return response()->json($respJson);
            }

            return view('manage.system.user.edit', compact('user'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function getAuthorize(Request $request)
    {
        $respJson = new RespJson();
        try {

            $roles = Role::where(function ($query) {
            })->orderBy('id', 'desc')->paginate($this->pageSize);

            return view('manage.system.user.authorize', compact('roles'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function postAuthorize(Request $request)
    {
        $respJson = new RespJson();
        try {
            $ids = $request->ids;
            if (!$ids) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $id = $request->id;
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $user = User::find($id);;

            if ($user->roles()->sync($ids)) {
                $respJson->setData($user);
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

    public function addRole(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $roles = $request->roles;
            if (!isset($id) || !isset($roles)) {
                $respJson->setCode(2);
                $respJson->setMsg('参数错误');
                return response()->json($respJson);
            }
            $user = User::find($id);
            if (!$user) {
                $respJson->setCode(1);
                $respJson->setMsg('数据加载失败');
                return response()->json($respJson);
            }

            $user->attachRole($roles);
            $respJson->setMsg('授权成功');
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function getRole(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $roles = $request->roles;
            if (!isset($id) || !isset($roles)) {
                $respJson->setCode(2);
                $respJson->setMsg('参数错误');
                return response()->json($respJson);
            }
            $user = User::find($id);
            if (!$user) {
                $respJson->setCode(1);
                $respJson->setMsg('数据加载失败');
                return response()->json($respJson);
            }

            $user->attachRole($roles);
            $respJson->setMsg('授权成功');
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


    public function postCreate(Request $request)
    {
        try {
            $user = new User();
            $input = $request->all();

            $validator = Validator::make($input, $user->Rules(), $user->messages());
            if ($validator->fails()) {
                return redirect('/manage/user/create')
                    ->withInput()
                    ->withErrors($validator);
            }
            $user->fill($input);
            $user->liable_id = Base::user("id");
            $user->save();
            if ($user) {
                return redirect('/manage/user')->withSuccess('保存成功！');
            }
            return Redirect::back()->withErrors('保存失败！');
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function getEdit(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            return view('manage.system.user.edit', compact('user'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function postEdit(Request $request, $id)
    {
        try {

            $user = User::find($id);
            if (!$user) {
                return Redirect::back()->withErrors('数据加载失败！');
            }
            $input = $request->all();

            $validator = Validator::make($input, $user->Rules(), $user->messages());
            if ($validator->fails()) {
                return redirect('/manage/user/create')
                    ->withInput()
                    ->withErrors($validator);
            }
            $user->fill($input);
            $user->save();
            if ($user) {
                return redirect('/manage/user')->withSuccess('保存成功！');
            } else {
                return Redirect::back()->withErrors('保存失败！');
            }
            return view('manage.system.user.edit', compact('user'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function getDetail(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return redirect('/manage/user')->withErrors('数据加载失败！');
            }
            return view('manage.system.user.detail', compact('user'));
        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return redirect('/manage/user')->withErrors('数据加载失败！');
            }
            $user->delete();
            if ($user) {
                return redirect('/manage/user')->withSuccess('删除成功！');
            }
            return Redirect::back()->withErrors('删除失败！');

        } catch (Exception $ex) {
            return Redirect::back()->withInput()->withErrors('异常！' . $ex->getMessage());
        }
    }


}
