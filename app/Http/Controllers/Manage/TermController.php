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
            }, 'students'])->orderBy('id', 'asc')->paginate($this->pageSize);

            if (isset($request->json)) {
                return $respJson->succeed('成功', $list);
            }
            return view('manage.term.index', compact('list'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);

        }
    }

    public function getCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $term = new Term();
            return view('manage.term.create', compact('term'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
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
                return $respJson->validator('效验失败', $validator);
            }
            $term->fill($inputs);
            if ($term->save()) {
                return $respJson->succeed('成功', $term);

            }
            return $respJson->failure('新增失败');

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
            $term = Term::find($id);
            if (!$term) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }

            return view('manage.term.edit', compact('term'));
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

                return $respJson->failure('成功', $term);
            }
            return $respJson->failure('修改失败');

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
            $term = Term::where('id', $id)->withCount('agendas')->first();
            if (!$term) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            $agendas = $term->agendas()->with(['agenda' => function ($query) {
                $query->select('id', 'name', 'teacher');
            }, 'agendaStudent', 'parent' => function ($query) {
                $query->with(['agenda' => function ($query) {
                    $query->select('id', 'name', 'teacher');
                }]);
            }])->orderBy('id', 'asc')->get();

            $students = $term->students()->with(['student' => function ($query) {

            }])->orderBy('id', 'asc')->get();

            if (isset($request->json)) {
                $obj = new stdClass();
                $obj->term = $term;
                $obj->agendas = $agendas;
                $obj->students = $students;
                $respJson->setData($obj);
                return $respJson->succeed('成功', $obj);
            }

            return view('manage.term.detail', compact('term', 'agendas', 'students'));
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
            $count = Term::destroy($ids);

            if ($count > 0) {
                return $respJson->succeed('删除成功', $count);

            }

            return $respJson->failure('删除失败');


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
            $list = Term::where(function ($query) use ($request) {
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


    public function getBindAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {
            $termId = $request->id;
            $term = Term::find($termId);
            $list = Agenda::where(function ($query) use ($request, $term) {
                if (isset($term)) {
                    $query->whereNotIn('id', $term->agendas()->pluck('agenda_id'));
                }

                if ($request->state) {
                    $query->where('state', $request->state);
                }
                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }
            })->orderBy('id', 'asc')->get();
            if (isset($request->json)) {
                return $respJson->succeed('成功', $list);
            }

            $agendaList = $term->agendas()->where('parent_id', 0)->with('agenda')->get();

            return view('manage.term.bindAgenda', compact('list', 'agendaList'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function postBindAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {
            $parentId = $request->parent_id;
            $agendaId = $request->agenda_id;
            if (!$agendaId) {
                return $respJson->validator('请选择课程');
            }

            $termId = $request->term_id;
            if (!$termId) {
                return $respJson->validator('参数错误');
            }

            $cycle = $request->cycle;
            if (!$cycle) {
                return $respJson->validator('请选择开课周期');
            }
            $state = $request->state;
            if (!$state) {
                return $respJson->validator('请选择课程状态');
            }
            $term = Term::find($termId);
            if (!$term) {
                return $respJson->errors('数据不存在!');
            }

            $termAgenda = Term_Agenda::firstOrCreate(['term_id' => $termId, 'agenda_id' => $agendaId, 'parent_id' => $parentId, 'cycle' => $cycle, 'state' => $state]);

            if ($termAgenda) {
                return $respJson->succeed('绑定课程成功', $termAgenda);
            }

            return $respJson->failure('绑定失败');
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function getEditAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $termAgenda = Term_Agenda::where('id', $id)->with('agenda')->first();
            $term = $termAgenda->term;

            $agendaList = $term->agendas()->where('parent_id', 0)->where('agenda_id', '!=', $termAgenda->agenda_id)->with('agenda')->get();

            return view('manage.term.editAgenda', compact('agendaList', 'termAgenda'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function postEditAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            $termAgenda = Term_Agenda::find($id);
            if (!$termAgenda) {
                return $respJson->validator('数据不存在');
            }
            $termAgenda->fill($request->all());
            if ($termAgenda->save()) {
                return $respJson->succeed('成功', $termAgenda);
            }

            return $respJson->failure('修改失败');
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function postDeleteAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return $respJson->validator('参数错误');
            }
            $agenda = Term_Agenda::find($id);
            if (!$agenda) {
                return $respJson->validator('数据不存在！');
            }
            if (count($agenda->agendaStudent) > 0) {
                return $respJson->validator('对不起此课程已经有学生选择！');
            }

            $count = $agenda->delete();

            if ($count > 0) {
                return $respJson->succeed('删除成功', $count);
            }
            return $respJson->failure('删除失败');


        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function getBindStudent(Request $request)
    {
        $respJson = new RespJson();
        $termId = $request->id;
        $term = Term::find($termId);
        try {
            $list = Student::where(function ($query) use ($request, $term) {

                if (isset($term)) {
                    $query->whereNotIn('id', $term->students()->pluck('student_id'));
                }

                if ($request->state) {
                    $query->where('state', $request->state);
                }
                if ($request->key) {
                    $query->orWhere('name', 'like', '%' . $request->key . '%');
                }

            })->orderBy('id', 'asc')->orderBy('id', 'asc')->paginate($this->pageSize);
            if (isset($request->json)) {
                return $respJson->succeed('成功', $list);
            }

            return view('manage.term.bindStudent', compact('list'));
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function postBindStudent(Request $request)
    {
        $respJson = new RespJson();
        try {
            $termId = $request->term_id;
            if (!$termId) {
                return $respJson->errors('参数不存在');
            }
            $term = Term::find($termId);
            if (!$term) {
                return $respJson->errors('数据不存在');
            }
            $studentId = $request->student_id;
            if (!$studentId) {
                return $respJson->errors('参数不存在');
            }
            $student = Student::find($studentId);
            if (!$student) {
                return $respJson->errors('参数不存在');
            }
            $termStudent = Term_Student::firstOrCreate(['term_id' => $termId, 'student_id' => $studentId]);
            if ($termStudent) {
                return $respJson->succeed('绑定学生成功');
            }

            return $respJson->errors('新增失败');
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }

    public function postDeleteStudent(Request $request)
    {
        $respJson = new RespJson();
        try {
            $id = $request->id;
            if (!$id) {
                return $respJson->validator('参数错误');
            }
            $student = Term_Student::find($id);
            if (!$student) {
                return $respJson->validator('数据不存在！');
            }
            if (count($student->agendaAgenda) > 0) {
                return $respJson->validator('对不起此学生已经有选择课程！');
            }

            $count = $student->delete();

            if ($count > 0) {
                return $respJson->succeed('删除成功');
            }
            return $respJson->errors('删除失败');

        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function postStudent(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Student::where(function ($query) use ($request) {
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }

                if (isset($request->key)) {
                    $query->Where('name', 'like', '%' . $request->key . '%');
                }
            })->orderBy('id', 'asc')->paginate($this->pageSize);
            return $respJson->succeed('成功', $list);
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }


    public function postAgenda(Request $request)
    {
        $respJson = new RespJson();
        try {
            $list = Agenda::where(function ($query) use ($request) {
                if (isset($request->state) && $request->state != -1) {
                    $query->where('state', $request->state);
                }

                if (isset($request->key)) {
                    $query->Where('name', 'like', '%' . $request->key . '%');
                }
            })->orderBy('id', 'asc')->paginate($this->pageSize);
            return $respJson->succeed('成功', $list);
        } catch (Exception $ex) {
            return $respJson->exception($ex);
        }
    }
}
