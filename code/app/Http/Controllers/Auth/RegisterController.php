<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
// ★ 追加
use Illuminate\Http\Request;
// RegisterUser.phpから
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{

    use RegistersUsers;


    protected $redirectTo = '/';


    public function __construct()
    {
        $this->middleware('guest');
    }

    // バリデーション処理
    protected function validator(array $data)
    {
        // バリデーションエラーの場合、レスポンスは422エラーで返される
        // (バリデーションを行うデータ、バリデーションルール)
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    // 保存処理
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'state'    => 0,
        ]);
    }

    protected function registered(Request $request, $user)
    {
        return $user;
    }

    public function register(Request $request)
    {
        // バリデーション(422エラー)
        $this->validator($request->all())->validate();
        // 登録処理
        event(new Registered($user = $this->create($request->all())));
        // registeredメソッドが呼ばれ、偽(nill)だった場合redirectが実行される
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
}
