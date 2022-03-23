echo 'DROP DATABASE IF EXISTS shop;' | mysql -uroot -p000000
echo 'CREATE DATABASE IF NOT EXISTS shop;' | mysql -uroot -p000000
mysql -uroot -p000000 < `pwd`/hidden/database.sql

php -S localhost:8080