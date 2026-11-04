@echo off
cd /d "%~dp0"
start "" http://localhost:8080/
"C:\wamp64\bin\php\php8.4.0\php.exe" -S localhost:8080 router.php
