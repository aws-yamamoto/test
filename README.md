# use for portfolio


# Requirement
- Docker: https://docs.docker.com/get-docker/
- Docker Compose: https://docs.docker.com/compose/install/

# Setup
- dockerがインストールされていることを確認
```
docker -v
docker-compose -v
```

- あらかじめDockerを起動させておく
- 作業ディレクトリのルートディレクトリに移動
```
cd /your/project/path
```
- Dockerイメージをビルド
```
docker-compose build
```

※CMSのポートは「8000」、PHPMyadminのポートは「8888」に設定しています。 すでに使用されている場合は環境に合わせて変更してください。

# Usage
- コンテナを立ち上げる
```
docker-compose up -d
```
- MySQLの認証方式変更
```
docker-compose exec db bash
mysql -u root -p    ※pass: root
alter user 'root'@'%' identified with mysql_native_password by 'root';
```
- MySQLから抜ける
```
exit
```
- dbコンテナから抜ける
```
exit
```
- appコンテナに入る
```
docker-compose exec app bash
```
- envファイル修正
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=hirounivers
DB_USERNAME=root
DB_PASSWORD=root
```

# デバッグモード
```
IS_DEBUG_MODE=true
```
- composerインストール
```
composer install
```
- storage配下の権限変更
```
chmod -R 777 bootstrap/
cd ./storage
chmod -R 777 logs/
chmod  777 app/tmp/
chmod -R 777 framework/
```
- migrate
```
php artisan key:generate
php artisan config:cache
php artisan migrate --seed
```
- npm run
```
npm i
npm run watch // 初めは時間がかかりますが、次回から早くなります
```

# Webページ
```
http://localhost:8000/
```

# API route
```
http://localhost:8000/api
```

# phpMyadmin
```
http://localhost:8888

id: root
pass: root
```




