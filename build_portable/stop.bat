@echo off
TITLE Mematikan Server Ujian CAT

"%~dp0mysql\bin\mysql.exe" -h 127.0.0.1 --port=33066 -u root tryout -e "DROP TABLE IF EXISTS temp_target_kelulusan;" >nul 2>nul

echo Mematikan MySQL...
"%~dp0mysql\bin\mysqladmin.exe" -h 127.0.0.1 --port=33066 -u root shutdown
echo Mematikan PHP Server...
taskkill /F /IM php.exe /T
echo Selesai!
pause
