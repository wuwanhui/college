<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

/**
 * 课程
 * @package App\Models
 */
class Agenda extends Model
{
    use SoftDeletes;
    protected $table = "agendas";
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
     *任课教师
     */
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher', "teacher_id");
    }


    /**
     *关联学期
     */
    public function terms()
    {
        return $this->belongsToMany('App\Models\Term', 'term_agenda');
    }

    /**
     *关联课程
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Agenda', "parent_id");
    }

    /**
     *子集课程
     */
    public function children()
    {
        return $this->hasMany('App\Models\Agenda', "parent_id");
    }


    /**
     *选课学生记录
     */
    public function students()
    {
        return $this->belongsToMany('App\Models\Student', 'student_agenda');
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
