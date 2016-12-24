<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Common\RespJson;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/student';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:student', ['except' => [
            'logout',
            'redirectToLogin',
        ]]);
    }

    public function showLoginForm()
    {
        return view('student.auth.login');
    }


//    public function redirectToLogin()
//    {
//        if ($this->guard('student')->user()) {
//            return redirect('/student/');
//        }
//
//        return redirect('/student/login');
//    }

    protected function guard()
    {
        return auth()->guard('student');
    }

    public function logout(Request $request)
    {
        $respJson = new RespJson();
        try {
            Auth::logout();
            $this->guard('student')->logout();
            return response()->json($respJson);
        } catch (Exception $ex) {
            $respJson->setCode(-1);
            $respJson->setMsg('异常！' . $ex->getMessage());
            return response()->json($respJson);
        }
    }
}
