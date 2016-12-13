<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermStudentTable extends Migration
{
    /**
     * 学期学生关联表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');//学生
            $table->integer('term_id');//学期表
            $table->integer('user_id')->default(0);//创建者
            $table->integer('state')->default(0);//状态
            $table->integer('sort')->default(0);//排序
            $table->text('remark')->nullable();//备注
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('term_students');
    }
}
