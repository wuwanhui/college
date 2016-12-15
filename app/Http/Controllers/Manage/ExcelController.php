<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Manage\BaseController;
use App\Jobs\SyllabusChangeJob;
use App\Jobs\SendSyllabusChangeEmail;
use App\Jobs\SendIntegralEmail;
use App\Models\Student;
use App\Models\Student_Agenda;
use App\Models\Syllabus;
use App\Models\Term;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/syllabus']);
    }

    //Excel文件导出功能 By Laravel学院
    public function export()
    {
        $cellData = [
            ['学号', '姓名', '成绩'],
            ['10001', 'AAAAA', '99'],
            ['10002', 'BBBBB', '92'],
            ['10003', 'CCCCC', '95'],
            ['10004', 'DDDDD', '89'],
            ['10005', 'EEEEE', '96'],
        ];
        Excel::create('学生成绩', function ($excel) use ($cellData) {
            $excel->sheet('score', function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }


    //Excel文件导入功能 By Laravel学院
    public function import()
    {
        $filePath = 'storage/exports/agenda.xls';
        Excel::load($filePath, function ($reader) {
            $data = $reader->all();
            dd($data);
        });
    }

}
