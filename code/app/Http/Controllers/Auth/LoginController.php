<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// ★ 追加
use Illuminate\Http\Request;

class LoginController extends Controller
{

    use AuthenticatesUsers;


    protected $redirectTo = '/';


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    // 追加部分 ログイン
    protected function authenticated(Request $request, $user)
    {
        return $user;
    }

    // 追加部分 ログアウト
    protected function loggedOut(Request $request)
    {
        // セッションを再生成する
        $request->session()->regenerate();
        return response()->json();
    }

}
