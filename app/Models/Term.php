<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

/**
 * 学期信息
 * @package App\Models
 */
class Term extends Model
{
    protected $table = "terms";
    use SoftDeletes;
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
     *关联课程
     */
    public function agendas()
    {
        return $this->hasMany('App\Models\Term_Agenda', 'term_id');
    }

    /**
     *关联学生
     */
    public function students()
    {
        return $this->hasMany('App\Models\Term_Student', 'term_id');
    }


    /**
     *报名学生
     */
    public function syllabus()
    {
        return $this->hasMany('App\Models\Syllabus', 'term_id');
    }


//    protected $appends = ['state_cn'];
//
//
//    //状态
//    public static $stateList = [0 => '正常', 1 => '禁用'];
//
//    public function getStateCnAttribute()
//    {
//        if (array_key_exists($this->state, self::$stateList)) {
//            return self::$stateList[$this->state];
//        }
//        return self::$stateList[0];
//    }
}
