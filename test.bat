@echo off
"c:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqladmin.exe" -u root --port=33067 ping >nul 2>nul
echo %errorlevel%
