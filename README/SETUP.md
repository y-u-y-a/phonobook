# ＜git cloneした後にやること(ローカルの構築)＞

# 1. Laravel内に.envを作成
    $ cp ./code/.env.example ./code/.env


下記を追加
```:
VISUAL_RECOGNITION_SECRET_KEY=""
MODEL_ID=""
```
各自でIBMのVisualRecognitionの登録
VISUAL_RECOGNITION_SECRET_KEY, MODEL_IDに関してはIBMのVisualRecognitionの登録が必要。
顔認証機能で使用します。（/codeの.envに定義）


# 2. コンテナを作成・起動
    $ docker-compose up -d


# 3. シェルスクリプトを実行(settings.sh)
    $ chmod 755 docker/settings.sh
    $ docker/settings.sh

composer install, npm install, migrateをコンテナ内で実行
(時間がかかります。)


## ブラウザで起動しているか確認
localhost:8001にアクセス


# 4. 開発時は、コンテナでコンパイルを実行
    $ docker exec -it phonoBook.php bash -c "npm run watch"


# ※エラーが出た場合
    $ docker logs [コンテナID or コンテナ名]

# ※ファイル名を指定して実行
    $ docker-compose -f ./[ファイル名].yaml up -d
