<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Controller;
use App\Http\Facades\Base;
use App\Models\Agenda;
use App\Models\Student;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
            $termList = Term::where(function ($query) use ($request) {

                if ($request->state) {
                    $query->where('state', $request->state);
                }
                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }
            })->with(['agendas' => function ($query) {
                $query->where('parent_id', 0);
                $query->with(['teacher', 'children']);

            }])->orderBy('id', 'desc')->paginate($this->pageSize);
            if (isset($request->json)) {
                $respJson->setData($termList);
                return response()->json($respJson);
            }

            $agendaList = Base::student()->agendas()->with('teacher')->get();

            if (isset($request->json)) {
                $respJson->setData($termList);
                return response()->json($respJson);
            }

            return view('student.index', compact('termList', 'agendaList'));
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
            $studentId = $request->student_id;
            if (!$studentId) {
                $respJson->setCode(1);
                $respJson->setMsg('未找到学生信息！');
                return response()->json($respJson);
            }

            $agendaId = $request->agenda_id;
            if (!$agendaId) {
                $respJson->setCode(1);
                $respJson->setMsg('未找到课程信息！');
                return response()->json($respJson);
            }
            $agenda = Agenda::find($agendaId);
            if (!$agenda) {
                $respJson->setCode(1);
                $respJson->setMsg('未找到相关课程信息！');
                return response()->json($respJson);
            }
            $student = Student::find($studentId);

            if (!$student) {
                $respJson->setCode(1);
                $respJson->setMsg('学生信息不存在！');
                return response()->json($respJson);
            }
            if (count($student->agendas) == 4) {
                $respJson->setCode(1);
                $respJson->setMsg('选课失败，因为你的课程已经超限！');
                return response()->json($respJson);
            }
            $ids = array();
            array_push($ids, $agendaId, ['term_id' => 1]);
            if (count($agenda->children) > 0) {
                foreach ($agenda->children as $item) {
                    array_push($ids, $item->id, ['term_id' => 1]);
                }
            }
            if ($student->agendas()->sync($ids)) {
                $respJson->setData($student);
                return response()->json($respJson);
            }

            $respJson->setMsg("选课失败");
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
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
