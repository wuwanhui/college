<?php

namespace App\Http\Service;

use App\Models\Base_Maps;
use App\Models\Base_Type;
use App\Models\Config;
use App\Models\Enterprise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * 基础服务
 * @package App\Http\Service
 */
class BaseService
{
    private $user = null;

    public function __construct()
    {

    }

    /**
     *获取用户信息
     * @param $key
     * @return mixed
     */
    public function user($key = null)
    {
        $this->user = Auth::guard('manage')->user();
        if ($key) {
            return $this->user->$key;
        } else {
            return $this->user;
        }

    }

    /**
     *获取用户信息
     * @param $key
     * @return mixed
     */
    public function manage($key = null)
    {
        $this->user = Auth::guard('manage')->user();
        if ($key) {
            return $this->user->$key;
        } else {
            return $this->user;
        }

    }

    /**
     *获取用户信息
     * @param $key
     * @return mixed
     */
    public function member($key = null)
    {
        $this->user = Auth::guard('member')->user();
        if ($key) {
            return $this->user->$key;
        } else {
            return $this->user;
        }

    }

    /**
     *获取用户信息
     * @param $key
     * @return mixed
     */
    public function admin($key = null)
    {
        $this->user = Auth::guard('admin')->user();
        if ($key) {
            return $this->user->$key;
        } else {
            return $this->user;
        }

    }

    /**
     * 获取企业参数配置
     * @param $key
     * @return mixed
     */
    public function config($key = null)
    {
        $config = Cache::get('config', function () {
            $value = Config::first();
            Cache::put(['config' => $value], 100);
            return $value;
        });

        if ($key) {
            return $config->$key;
        }
        return $config;

    }


    /**
     * 获取企业参数配置
     * @param $key
     * @return mixed
     */
    public function enterprise($key = null)
    {
        $enterprise = Cache::get('enterprise', function () {
            $value = Enterprise::first();
            Cache::put(['enterprise' => $value], 100);
            return $value;
        });

        if ($key) {
            return $enterprise->$key;
        } else {
            return $enterprise;
        }
    }


    /**
     * 基础信息
     * @param $key
     * @return mixed
     */
    public function data($code = null)
    {
        $data = Cache::get('data_' . $code, function () use ($code) {
            $value = Base_Type::where('code', $code)->where('state', 0)->select('id', 'name', 'code')->with(['baseDatas' => function ($query) {
                $query->where('state', 0)->select('baseType_id', 'id', 'name', 'value', 'isSystem');
            }])->first();
            if ($value) {
                Cache::put(['data_' . $code => $value], 100);
            } else {
                $value = new Base_Type();
            }
            return $value;
        });

        return $data;

    }


    /**
     *获取基本Maps参数
     * @param $key
     * @return mixed
     */
    public function maps($code)
    {
        $arr = Cache::get('maps', function () {
            $value = DB::table('base_maps')->select('code', 'value')->get();
            if ($value) {
                Cache::put(['maps' => $value], 100);
            }
            return $value;
        });
        if ($arr) {
            foreach ($arr as $value) {
                if ($value->code == $code) {
                    return $value->value;
                }
            }
        }
        return '';
    }


    /**
     *当前用户的菜单
     * @param $key
     * @return mixed
     */
    public function menu($parent = null)
    {
//        $arr = Cache::get('menu', function () {
//            $value = DB::table('permissions')->get();
//            if ($value) {
//                Cache::put(['menu' => $value], 100);
//            }
//            return $value;
//        });
        $permissions = [];
        $roles = $this->user()->roles;
        if (isset($roles)) {
            foreach ($roles as $item) {
                array_push($permissions, $item->perms);
            }
        }
        return array_unique($permissions) ;
    }

}