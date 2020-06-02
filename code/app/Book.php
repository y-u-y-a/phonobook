<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Validator;

class Book extends Model
{

    // リレーション
    public function user()
    {
        // 引数にはモデルを指定
        return $this->belongsTo('App\User');
    }

    public function validate($input) {

        $rules = [
            'isbn' => 'unique:books'
        ];
        $customMessages = [
            'isbn.unique' => 'すでに登録されています。',
        ];
        // バリデーション処理の実行とエラーメッセージの返却
        return Validator::make($input, $rules, $customMessages);
    }

}
