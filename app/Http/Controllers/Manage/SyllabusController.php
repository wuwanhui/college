<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Common\RespJson;

use App\Models\Syllabus;
use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
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

            $studentList = Syllabus::with(['studentRelate' => function ($query) {
                $query->with('student');
            }, 'agendaRelate' => function ($query) {
                $query->with('agenda');
                // $query->with('teacher');
            }])->orderBy('id', 'desc')->paginate($this->pageSize);


            $agendaList = $term->agendas()->with(['agenda' => function ($query) {
                $query->with('teacher');
            }, 'agendaStudent'])->orderBy('id', 'desc')->paginate($this->pageSize);

//            $studentList = $term->syllabus()->with(['term' => function ($query) {
//                $query->select('id', 'name');
//            }, 'student' => function ($query) {
//                $query->select('id', 'name');
//            }, 'agenda' => function ($query) {
//                $query->select('id', 'name');
//            }])->orderBy('id', 'desc')->paginate($this->pageSize);


            if (isset($request->json)) {
                $obj = new stdClass();
                $obj->studentList = $studentList;
                $obj->agendaList = $agendaList;
                $respJson->setData($obj);
                return response()->json($respJson);
            }
            $terms = Term::with(['students', 'agendas' => function ($query) {
                // $query->where('parent_id', 0);
            }])->get();
            return view('manage.syllabus.index', compact('studentList', 'agendaList', 'terms','term'));
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
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }


    }

    public function postCreate(Request $request)
    {
        $respJson = new RespJson();
        try {
            $state = $request->state;
            $termId = $request->term_id;
            if (!$termId) {

                return response()->json($respJson->validator('未找到学期参数'));
            }
            $studentId = $request->student_id;
            if (!$studentId) {
                return response()->json($respJson->validator('未找到学生参数'));

            }

            $agendaId = $request->agenda_id;
            if (!$agendaId) {
                return response()->json($respJson->validator('未找到课程参数'));
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

            $syllabus = Syllabus::where('term_id', $termId)->whereAnd('student_id', $studentId)->get();

            if (count($syllabus) == 4) {
                return response()->json($respJson->errors('选课失败，此学生课程已经超限'));
            }
            $syllabusItem = Syllabus::firstOrCreate(['term_id' => $termId, 'student_id' => $studentId, 'agenda_id' => $agendaId, 'state' => $state]);

            if ($syllabusItem) {
                $respJson->setData($syllabusItem);
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

            return view('manage.syllabus.edit', compact('syllabus'));
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
            $syllabus = Syllabus::find($id);
            if (!$syllabus) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            $syllabus->fill($request->all());
            if ($syllabus->save()) {

//                $job =new SyllabusChangeJob($syllabus);
//                $job->onQueue('emails') ->delay(Carbon::now()->addMinutes(1));
//
//                dispatch($job);
                $respJson->setData($syllabus);
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
            $syllabus = Syllabus::find($id);
            if (!$syllabus) {
                return Redirect::route('alert')->withErrors('数据不存在！');
            }
            if ($request->isMethod('POST')) {

                $syllabus->fill($request->all());
                $syllabus->save();
                if ($syllabus) {
                    $respJson->setData($syllabus);
                    return response()->json($respJson);
                }
                $respJson->setMsg("修改失败");
                return response()->json($respJson);
            }
            return view('manage.syllabus.detail', compact('syllabus'));
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
            $count = Syllabus::destroy($ids);

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
            $list = Syllabus::where(function ($query) use ($request) {
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

}
