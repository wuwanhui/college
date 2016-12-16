<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Manage\BaseController;
use App\Jobs\TermChangeJob;
use App\Jobs\SendTermChangeEmail;
use App\Jobs\SendIntegralEmail;
use App\Models\Agenda;
use App\Models\Student;
use App\Models\Term;
use App\Models\Term_Agenda;
use App\Models\Term_Student;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use stdClass;

class TermController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/term']);
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
            $list = Term::where(function ($query) use ($request) {
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }

                if (isset($request->key)) {
                    $query->Where('name', 'like', '%' . $request->key . '%');
                }
            })->with(['agendas' => function ($query) {
                // $query->select('agenda_id');
            }, 'students'])->orderBy('id', 'desc')->paginate($this->pageSize);

            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }
            return view('manage.term.index', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function getCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $term = new Term();
            return view('manage.term.create', compact('term'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function postCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $term = new Term();
            $inputs = $request->all();
            $validator = Validator::make($inputs, $term->Rules(), $term->messages());
            if ($validator->fails()) {
                $respJson->setCode(2);
                $respJson->setMsg("效验失败");
                $respJson->setData($validator);
                return response()->json($respJson);
            }
            $term->fill($inputs);
            if ($term->save()) {
                $respJson->setData($term);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg("新增失败");
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
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
            $term = Term::find($id);
            if (!$term) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }

            return view('manage.term.edit', compact('term'));
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
            $id = $request->id;
            if (!$id) {
                return Redirect::route('alert')->with('message', '参数不存在！');
            }
            $id = $request->id;
            $term = Term::find($id);
            if (!$term) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            $term->fill($request->all());
            if ($term->save()) {

//                $job =new TermChangeJob($term);
//                $job->onQueue('emails') ->delay(Carbon::now()->addMinutes(1));
//
//                dispatch($job);
                $respJson->setData($term);
                return response()->json($respJson);
            }
            $respJson->setMsg("修改失败");
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
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
            $term = Term::where('id', $id)->withCount('agendas')->first();
            if (!$term) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            $agendas = $term->agendas()->with(['agenda' => function ($query) {
                $query->select('id', 'name', 'teacher_id')->with(['teacher' => function ($query) {
                    $query->select('id', 'name');
                }]);
//                ->with(['children' => function ($query) {
//                    $query->select('id', 'name', 'parent_id');
//                }]);
            }, 'agendaStudent'])->orderBy('id', 'desc')->paginate($this->pageSize);


//            $agendas = $term->agendas()->with(['children' => function ($query) {
//                $query->select('id', 'name', 'parent_id');
//            }])->with('students')->withPivot('cycle', 'state')->with(['teacher' => function ($query) {
//                $query->select('id', 'name');
//            }])->orderBy('id', 'desc')->paginate($this->pageSize);

            $students = $term->students()->with(['student' => function ($query) {

//                ->with(['children' => function ($query) {
//                    $query->select('id', 'name', 'parent_id');
//                }]);
            }])->orderBy('id', 'desc')->paginate($this->pageSize);

            //$students = $term->students()->orderBy('id', 'desc')->withPivot('id')->paginate($this->pageSize);


            if (isset($request->json)) {
                $obj = new stdClass();
                $obj->term = $term;
                $obj->agendas = $agendas;
                $obj->students = $students;
                $respJson->setData($obj);
                return response()->json($respJson);
            }

            return view('manage.term.detail', compact('term', 'agendas', 'students'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


    public function delete(Request $request)
    {
        $respJson = new RespJson();
        try {
            $ids = $request->ids;
            if (!$ids) {
                $respJson->setCode(2);
                $respJson->setMsg('参数错误');
                return response()->json($respJson);
            }
            $count = Term::destroy($ids);

            if ($count > 0) {
                $respJson->setMsg('删除成功');
                $respJson->setData($count);
                return response()->json($respJson);
            }
            $respJson->setCode(1);
            $respJson->setMsg('删除失败');
            return response()->json($respJson);

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
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
            $list = Term::where(function ($query) use ($request) {
                if (isset($request->createId)) {
                    $query->where('createId', $request->createId);
                }
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }
            })->orderBy('id', 'desc')->select('id', 'name')->get();

            $respJson->setData($list);
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


    public function getBindAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {


            $list = Agenda::where(function ($query) use ($request) {
                $termId = $request->id;
                if (isset($termId)) {
                    $query->whereNotIn('id', Term::find($termId)->agendas()->pluck('agenda_id'));
                }

                if ($request->state) {
                    $query->where('state', $request->state);
                }
                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }
            })->orderBy('id', 'desc')->paginate($this->pageSize);
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }

            return view('manage.term.bindAgenda', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function postBindAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {
            $agendaId = $request->agenda_id;
            if (!$agendaId) {
                return response()->json($respJson->validator('请选择课程'));
            }

            $termId = $request->term_id;
            if (!$termId) {
                return response()->json($respJson->validator());
            }

            $cycle = $request->cycle;
            if (!$cycle) {
                return response()->json($respJson->validator('请选择开课周期'));
            }
            $state = $request->state;
            if (!$state) {
                return response()->json($respJson->validator('请选择课程状态'));
            }
            $term = Term::find($termId);
            if (!$term) {
                return response()->json($respJson->errors('数据不存在!'));
            }

            $termAgenda = Term_Agenda::firstOrCreate(['term_id' => $termId, 'agenda_id' => $agendaId, 'cycle' => $cycle, 'state' => $state]);

            if ($termAgenda) {
                return response()->json($respJson->succeed('绑定课程成功'));
            }

            $respJson->setMsg("绑定失败");
            return response()->json($respJson);
        } catch (Exception $ex) {
            return response()->json($respJson->exception('异常！' . $ex->getMessage()));
        }
    }


    public function postDeleteAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return response()->json($respJson->validator('参数错误'));
            }
            $agenda = Term_Agenda::find($id);
            if (!$agenda) {
                return response()->json($respJson->validator('数据不存在！'));
            }
            if (count($agenda->agendaStudent) > 0) {
                return response()->json($respJson->validator('对不起此课程已经有学生选择！'));
            }

            $count = $agenda->delete();

            if ($count > 0) {
                return response()->json($respJson->succeed('删除成功'));
            }
            $respJson->setCode(1);
            $respJson->setMsg('删除失败');
            return response()->json($respJson);

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }


    public function getBindStudent(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Student::where(function ($query) use ($request) {
                $termId = $request->id;
                if (isset($termId)) {
                    $query->whereNotIn('id', Term::find($termId)->students()->pluck('student_id'));
                }
                if ($request->state) {
                    $query->where('state', $request->state);
                }
                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }
            })->orderBy('id', 'desc')->paginate($this->pageSize);
            if (isset($request->json)) {
                $respJson->setData($list);
                return response()->json($respJson);
            }

            return view('manage.term.bindStudent', compact('list'));
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }

    public function postBindStudent(Request $request)
    {
        $respJson = new RespJson();
        try {
            $termId = $request->term_id;
            if (!$termId) {
                return response()->json($respJson->errors('参数不存在'));
            }
            $term = Term::find($termId);
            if (!$term) {
                return response()->json($respJson->errors('数据不存在'));
            }
            $studentId = $request->student_id;
            if (!$studentId) {
                return response()->json($respJson->errors('参数不存在'));
            }
            $student = Student::find($studentId);
            if (!$student) {
                return response()->json($respJson->errors('参数不存在'));
            }
            $termStudent = Term_Student::firstOrCreate(['term_id' => $termId, 'student_id' => $studentId]);
            if ($termStudent) {
                return response()->json($respJson->succeed('绑定学生成功'));
            }

            return response()->json($respJson->errors('新增失败'));
        } catch (Exception $ex) {
            return response()->json($respJson->exception('异常！' . $ex->getMessage()));
        }
    }

    public function postDeleteStudent(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return response()->json($respJson->validator('参数错误'));
            }
            $student = Term_Student::find($id);
            if (!$student) {
                return response()->json($respJson->validator('数据不存在！'));
            }
            if (count($student->agendaAgenda) > 0) {
                return response()->json($respJson->validator('对不起此学生已经有选择课程！'));
            }

            $count = $student->delete();

            if ($count > 0) {
                return response()->json($respJson->succeed('删除成功'));
            }
            return response()->json($respJson->errors('删除失败'));

        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }
}
