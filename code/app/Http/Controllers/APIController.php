<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class APIController extends Controller
{

    /**
     * 顔画像データを使ってVRAPIと通信
     * 取得できた場合は, userを返す
     * できなかった場合は, nullを返す
     *
     * @param int face_image
     * @return user|null
     */
    public function authFaceWithVR(Request $request)
    {
        // ①セッションを初期化
        $ch = curl_init();

        $api_url = "https://gateway.watsonplatform.net/visual-recognition/api/v3/classify";
        $version = "?version=2018-03-19";
        $lang = "&accept-language=ja";
        $api_key = env("VISUAL_RECOGNITION_SECRET_KEY");
        $model_id = env("MODEL_ID");

        $url = $api_url.$version.$lang;

        // 取得したbase64を画像データにデコード
        $file_data = base64_decode($request->face_image);
        // ファイルの生成
        $file_name = "capture.jpeg";
        // データをファイルに書き込み処理
        file_put_contents($file_name, $file_data);

        // バックスラッシュ
        $params = array(
        "images_file" => new \CURLFile($file_name, mime_content_type($file_name),basename($file_name)),
        "classifier_ids" => $model_id
        );

        // ②オプションを設定
        curl_setopt_array($ch, [
        CURLOPT_USERPWD => "apikey:".$api_key, // 認証
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => array("Content-Type: multipart/form-data"),
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,  // curl_execの実行結果を文字列で返す
        CURLOPT_SSL_VERIFYPEER => false, // サーバー証明書の検証を行わない
        CURLOPT_POSTFIELDS => $params,
        // CURLOPT_VERBOSE => true
        ]);

        // ③転送を実行し、返り値を取得
        $vr_exec = curl_exec($ch);

        if (curl_errno($ch)){
            return "Error:".curl_error($ch);
        }
        else{
            $decode = json_decode($vr_exec,true);
        }

        // ④セッションを終了
        curl_close($ch);

        // ⑤ユーザーの検索
        // VRから必要なデータのみを抽出
        $get_model = $decode["images"][0]["classifiers"][0]["classes"][0];
        $get_name = $get_model["class"];
        $get_score = $get_model["score"];

        // 取得したnameでDBを検索
        $get_num_of_users = User::whereName($get_name)->count();
        $get_user = User::whereName($get_name)->get();

        // DBに存在かつスコアが0.85以上で取得
        if($get_num_of_users != 0 && $get_score >= 0){

            return $get_user[0];
        }else{
            return null;
        }
    }


    // /* QRコードから文字列を取得 */
    // public function getISBN(Request $request)
    // {
    //     // ①セッションを初期化
    //     $ch = curl_init();

    //     // 変数宣言
    //     $api_url = "https://gateway.watsonplatform.net/visual-recognition/api/v3/recognize_text";
    //     $version = "?version=2018-03-19";
    //     $lang = "&accept-language=ja";
    //     $api_key = VISUAL_RECOGNITION_SECRET_KEY;
    //     $model_id = MODEL_ID;

    //     $url = $api_url.$version.$lang;

    //     // 取得したbase64を画像データにデコードする
    //     $file_data = base64_decode($request->captureImage);
    //     // ファイルの生成
    //     $file_name = "isbn.jpeg";
    //     // データをファイルに書き込み処理
    //     file_put_contents($file_name, $file_data);

    //     // namespaceの関係でバックスラッシュ\を入れる
    //     $params   = array(
    //     "images_file" => new \CURLFile($file_name, mime_content_type($file_name),basename($file_name)),
    //     "classifier_ids" => "default"
    //     );

    //     // ②オプションを設定
    //     curl_setopt_array($ch, [
    //     CURLOPT_USERPWD => "apikey:".$api_key, // 認証
    //     CURLOPT_URL => $url,
    //     CURLOPT_HTTPHEADER => array("Content-Type: multipart/form-data"),
    //     CURLOPT_POST => true,
    //     CURLOPT_RETURNTRANSFER => true,  // curl_execの実行結果を文字列で返す
    //     CURLOPT_SSL_VERIFYPEER => false, // サーバー証明書の検証を行わない
    //     CURLOPT_POSTFIELDS => $params,
    //     // CURLOPT_VERBOSE => true
    //     ]);


    //     // ③転送を実行し、返り値を取得
    //     $vr_exec = curl_exec($ch);

    //     if (curl_errno($ch)){
    //     return "Error:".curl_error($ch);
    //     }else{
    //     $decode = json_decode($vr_exec,true);
    //     }

    //     return $decode;

    //     // ④セッションを終了する
    //     curl_close($ch);

    //     $getISBN = $decode["images"][0]["text"];
    //     return $getISBN;
    // }
}
