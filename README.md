cp [.env.example](.env.example) [.env](.env)
<br>
composer update
<br>
php artisan migrate
<br>
php artisan db:seed [UserAndAccountSeeder](database%2Fseeders%2FUserAndAccountSeeder.php)
