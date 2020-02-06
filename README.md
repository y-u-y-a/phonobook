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

```

# 2. コンテナを作成・起動
    $ docker-compose up -d

## コンテナが起動しているか確認
    $ docker ps
phonoBook.php、phonoBook.mysqlが起動していることを確認

# 3. phpコンテナに入って、コマンドを実行
```
$ docker exec -it phonoBook.php bash
```
```
$ composer install
$ php artisan migrate
$ npm install"
```

## ブラウザで起動しているか確認
localhost:8000にアクセス

# 4. アセットを編集する場合コンパイルを実行して反映
    $ npm run watch

# エラーが出た場合
    $ docker logs [コンテナID or コンテナ名]

================================================================

# このアプリについて

# きっかけ
インターン先では書籍の貸し出しを行っていたのですが、管理を手書きで行っていたのをITの力で便利に出来ないかと考えたのがきっかけ。

# 主な実装機能

1. 顔認証による出勤管理<br>
→顔の撮影をするだけで、出勤・退勤記録ができる

2. 本のISBNの撮影による貸出し管理<br>
→本のバーコード下にあるISBNを撮影するだけで、本の貸出し記録ができる

3. ログイン機能<br>
→スマホではログインすることができ、スマホで現在借りている本の確認ができる


# 追加予定の機能

1. 各企業・各団体で利用できるようにデータベースを整地する
2. 他の認証APIも検討をし、より良いものにしていく
3. 認証をバーコードにする



























