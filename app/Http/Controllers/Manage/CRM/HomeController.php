<?php

namespace App\Http\Controllers\Manage\CRM;

use App\Http\Controllers\Manage\BaseController;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        view()->share(['_model' => 'manage/user']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manage.crm.home');
    }
}
