<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

/**
 * 学期学生
 * @package App\Models
 */
class Term_Student extends Model
{

    protected $table = "term_student";
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
     *所属学期
     */
    public function term()
    {
        return $this->belongsTo('App\Models\Term', 'term_id');
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
