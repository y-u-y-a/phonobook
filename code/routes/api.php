<?php

use Illuminate\Http\Request;


Route::get("/books/all", "BooksController@index")->name("get.all_books");
Route::get("/books/borrowed", "BooksController@getBooksBorrowed")->name("get.borrowed_books");
Route::get("/books/{id}", "BooksController@show")->name("get.book");
Route::get("/books/return/{id}", "BooksController@return")->name("return.book");
// 貸出処理(ログインユーザー)
Route::get("/books/lend/{id}", "BooksController@lend")->name("lend.book");
// 貸出処理(顔認証)
Route::get("/books/{book_isbn}/borrow/{user_id}", "BooksController@borrow")->name("borrow.book");
// VRでバーコード画像からISBNのテキストを返す
// Route::post("/books/barcode", "BooksController@getISBN");
Route::post("/books", "BooksController@store")->name("store.book");
Route::patch("/books", "BooksController@update")->name("update.book");
Route::delete("/books", "BooksController@destroy")->name("destroy.book");


Route::get("/users/all", "UsersController@index")->name("get.all_users");
Route::get("/users/logined", "UsersController@getLoginUser")->name("get.login_user");
Route::post("/auth/register", "Auth\RegisterController@register")->name("register");
Route::post("/login", "Auth\LoginController@login")->name("login");
Route::post("/logout", "Auth\LoginController@logout")->name("logout");
// VRによる顔認証処理(or null)
Route::post("/users/authFace", "UsersController@authWithFace")->name("auth_face");
// 出勤・退勤処理
Route::post("/users/state", "UsersController@switchState")->name("switch.state");
