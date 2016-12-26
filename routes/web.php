<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@welcome');
Route::get('/home', 'HomeController@index');

Route::any('/install', 'Common\InstallController@index');

Route::group(['prefix' => 'common'], function () {
    Route::get('/error', function () {
        return view('common.errors');
    })->name('error');
    Route::get('/alert', function () {
        return view('common.alert');
    })->name('alert');
});
/**
 * 学生
 */
Route::group(['prefix' => 'student', 'namespace' => 'Student'], function () {
    Auth::routes();

    Route::get('/', 'HomeController@index');


    Route::group(['prefix' => 'syllabus', 'middleware' => 'auth.student'], function () {

        Route::post('/add', 'HomeController@addSyllabus');
        Route::post('/delete', 'HomeController@deleteSyllabus');

    });

    Route::group(['prefix' => 'agenda', 'middleware' => 'auth.student'], function () {

        Route::get('/detail', 'HomeController@agendaDetail');

    });
    Route::group(['prefix' => 'user', 'middleware' => 'auth.student'], function () {

        Route::post('/edit', 'HomeController@postEdit');


    });

});

/**
 * 教师
 */
Route::group(['prefix' => 'teacher', 'namespace' => 'Teacher'], function () {
    Auth::routes();

    Route::get('/', 'HomeController@index');

    Route::group(['prefix' => 'system', 'namespace' => 'System', 'middleware' => 'auth.admin'], function () {

        /**
         * 系统参数
         */
        Route::group(['prefix' => 'config', 'middleware' => 'auth.admin'], function () {
            Route::any('/', 'ConfigController@index');
        });
        /**
         * 全局参数
         */
        Route::group(['prefix' => 'maps', 'middleware' => 'auth.admin'], function () {
            Route::any('/', 'MapsController@index');
            Route::any('/create', 'MapsController@create');
            Route::any('/edit', 'MapsController@edit');
            Route::post('/delete', 'MapsController@delete');
        });

        /**
         * 区域管理
         */
        Route::group(['prefix' => 'area', 'middleware' => 'auth.admin'], function () {
            Route::get('/', 'AreaController@index');
            Route::any('/create', 'AreaController@create');
            Route::any('/edit', 'AreaController@edit');
            Route::post('/delete', 'AreaController@delete');

        });
        /**
         * 企业管理
         */
        Route::group(['prefix' => 'enterprise', 'middleware' => 'auth.admin'], function () {
            Route::any('/', 'EnterpriseController@index');
        });


        /**
         * 部门管理
         */
        Route::group(['prefix' => 'dept', 'middleware' => 'auth.admin'], function () {
            Route::get('/', 'DeptController@index');
            Route::any('/create', 'DeptController@create');
            Route::any('/edit', 'DeptController@edit');
            Route::post('/delete', 'DeptController@delete');

        });
        /**
         * 用户用户
         */
        Route::group(['prefix' => 'user', 'middleware' => 'auth.admin'], function () {
            Route::any('/', 'UserController@index');
            Route::any('/create', 'UserController@create');
            Route::any('/edit', 'UserController@edit');
            Route::get('/delete', 'UserController@delete');
            Route::any('/addrole', 'UserController@addRole');

        });
        /**
         * 权限定义
         */
        Route::group(['prefix' => 'permission', 'middleware' => 'auth.admin'], function () {
            Route::get('/', 'PermissionController@index');
            Route::any('/create', 'PermissionController@create');
            Route::any('/edit/{id}', 'PermissionController@edit');
            Route::get('/delete', 'PermissionController@delete');

        });
        /**
         * 角色
         */
        Route::group(['prefix' => 'role', 'middleware' => 'auth.admin'], function () {
            Route::get('/', 'RoleController@index');
            Route::get('/create', 'RoleController@getCreate');
            Route::post('/create', 'RoleController@postCreate');
            Route::get('/edit', 'RoleController@getEdit');
            Route::post('/edit', 'RoleController@postEdit');
            Route::post('/delete', 'RoleController@delete');

        });


        /**
         * 基础数据
         */
        Route::group(['prefix' => 'basedata', 'middleware' => 'auth.admin'], function () {
            Route::get('/', 'BaseDataController@index');
            Route::post('/create', 'BaseDataController@create');
            Route::any('/edit/{id}', 'BaseDataController@edit');
            Route::get('/delete', 'BaseDataController@delete');

            Route::any('/type', 'BaseDataController@type');

        });

    });


});

/**
 * 管理后台
 */
Route::group(['prefix' => 'manage', 'namespace' => 'Manage'], function () {
    Auth::routes();


    Route::post('/clear/cache', 'HomeController@postClearCache');

    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@home');


    /**
     * excel
     */
    Route::group(['prefix' => 'excel', 'middleware' => 'auth.manage'], function () {
        Route::get('/export', 'ExcelController@export');
        Route::get('/import', 'ExcelController@import');
    });

    /**
     * 系统参数
     */
    Route::group(['prefix' => 'config', 'middleware' => 'auth.manage'], function () {
        Route::any('/', 'ConfigController@index');
    });
    /**
     * 用户管理
     */
    Route::group(['prefix' => 'user', 'middleware' => 'auth.manage'], function () {
        Route::get('/', 'UserController@index');
        Route::get('/create', 'UserController@getCreate');
        Route::post('/create', 'UserController@postCreate');
        Route::get('/edit', 'UserController@getEdit');
        Route::post('/edit', 'UserController@postEdit');
        Route::post('/delete', 'UserController@delete');
        Route::get('/api/list', 'UserController@getList');

    });

    /**
     * 学期管理
     */
    Route::group(['prefix' => 'term', 'middleware' => 'auth.manage'], function () {
        Route::get('/', 'TermController@index');
        Route::get('/create', 'TermController@getCreate');
        Route::post('/create', 'TermController@postCreate');
        Route::get('/edit', 'TermController@getEdit');
        Route::post('/edit', 'TermController@postEdit');
        Route::get('/detail', 'TermController@getDetail');
        Route::post('/delete', 'TermController@delete');
        Route::get('/api/list', 'TermController@getList');

        Route::get('/bind/agenda', 'TermController@getBindAgenda');
        Route::post('/bind/agenda', 'TermController@postBindAgenda');
        Route::get('/edit/agenda', 'TermController@getEditAgenda');
        Route::post('/edit/agenda', 'TermController@postEditAgenda');
        Route::post('/delete/agenda', 'TermController@postDeleteAgenda');


        Route::get('/bind/student', 'TermController@getBindStudent');
        Route::post('/bind/student', 'TermController@postBindStudent');
        Route::post('/delete/student', 'TermController@postDeleteStudent');

        Route::post('/student', 'TermController@postStudent');
        Route::post('/agenda', 'TermController@postAgenda');

    });
    /**
     * 课程管理
     */
    Route::group(['prefix' => 'agenda', 'middleware' => 'auth.manage'], function () {
        Route::get('/', 'AgendaController@index');
        Route::get('/create', 'AgendaController@getCreate');
        Route::post('/create', 'AgendaController@postCreate');
        Route::get('/edit', 'AgendaController@getEdit');
        Route::post('/edit', 'AgendaController@postEdit');
        Route::post('/delete', 'AgendaController@delete');
        Route::post('/upload', 'AgendaController@postUpload');
        Route::get('/api/list', 'AgendaController@getList');

    });
    /**
     * 教师管理
     */
    Route::group(['prefix' => 'teacher', 'middleware' => 'auth.manage'], function () {
        Route::get('/', 'TeacherController@index');
        Route::get('/create', 'TeacherController@getCreate');
        Route::post('/create', 'TeacherController@postCreate');
        Route::get('/edit', 'TeacherController@getEdit');
        Route::post('/edit', 'TeacherController@postEdit');
        Route::post('/delete', 'TeacherController@delete');
        Route::get('/api/list', 'TeacherController@getList');

    });
    /**
     * 学生管理
     */
    Route::group(['prefix' => 'student', 'middleware' => 'auth.manage'], function () {
        Route::get('/', 'StudentController@index');
        Route::get('/create', 'StudentController@getCreate');
        Route::post('/create', 'StudentController@postCreate');
        Route::get('/edit', 'StudentController@getEdit');
        Route::post('/edit', 'StudentController@postEdit');
        Route::post('/delete', 'StudentController@delete');
        Route::get('/api/list', 'StudentController@getList');

    });
    /**
     * 选课记录
     */
    Route::group(['prefix' => 'syllabus', 'middleware' => 'auth.manage'], function () {
        Route::get('/', 'SyllabusController@index');
        Route::get('/create', 'SyllabusController@getCreate');
        Route::post('/create', 'SyllabusController@postCreate');
        Route::get('/edit', 'SyllabusController@getEdit');
        Route::post('/edit', 'SyllabusController@postEdit');
        Route::post('/delete', 'SyllabusController@delete');
        Route::post('/random', 'SyllabusController@postRandom');
        Route::post('/mail', 'SyllabusController@postMail');
        Route::get('/report', 'SyllabusController@getReport');
        Route::post('/excel/export','SyllabusController@postExport');

        Route::get('/api/list', 'SyllabusController@getList');

    });


});
