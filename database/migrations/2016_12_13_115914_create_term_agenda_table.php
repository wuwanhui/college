<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermAgendaTable extends Migration
{
    /**
     * 学期课程关联表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_agenda', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agenda_id');//课程内容
            $table->integer('term_id');//学期表
            $table->string('cycle')->nullable();//周期
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
        Schema::dropIfExists('term_agenda');
    }
}
