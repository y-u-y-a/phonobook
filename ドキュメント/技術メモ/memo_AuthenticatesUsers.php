<?php
// vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;


    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        // バリデーション
        $this->validateLogin($request);

        // ログイン回数のチェック
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // ログイン処理
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // ログイン試行を増やす
        $this->incrementLoginAttempts($request);

        // ログイン失敗のレスポンス
        return $this->sendFailedLoginResponse($request);
    }


    // バリデーション
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
        // 例：
        // $user = new User;
        // $validation_result = $user->validate($request->all());
    }


    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }


    // 認証データを指定
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }


    // 成功した場合の処理
    protected function sendLoginResponse(Request $request)
    {
        // セッション再生成(SessionIDとToken)
        $request->session()->regenerate();

        // キャッシュに保存されているログイン回数をクリア
        $this->clearLoginAttempts($request);

        // authenticated=認証済み後の処理
        // authenticated()は中身がからのメソッドなので(=false) :以下のredirect()~が実行される
        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }


    // オーバーライドする場合に使用
    protected function authenticated(Request $request, $user)
    {
        //
    }

    // 失敗した場合の処理
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }


    public function username()
    {
        return 'email';
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }


    protected function loggedOut(Request $request)
    {
        //
    }


    protected function guard()
    {
        return Auth::guard();
    }
}
