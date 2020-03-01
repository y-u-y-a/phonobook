<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authを使うため
use App\User;


class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;
    }


    public function getLoginUser()
    {
        if(Auth::check()){
        $user = Auth::User();
        return $user;
        }else{
        return null;
        }
    }


    /* 出勤・退勤処理 */
    public function switchState(Request $request){

        $user = User::find($request->user_id);

        if($user->state == 0){
            $user->state = 1;
        }else{
            $user->state = 0;
        }
            $user->save();
    }
}
