<?php

use Illuminate\Http\Request;


// 全ての本を返す
Route::get("/books/all", "BooksController@index");
// 借りている本を返す
Route::get("/books/borrowed", "BooksController@getBooksBorrowed");
// idから本を返す
Route::get("/books/{id}", "BooksController@show");
// 返却処理
Route::get("/books/return/{id}", "BooksController@return")->name("return");
// 貸出処理(ログインユーザー)
Route::get("/books/lend/{id}", "BooksController@lend")->name("lend");
// 貸出処理(顔認証)
Route::get("/books/{book_isbn}/borrow/{user_id}", "BooksController@borrow")->name("borrow");
// VRでバーコード画像からISBNのテキストを返す
// Route::post("/books/barcode", "BooksController@getISBN");
// 登録処理
Route::post("/books", "BooksController@store");
// 更新処理
Route::patch("/books", "BooksController@update");
// 削除処理
Route::delete("/books", "BooksController@destroy");


// 全てのユーザーを返す
Route::get("/users/all", "UsersController@index");
// ログインユーザーを返す
Route::get("/users/logined", "UsersController@getLoginUser");
// VRによる顔認証処理(or null)
Route::post("/users/authFace", "UsersController@authWithFace");
// 出勤・退勤処理
Route::post("/users/state", "UsersController@switchState");

// 新規登録処理
Route::post("/auth/register", "Auth\RegisterController@register")->name("register");
// ログイン処理
Route::post("/login", "Auth\LoginController@login")->name("login");
// ログアウト処理
Route::post("/logout", "Auth\LoginController@logout")->name("logout");
