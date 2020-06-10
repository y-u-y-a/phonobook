# 画面一覧
​
pages > templates > components
​
**pages** ... templates, compontentsを組み合わせるのみ
**templates** ... componentsを組み合わせて使い回すもの(Formの完成形など)
**components** ... 原則１ファイル１機能になるようにする(Map, Droparea, Form部品)
​
※ Vue-Routerによるルーティングは、pages/以下をと一致させる
​
| 名称 | ファイル名 | 説明 | 備考 |
|-----|-----------|------|-----|
| ー | views/ | ー | ー |
| ログイン画面 | login | ユーザーがログインする画面 | ー |
| ー | pages/ | ー | ー |
| 店舗登録画面 | shop/Register | 店舗情報を登録する画面 | ー |
| 店舗編集画面 | shop/Edit | 店舗情報を編集する画面 | ー |
| メイン画面 | shop/Main | 主にマップを表示する画面 | ー |
| ー | templates/ | ー | ー |
| ヘッダー | common/TheHeader | 全画面共通のヘッダー | ー |
| サイドバー | common/SideBar | 全画面共通のサイドバー | ー |
| ナビゲーションヘッダー | common/Nav | 画面を切り替える部分 | ー |
| マップ | Map | 通常のマップを表示する | ー |
| ヒートマップ | Heatmap | ヒートマップを表示する | ー |
| マップ詳細設定 | detail | マップ・ヒートマップ画面で詳細を表示させる部分 | ー |
| ー | components/ | ー | ー |
| ドロップエリア | Droparea | ファイルをドロップできる部分 | ー |
| input部品 | form/BaseInput | 見た目を考慮しない機能的な部品 | ー |
