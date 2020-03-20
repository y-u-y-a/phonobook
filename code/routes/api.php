<?php

use Illuminate\Http\Request;


Route::get("/books/all", "BooksController@index")->name("get.all_books");
Route::get("/books/borrowed/{user_id}", "BooksController@getBorrowedBooks")->name("get.borrowed_books");
Route::get("/books/{id}", "BooksController@show")->name("get.book");
Route::get("/books/{book_isbn}/borrow/{user_id}", "BooksController@borrow")->name("borrow.book");
Route::get("/books/return/{id}", "BooksController@return")->name("return.book");
Route::post("/books", "BooksController@new")->name("store.book");
Route::patch("/books", "BooksController@update")->name("update.book");
Route::delete("/books", "BooksController@destroy")->name("destroy.book");


Route::get("/users/all", "UsersController@index")->name("get.all_users");
Route::get("/users/logined", "UsersController@getLoginUser")->name("get.login_user");
Route::post("/auth/register", "Auth\RegisterController@register")->name("register");
Route::post("/login", "Auth\LoginController@login")->name("login");
Route::post("/logout", "Auth\LoginController@logout")->name("logout");
// 出勤・退勤処理
Route::post("/users/state", "UsersController@switchState")->name("switch.state");


Route::post("/users/authFace", "APIController@authFaceWithVR")->name("auth_face");
// Route::post("/books/barcode", "BooksController@getISBN");
