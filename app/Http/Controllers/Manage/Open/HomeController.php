<?php

namespace App\Http\Controllers\Manage\Open;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Manage\BaseController;
use Illuminate\Http\Request;

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
        return view('manage.open.home');
    }
}
