<?php

namespace App\Http\Controllers;

// use宣言：このファイル内で使用するクラスを宣言する
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authを使うため
use App\Book;
use App\User;



class BooksController extends Controller
{

    /* 全ての本を返す */
    public function index()
    {
      $books = Book::all();
      return $books;
    }


    /* 本を返す */
    public function show(Request $request)
    {
      $book = Book::find($request->id);
      return $book;
    }


    /* 借りている本を返す */
    public function getBooksBorrowed()
    {
      if(Auth::check()){
        $user = Auth::User();
        $books = Book::where("user_id", $user->id)->get();
        return $books;
      }
    }


    /* 返却処理 */
    public function return(Request $request)
    {
      $book = Book::find($request->id);
      $book->state   = 0;
      $book->user_id = null;
      // きちんとセーブ
      $book->save();

      return $book;
    }


    /* 貸出処理(ログインユーザー) */
    public function lend(Request $request)
    {
      if(Auth::check()){
        // ログインユーザーの取得
        $user = Auth::user();
        $book = Book::find($request->id);
        $book->state   = 1;
        $book->user_id = $user->id;
        // きちんとセーブ
        $book->save();
        return "貸出し登録が完了しました！";
      }else{
        return null;
      }
    }


    /* 貸出処理(顔認証) */
    public function borrow(Request $request)
    {
      // ISBNで本を検索
      $book = Book::where("isbn", $request->book_isbn)->first();
      $book = Book::find($book->id);
      $user = User::find($request->user_id);
      $book->state   = 1;
      $book->user_id = $user->id;
      $book->save();
      return "貸出し登録が完了しました！";
    }


  /* バーコード画像からISBNを返す */
  public function getISBN(Request $request)
  {
    // ①セッションを初期化
    $ch = curl_init();

    // 変数宣言
    $api_url  = "https://gateway.watsonplatform.net/visual-recognition/api/v3/recognize_text";
    $version  = "?version=2018-03-19";
    $lang     = "&accept-language=ja";
    $api_key  = "Q19CJ35wymBPIb0qV31ZJNTGDl3EjnytVqKhI2GCNl64";
    $model_id = "User_1794756412";

    $url      = $api_url.$version.$lang;

    // 取得したbase64を画像データにデコードする
    $fileData     = base64_decode($request->captureImage);
    // ファイルの生成
    $fileName = "isbn.jpeg";
    // データをファイルに書き込み処理
    file_put_contents($fileName, $fileData);

    // namespaceの関係でバックスラッシュ\を入れる
    $params   = array(
      "images_file"    => new \CURLFile($fileName, mime_content_type($fileName),basename($fileName)),
      "classifier_ids" => "default"
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

    return $decode;

    // ④セッションを終了する
    curl_close($ch);

    $getISBN = $decode["images"][0]["text"];
    return $getISBN;
  }


    /* 登録処理 */
    public function store(Request $request)
    {
      $book            = new Book;
      $book->isbn      = $request->isbn;
      $book->title     = $request->title;
      $book->author    = $request->author;
      $book->volume    = $request->volume;
      $book->series    = $request->series;
      $book->publisher = $request->publisher;
      $book->pubdate   = $request->pubdate;
      $book->detail    = $request->detail;
      $book->cover     = $request->cover;
      $book->state     = 0;
      $book->save();
      return $book;
    }


    /* 更新処理 */
    public function update(Request $request)
    {
      // $form = $request->all();
      // unset($form["_token"]);
      // 送信された"_tokenはテーブルのカラムに無いので削除しておく"
      $book         = Book::find($request->id);
      $book->title  = $request->title;
      $book->author = $request->author;
      $book->status = $request->status;
      $book->save();
    }


    /* 削除処理 */
    public function destroy(Request $request)
    {
      $book = Book::find($request->id);
      $book->delete();
    }
}

