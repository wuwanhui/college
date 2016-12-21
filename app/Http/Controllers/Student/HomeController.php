<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Controller;
use App\Http\Facades\Base;
use App\Models\Agenda;
use App\Models\Student;
use App\Models\Syllabus;
use App\Models\Term;
use App\Models\Term_Agenda;
use App\Models\Term_Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

                $query->with(['agenda' => function ($query) {
                    $query->with(['teacher', 'parent']);
                }, 'parent']);

            }, 'students' => function ($query) {
                $query->where('student_id', Base::student('id'))->first()->select('id', 'name');

                $query->with(['student', 'syllabus' => function ($query) {
                    $query->with(['agendaRelate' => function ($query) {
                        $query->with(['agenda' => function ($query) {
                            $query->with(['teacher' => function ($qurey) {
                                $qurey->select('id', 'name');
                            }]);
                            $query->select('id', 'name', 'teacher_id');
                        }]);
                    }]);
                }]);
            }])->first();

            if (isset($request->json)) {
                $respJson->setData($termItem);
                return response()->json($respJson);
            }

            //获取我所有学期信息
            $termList = Term::whereHas('students', function ($query) {
                $query->where('student_id', Base::student('id'));
            })->where('state', 0)->get();
            return view('student.index', compact('termList', 'termItem'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function addSyllabus(Request $request)
    {
        $respJson = new RespJson();
        try {
            $termId = $request->term_id;
            if (!$termId) {
                return response()->json($respJson->validator('学期参数错误！'));
            }
            $studentId = $request->student_id;
            if (!$studentId) {
                return response()->json($respJson->validator('学生参数错误！'));
            }

            $agendaId = $request->agenda_id;
            if (!$agendaId) {
                return response()->json($respJson->validator('课程参数错误！'));
            }

            $term = Term::where('id', $termId)->with(['students' => function ($query) use ($studentId) {
                $query->where('id', $studentId);
            }, 'agendas' => function ($query) use ($agendaId) {
                $query->where('id', $agendaId);
            }])->first();

            if (count($term->students) == 0) {
                return response()->json($respJson->validator('未找到学生信息'));
            }

            if (count($term->agendas) == 0) {
                return response()->json($respJson->validator('未找到课程信息'));
            }

            $syllabus = Syllabus::where('term_id', $termId)->where('student_id', $studentId)->get();

            if (count($syllabus) == 4) {
                return response()->json($respJson->errors('选课失败，此学生课程已经超限'));
            }
            $syllabusItem = Syllabus::firstOrCreate(['term_id' => $termId, 'student_id' => $studentId, 'agenda_id' => $agendaId]);
            if (isset($syllabusItem)) {
                return response()->json($respJson->succeed('选课成功', $syllabusItem));
            }

            $respJson->setMsg("选课失败");
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


    public function deleteSyllabus(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return response()->json($respJson->validator('参数错误！'));
            }
            if (Syllabus::destroy($id)) {
                return response()->json($respJson->succeed('删除成功！'));
            }
            return response()->json($respJson->errors("删除失败"));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
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
                return response()->json($respJson->validator('效验失败！'));

            }
            $student->fill($input);
            if (isset($request->password)) {
                $student->password = bcrypt($request->password);
            }
            if ($student->save()) {
                return response()->json($respJson->succeed('修改成功！'));
            }
            return response()->json($respJson->errors('修改失败！'));
        } catch (Exception $ex) {
            return response()->json($respJson->exception('异常！' . $ex->getMessage()));
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
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }
}
