<?php

// ここに定義されていないパスはフロントエンドのVueRouterに従う
Route::get("/{any?}", function () {
    return view("index");
})->where("any", ".+");

