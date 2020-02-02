<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // メソッドを定義
    public function user()
    {
        // 引数にはモデルを指定
        return $this->belongsTo('App\User');
    }

}
