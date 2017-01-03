<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'name', 'number','classes_id', 'email', 'password', 'sex', 'phone', 'state', 'sort', 'remark',
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

    /**
     *选课记录
     */
    public function syllabus($id)
    {
        return Syllabus::where('term_id', $id)->where('student_id', $this->id)->with(['agendaRelate' => function ($query) {
            $query->select('id', 'agenda_id');
            $query->with(['agenda' => function ($query) {
                $query->select('id', 'name', 'teacher_id');
                $query->with(['teacher' => function ($query) {
                    $query->select('id', 'name');
                }]);
            }]);
        }])->select('id', 'student_id', 'agenda_id', 'term_id', 'state')->get();
    }

    /**
     *所属班级
     */
    public function classes()
    {
        return $this->belongsTo('App\Models\Classes', "classes_id");
    }

}
