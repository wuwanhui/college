<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;
    protected $table = "students";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'number', 'idCar', 'email', 'password', 'sex', 'phone', 'state', 'sort', 'remark',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * 获取应用到请求的验证规则
     *
     * @return array
     */
    public function Rules()
    {
        return [
            'name' => 'required|max:255|min:2',
        ];
    }


    /**
     * 获取应用到请求的验证规则
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '名称为必填项',
        ];
    }



    protected $appends = ['state_cn', 'sex_cn'];


    //状态
    public static $stateList = [0 => '正常', 1 => '禁用'];

    public function getStateCnAttribute()
    {
        if (array_key_exists($this->state, self::$stateList)) {
            return self::$stateList[$this->state];
        }
        return self::$stateList[0];
    }

    //性别
    public static $sexList = [-1 => '未知', 0 => '男生', 1 => '女生'];

    public function getSexCnAttribute()
    {
        if (array_key_exists($this->state, self::$sexList)) {
            return self::$sexList[$this->sex];
        }
        return self::$sexList[0];
    }
}
