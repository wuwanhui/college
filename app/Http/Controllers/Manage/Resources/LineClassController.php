<?php

namespace App\Http\Controllers\Manage\Resources;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use App\Http\Facades\Base;
use App\Models\Res_LineClass;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Common\RespJson;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use phpDocumentor\Reflection\Types\Integer;


/*
 * 线路分类-控制器类
 * */

class LineClassController extends BaseController
{

    /**
     * 线路类别列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $respJson = new RespJson();
        try {

            $list = Res_LineClass::where(function ($query) use ($request) {
                if ($request->key) {
                    $query->where('name', 'like', '%' . $request->key . '%')->orWhere('tag', 'like', '%' . $request->key . '%'); //按名称或标签模糊查询
                }
                if (isset($request->state)&&$request->state!=-1) {
                    $query->where('state', $request->state);
                }
            })->orderBy('sort', 'asc')->orderBy('id', 'asc');
            $list = $list->paginate($this->pageSize);
            //判断需要输出的内容是否为json
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.resources.lineclass.index', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }
    
    /**
     * 新增线路分类
     * @param
     * @return
     */
    public function create(Request $request)
    {
        $respJson = new RespJson();
        try {
            if ($request->isMethod('POST')) {
                $item = new Res_LineClass();
                $item->fill($request->all()); //将表单元素内容填充到对象
                $item->createId = Base::user()->id; //赋值当前登录用户ID,登录名称
                $item->createName = Base::user()->name;
                $item->save(); //提交保存
                if ($item) {
                    $respJson->setData($item);
                    return response()->json($respJson);
                }
                $respJson->setCode(1);
                $respJson->setMsg('线路分类保存失败！');
                return response()->json($respJson);
            }
            return view('manage.resources.lineclass.create');
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
     *删除线路分类
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
