php.ini engedélyezni:
extension=mbstring
extension=curl
extension=fileinfo
extension=mysqli
extension=odbc
extension=openssl
extension=pdo_sqlite
extension=sqlite3




Futtatás:
php artisan serve
npm run dev


Telepítés:
npm install && npm run build
composer run dev

Adatbázis:
php artisan migrate:reset
php artisan migrate
php artisan db:seed

Mind3 egyben:
php artisan migrate:fresh --seed

Emailek:
storage/logs/ külön napi mentésben




