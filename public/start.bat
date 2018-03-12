@echo off
title RoyalCity
echo Booting up application
echo Please keep this window open as you use the program
echo Closing this window will close the program
start "" http://127.0.0.1:80/login & php artisan migrate & php -S 127.0.0.1:80