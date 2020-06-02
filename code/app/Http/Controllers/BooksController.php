<?php

namespace App\Http\Controllers;

// use宣言：このファイル内で使用するクラスを宣言する
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Authを使うため
use App\Book;
use App\User;
use Validator;



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
    public function getBorrowedBooks(Request $request)
    {
        $borrowed_books = Book::where("user_id", $request->user_id)->get();
        return $borrowed_books;
    }


    /* 返却処理 */
    public function return(Request $request)
    {
        $book = Book::find($request->id);
        $book->state = 0;
        $book->user_id = null;
        // きちんとセーブ
        $book->save();

        return $book;
    }


    /* 貸出処理 */
    public function borrow(Request $request)
    {
        // ISBNで本を検索
        $book = Book::where("isbn", $request->book_isbn)->first();

        if(!$book){
            return "ng";
        }
        $book = Book::find($book->id);
        $user = User::find($request->user_id);
        $book->state = 1;
        $book->user_id = $user->id;
        $book->save();
        return "ok";
    }


    /* 登録処理 */
    public function new(Request $request)
    {

        $book = new Book;
        $validation_result = $book->validate($request->all());

        // 失敗(成功はpasses関数)
        if($validation_result->fails()){
            // return json_encode($validation_result->messages());
            return response()->json([
                "errors" => $validation_result->messages()
            ]);
        }

        $book->isbn = $request->isbn;
        $book->title = $request->title;
        $book->volume = $request->volume;
        $book->series = $request->series;
        $book->publisher = $request->publisher;
        $book->pubdate = $request->pubdate;
        $book->cover = $request->cover;
        $book->author = $request->author;
        $book->detail = $request->detail;
        $book->state = 0;
        $book->save();
        return;
    }


    /* 更新処理 */
    public function update(Request $request)
    {
        $book = Book::find($request->id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->volume = $request->volume;
        $book->series = $request->series;
        $book->publisher = $request->publisher;
        $book->pubdate = $request->pubdate;
        $book->detail = $request->detail;
        $book->state = $request->state;

        $book->save();
        return $book;
    }


    /* 削除処理 */
    public function destroy(Request $request)
    {
        $book = Book::find($request->id);
        $book->delete();
    }
}

