<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Common\RespJson;

use App\Models\Syllabus;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
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
            }])->orderBy('id', 'asc')->paginate($this->pageSize);


            $agendaList = $term->agendas()->with(['agenda' => function ($query) {
            }, 'agendaStudent'])->orderBy('id', 'asc')->paginate($this->pageSize);

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
            if (count(Syllabus::where('id', '!=', $id)->where('agenda_id', $request->agenda_id)->get()) > 0) {
                return $respJson->validator('对不起，此课程已经选择过，请重新选择！');
            }

            $syllabus->fill($request->all());
            if ($syllabus->save()) {
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
            Syllabus::where('agenda_id', $agendaId)->where('state', '!=', 2)->update(['state' => 1]);
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
