# git cloneした後にやること(ローカルの構築)

# 1. Laravel内に.envを作成
    $ touch ./code/.env

まずはlaravelインストール時のデフォルトをコピペする

下記を変更
```:
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:ESGFm7Ehqyiu5E1R2jXLL//wmHeLamS38j5FMePWlgM=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=phonoBook
DB_USERNAME=root
DB_PASSWORD=root

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

==================================
VISUAL_RECOGNITION_SECRET_KEY=""
MODEL_ID=""
==================================
```

VISUAL_RECOGNITION_SECRET_KEY, MODEL_IDに関してはIBMのVisualRecognitionの登録が必要。
顔認証機能で使用します。（/codeの.envに定義）


# 2. コンテナを作成・起動
    $ docker-compose up -d


# 3. シェルスクリプトを実行(settings.sh)
    $ chmod 755 docker/settings.sh
    $ docker/settings.sh

composer install、npm install、migrateをコンテナ内で実行
(時間がかかります。)


## ブラウザで起動しているか確認
localhost:8001にアクセス


# 4. アセットを編集する場合、コンテナでコンパイルを実行
    $ docker exec -it phonoBook.php bash
    $ npm run watch


# 5. IBMのVisualRecognitionの登録



# エラーが出た場合
    $ docker logs [コンテナID or コンテナ名]

# /dockerに移動せずに実行
    $ docks -f ./docker/docker-compose.yaml up -d


























