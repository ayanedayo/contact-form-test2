# MOGITATE（商品管理）

## Docker ビルド手順
1,git clone https://github.com/ayanedayo/contact-form-test2.git
2,docker-compose up -d --build
MySQLが起動しない場合は、各自のPC環境に合わせて docker-compose.yml を修正

## Laravel環境構築
1.docker-compose exec php bash
2.composer install
3..env.example をコピーして .env 作成 .envに以下の環境変数を追加 DB_CONNECTION=mysql DB_HOST=mysql DB_PORT=3306 DB_DATABASE=laravel_db DB_USERNAME=laravel_user DB_PASSWORD=laravel_pass
4.php artisan key:generate
5.php artisan migrate
6.php artisan db:seed

## 使用技術
PHP 8.0
Laravel 8.83.8
MySQL 8.0
Docker / Docker Compose

## 📊 ER図

![ER図](src/database/ERD/mogitate.png)


## URL
開発環境: http://localhost/
phpMyAdmin: http://localhost:8080/
