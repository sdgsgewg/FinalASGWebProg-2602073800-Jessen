@echo off
cd C:\Users\jesse\Herd\ConnectFriend
php artisan queue:work --sleep=3 --tries=3
