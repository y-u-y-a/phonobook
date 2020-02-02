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


  /* 顔画像で認証処理(ユーザー or null) */
  public function authWithFace(Request $request)
  {
    // ①セッションを初期化
    $ch = curl_init();

    // 変数宣言
    $api_url  = "https://gateway.watsonplatform.net/visual-recognition/api/v3/classify";
    $version  = "?version=2018-03-19";
    $lang     = "&accept-language=ja";
    $api_key  = "Q19CJ35wymBPIb0qV31ZJNTGDl3EjnytVqKhI2GCNl64";
    $model_id = "User_1794756412";

    $url      = $api_url.$version.$lang;

    // 取得したbase64を画像データにデコードする
    $fileData     = base64_decode($request->faceImage);
    // ファイルの生成
    $fileName = "capture.jpeg";
    // データをファイルに書き込み処理
    file_put_contents($fileName, $fileData);

    // namespaceの関係でバックスラッシュ\を入れる
    $params   = array(
      "images_file"    => new \CURLFile($fileName, mime_content_type($fileName),basename($fileName)),
      "classifier_ids" => $model_id
    );

    // ②オプションを設定
    curl_setopt_array($ch, [
      CURLOPT_USERPWD        => "apikey:".$api_key, // 認証
      CURLOPT_URL            => $url,
      CURLOPT_HTTPHEADER     => array("Content-Type: multipart/form-data"),
      CURLOPT_POST           => true,
      CURLOPT_RETURNTRANSFER => true,  // curl_execの実行結果を文字列で返す
      CURLOPT_SSL_VERIFYPEER => false, // サーバー証明書の検証を行わない
      CURLOPT_POSTFIELDS     => $params,
      // CURLOPT_VERBOSE        => true
    ]);

    // ③転送を実行し、返り値を取得
    $vrExec = curl_exec($ch);

    if (curl_errno($ch)){
     return "Error:" . curl_error($ch);
    }else{
      $decode = json_decode($vrExec,true);
    }

    // ④セッションを終了する
    curl_close($ch);

    // ⑤ユーザーの検索
    // VRから必要なデータのみを抽出
    $getModel = $decode["images"][0]["classifiers"][0]["classes"][0];
    $getName  = $getModel["class"];
    $getScore = $getModel["score"];

    $getNumOfUsers = User::whereName($getName)->count();
    $getUser     = User::whereName($getName)->get();

    // DBにユーザーが存在しない場合
    if($getNumOfUsers == 0){
      return null;
    }else{
      // スコアが0.90以上の場合
      if($getScore >= 0.85){
        return $getUser[0];
      }else{
        return null;
      }
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
