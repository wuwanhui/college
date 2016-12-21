<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

/**
 * 学期课程关联
 * @package App\Models
 */
class Term_Agenda extends Model
{

    protected $table = "term_agenda";
    // use SoftDeletes;
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
     *所属学期
     */
    public function term()
    {
        return $this->belongsTo('App\Models\Term', 'term_id');
    }

    /**
     *所属课程
     */
    public function agenda()
    {
        return $this->hasOne('App\Models\Agenda', 'id', 'agenda_id');
    }

    /**
     *选课记录
     */
    public function agendaStudent()
    {
        return $this->hasMany('App\Models\Syllabus', 'agenda_id');
    }

    /**
     *关联课程
     */
    public function parent()
    {
        return $this->hasOne('App\Models\Term_Agenda', "parent_id",'id');
    }

//    /**
//     *子集课程
//     */
//    public function children()
//    {
//        return $this->hasOne('App\Models\Term_Agenda', "parent_id");
//    }



//    protected $appends = ['state_cn'];
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
