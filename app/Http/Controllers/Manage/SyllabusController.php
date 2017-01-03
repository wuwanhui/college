<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Common\RespJson;

use App\Mail\SyllabusMail;
use App\Models\Syllabus;
use App\Models\Term;
use App\Models\Term_Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class SyllabusController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/syllabus']);
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
            $termId = $request->termId;
            if (isset($termId)) {
                $term = Term::find($termId);
            } else {
                $term = Term::first();
            }

            $studentList = Syllabus::where('term_id', $term->id)->with(['studentRelate' => function ($query) {
                $query->with('student');
            }, 'agendaRelate' => function ($query) {
                $query->with('agenda');
            }])->orderBy('student_id', 'asc')->paginate($this->pageSize);


            $agendaList = $term->agendas()->with(['agenda' => function ($query) {
                $query->select('id', 'name', 'teacher');
            }, 'agendaStudent' => function ($query) {
                $query->select('id', 'student_id', 'agenda_id', 'term_id', 'state');
                $query->with(['studentRelate' => function ($query) {
                    $query->select('id', 'student_id', 'term_id', 'state');
                    $query->with(['student' => function ($query) {
                        $query->select('id', 'name', 'state');
                    }]);
                }])->select('id', 'student_id', 'agenda_id', 'term_id', 'state');

            }])->select('id', 'agenda_id', 'term_id', 'state')->orderBy('id', 'asc')->orderBy('state', 'asc')->get();

//            $studentList = $term->syllabus()->with(['term' => function ($query) {
//                $query->select('id', 'name');
//            }, 'student' => function ($query) {
//                $query->select('id', 'name');
//            }, 'agenda' => function ($query) {
//                $query->select('id', 'name');
//            }])->orderBy('id', 'asc')->paginate($this->pageSize);


            if (isset($request->json)) {
                $obj = new stdClass();
                $obj->studentList = $studentList;
                $obj->agendaList = $agendaList;
                return $respJson->succeed('成功', $obj);
            }
            $terms = Term::with(['students', 'agendas' => function ($query) {
                // $query->where('parent_id', 0);
            }])->get();
            return view('manage.syllabus.index', compact('studentList', 'agendaList', 'terms', 'term'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    /**
     * 课程表
     *
     * @return \Illuminate\Http\Response
     */
    public function getReport(Request $request)
    {
        $respJson = new RespJson();
        try {
            $termId = $request->termId;
            if (isset($termId)) {
                $term = Term::find($termId);
            } else {
                $term = Term::first();
            }

            $studentList = Term_Student::where('term_id', $term->id)->with(['student' => function ($query) {

            }, 'syllabus' => function ($query) {
                $query->with(['agendaRelate' => function ($query) {
                    $query->with(['agenda' => function ($query) {
                    }]);
                }]);
            }])->orderBy('student_id', 'asc')->paginate($this->pageSize);

            if (isset($request->json)) {
                $obj = new stdClass();
                $obj->studentList = $studentList;
                $obj->term = $term;
                return $respJson->succeed('成功', $obj);
            }
            $terms = Term::with(['students', 'agendas' => function ($query) {
                // $query->where('parent_id', 0);
            }])->get();
            return view('manage.syllabus.report', compact('studentList', 'terms', 'term'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function getCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $term = Term::where(function ($query) use ($request) {
                if (isset($request->id)) {
                    $query->Where('id', $request->id);
                }
            })->with(['agendas' => function ($query) {
                $query->with(['agenda' => function ($query) {
                    //$query->where('parent_id', 0);
                }]);

            }, 'students' => function ($query) {
                $query->with(['student' => function ($query) {
                    //$query->where('parent_id', 0);
                }]);
            }])->first();
            return view('manage.syllabus.create', compact('term'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }


    }

    public function postCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $state = $request->state;
            $termId = $request->term_id;
            if (!$termId) {
                return $respJson->validator('未找到学期参数');
            }
            $studentId = $request->student_id;
            if (!$studentId) {
                return $respJson->validator('未找到学生参数');

            }

            $agendaId = $request->agenda_id;
            if (!$agendaId) {
                return $respJson->validator('未找到课程参数');
            }

            $term = Term::where('id', $termId)->with(['students' => function ($query) use ($studentId) {
                $query->where('id', $studentId);
            }, 'agendas' => function ($query) use ($agendaId) {
                $query->where('id', $agendaId);
            }])->first();

            if (count($term->students) == 0) {
                return $respJson->validator('未找到学生信息');
            }

            if (count($term->agendas) == 0) {
                return $respJson->validator('未找到课程信息');
            }

            $syllabus = Syllabus::where('term_id', $termId)->where('student_id', $studentId)->get();
            if (count($syllabus) == 4) {
                return $respJson->errors('选课失败，此学生课程已经超限');
            }
            if (count($syllabus->where('agenda_id', $agendaId)) > 0) {
                return $respJson->errors('选课失败，此课程已经选择');
            }

            $syllabusItem = Syllabus::firstOrCreate(['term_id' => $termId, 'student_id' => $studentId, 'agenda_id' => $agendaId, 'state' => $state]);

            if ($syllabusItem) {
                Mail::send(new SyllabusMail($syllabusItem));
                return $respJson->succeed('成功', $syllabusItem);
            }
            return $respJson->failure('选课失败！');

        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function getEdit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $id = $request->id;
            $syllabus = Syllabus::find($id);
            if (!$syllabus) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            $term = Term::where(function ($query) use ($request, $syllabus) {
                $query->Where('id', $syllabus->term_id);
            })->with(['agendas' => function ($query) {
                $query->with(['agenda' => function ($query) {
                    //$query->where('parent_id', 0);
                }]);

            }])->first();

            return view('manage.syllabus.edit', compact('syllabus', 'term'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function postEdit(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return $respJson->validator('参数不存在！');
            }
            $id = $request->id;
            $syllabus = Syllabus::find($id);
            if (!$syllabus) {
                return $respJson->validator('数据不存在！');
            }
            $syllabus = Syllabus::find($id);

            $syllabus->fill($request->all());
            if ($syllabus->save()) {
                if ($syllabus->state == 2) {
                    Mail::send(new SyllabusMail($syllabus));
                }
                return $respJson->succeed('修改成功！', $syllabus);
            }
            return $respJson->failure('修改失败！');
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function postRandom(Request $request)
    {
        $respJson = new RespJson();
        try {
            $num = $request->num;
            $agendaId = $request->agendaId;
            if (!$agendaId || !$num) {
                return $respJson->validator('参数不存在！');
            }
            DB::beginTransaction();
            Syllabus::where('agenda_id', $agendaId)->update(['state' => 2]);
            Syllabus::where('agenda_id', $agendaId)->inRandomOrder()->limit($num)->update(['state' => 0]);
            DB::commit();
            return $respJson->succeed('随机选择成功');
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function getDetail(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $id = $request->id;
            $syllabus = Syllabus::find($id);
            if (!$syllabus) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }

            return view('manage.syllabus.detail', compact('syllabus'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function postMail(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $syllabusItem = Syllabus::find($id);
            if (!isset($syllabusItem)) {
                return $respJson->validator('数据不存在！');
            }
            Mail::send(new SyllabusMail($syllabusItem));
            return $respJson->succeed('邮件发送成功');
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }

    }


    public function delete(Request $request)
    {
        $respJson = new RespJson();
        try {
            $ids = $request->ids;
            if (!$ids) {
                return $respJson->validator('参数错误');

            }
            $count = Syllabus::destroy($ids);

            if ($count > 0) {
                return $respJson->succeed('删除成功', $count);
            }
            return $respJson->failure('删除失败');


        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }
    /**
     * export导出
     *
     * @return \Illuminate\Http\Response
     */
    public function postExport(Request $request)
    {
        $respJson = new RespJson();
        try {

            $tempid=$request->temp_id;
            $list = Term_Student::where('term_id', $tempid)->with(['student' => function ($query) {

            }, 'syllabus' => function ($query) {
                $query->with(['agendaRelate' => function ($query) {
                    $query->with(['agenda' => function ($query) {
                    }]);
                }]);
            }])->orderBy('student_id', 'asc')->get();

            Excel::create('学生课程表',function($excel) use ($list){
                $excel->sheet('syllabus', function($sheet) use ($list){
                    $sheet->rows($list);
                });
            })->export('xls');
            return $respJson->succeed('导出成功', $list);
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    /**
     * API
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Syllabus::where(function ($query) use ($request) {
                if (isset($request->createId)) {
                    $query->where('createId', $request->createId);
                }
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }
            })->orderBy('id', 'asc')->select('id', 'name')->get();

            return $respJson->succeed('成功', $list);
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }



}
