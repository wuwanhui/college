<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{
    /**
     * 学生管理
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('classes_id')->default(0);//所在班级
            $table->string('name');//姓名
            $table->string('number')->unique();//学号
            $table->string('email')->unique();//邮箱
            $table->string('password')->default('000000');
            $table->integer('sex')->default(0);//性别
            $table->string('phone')->nullable();//手机号
            $table->integer('user_id')->default(0);//创建者
            $table->integer('state')->default(0);//状态
            $table->integer('sort')->default(0);//排序
            $table->text('remark')->nullable();//备注
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('students');
    }
}
