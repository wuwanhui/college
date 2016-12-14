<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

/**
 * 学生选课表
 * @package App\Models
 */
class Student_Agenda extends Model
{

    protected $table = "student_agenda";
    //use SoftDeletes;
    protected $guarded = ['_token'];

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

    /**
     *学生
     */
    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    /**
     *课程
     */
    public function agenda()
    {
        return $this->belongsTo('App\Models\Agenda', 'agenda_id');
    }

    protected $appends = ['state_cn'];

    //状态
    public static $stateList = [0 => '正常', 1 => '禁用'];

    public function getStateCnAttribute()
    {
        if (array_key_exists($this->state, self::$stateList)) {
            return self::$stateList[$this->state];
        }
        return self::$stateList[0];
    }
}
