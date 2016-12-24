<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Controller;
use App\Http\Facades\Base;
use App\Mail\SyllabusMail;
use App\Models\Agenda;
use App\Models\Student;
use App\Models\Syllabus;
use App\Models\Term;
use App\Models\Term_Agenda;
use App\Models\Term_Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use stdClass;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.student');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $respJson = new RespJson();
        try {
            $termId = $request->term_id;


            //获取当前学期信息
            $termItem = Term::whereHas('students', function ($query) {
                $query->where('student_id', Base::student('id'));
            })->where(function ($query) use ($termId) {
                if (isset($termId)) {
                    $query->where('id', $termId);
                }
            })->with(['agendas' => function ($query) {
                // $syllabus = Syllabus::where('term_id', $termId)->where('student_id', $studentId)->get();
//               / $query->whereNotIn('id', $query->syllabus()->pluck('id'));
                $query->where('parent_id', 0);
                $query->with(['agenda' => function ($query) {
                    //  $query->with([  'parent']);
                }, 'parent' => function ($query) {
                    $query->with(['agenda' => function ($query) {
                        $query->select('id', 'name');
                    }]);
                }]);

            }, 'students' => function ($query) {
                $query->where('student_id', Base::student('id'))->first()->select('id', 'name');

                $query->with(['student' => function ($query) {
                    //  $query->select('id', 'name');
                }, 'syllabus' => function ($query) {
                    $query->with(['agendaRelate' => function ($query) {
                        $query->with(['agenda' => function ($query) {

                            $query->select('id', 'name', 'teacher');
                        }]);
                    }]);
                }]);
            }])->first();

            if (isset($request->json)) {
                return $respJson->succeed('修改成功！', $termItem);
            }

            //获取我所有学期信息
            $termList = Term::whereHas('students', function ($query) {
                $query->where('student_id', Base::student('id'));
            })->where('state', 0)->get();
            return view('student.index', compact('termList', 'termItem'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function addSyllabus(Request $request)
    {
        $respJson = new RespJson();
        try {
            $termId = $request->term_id;
            if (!$termId) {
                return $respJson->validator('学期参数错误！');
            }
            $studentId = $request->student_id;
            if (!$studentId) {
                return $respJson->validator('学生参数错误！');
            }

            $agendaId = $request->agenda_id;
            if (!$agendaId) {
                return $respJson->validator('课程参数错误！');
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

            DB::beginTransaction();

            $syllabusItem = Syllabus::firstOrCreate(['term_id' => $termId, 'student_id' => $studentId, 'agenda_id' => $agendaId]);
            $parent = $term->agendas->first()->parent;
            if (isset($parent)) {
                Syllabus::firstOrCreate(['term_id' => $termId, 'student_id' => $studentId, 'agenda_id' => $parent->id]);

            }

            DB::commit();
            return $respJson->succeed('选课成功', $syllabusItem);
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function deleteSyllabus(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return $respJson->validator('参数错误！');
            }
            if (Syllabus::destroy($id)) {
                return $respJson->succeed('删除成功！');
            }
            return $respJson->errors("删除失败");
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function postEdit(Request $request)
    {
        $respJson = new RespJson();
        try {

            $student = Base::student();
            $input = $request->all();

            $validator = Validator::make($input, $student->Rules(), $student->messages());
            if ($validator->fails()) {
                return $respJson->validator('效验失败！');

            }
            $student->fill($input);
            if (isset($request->password)) {
                $student->password = bcrypt($request->password);
            }
            if ($student->save()) {
                return $respJson->succeed('修改成功！', $student);
            }
            return $respJson->errors('修改失败！');
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function agendaDetail(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $agenda = Agenda::find($id);
            if (!$agenda) {
                return Redirect::route('alert')->with('message', '数据不存在！');
            }
            return view('student.detail', compact('agenda'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {

        return view('student.home');
    }

    public function postClearCache()
    {
        $respJson = new RespJson();
        try {
            Cache::flush();
            return $respJson->succeed('清除缓存成功！');
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }
}
