@echo off
TITLE Server Ujian CAT
color 0A

echo ===================================================
echo MENYALAKAN DATABASE (MySQL)
echo ===================================================
start "" /B "%~dp0mysql\bin\mysqld.exe" --console --port=33066 --datadir="%~dp0mysql\data"

echo.
echo Menunggu Database menyala...
:waitmysql
"%~dp0mysql\bin\mysql.exe" -h 127.0.0.1 --port=33066 -u root -e "SELECT 1" >nul 2>nul
if %errorlevel% neq 0 (
    ping 127.0.0.1 -n 2 > nul
    goto waitmysql
)

if not exist "%~dp0mysql\data\tryout" (
    if exist "%~dp0init.sql" (
        echo ===================================================
        echo MENGIMPOR DATABASE AWAL (Harap Tunggu Sebentar...)
        echo ===================================================
        "%~dp0mysql\bin\mysql.exe" -h 127.0.0.1 --port=33066 -u root -e "CREATE DATABASE IF NOT EXISTS tryout;"
        "%~dp0mysql\bin\mysql.exe" -h 127.0.0.1 --port=33066 -u root tryout < "%~dp0init.sql"
        if %errorlevel% equ 0 (
            echo Impor database berhasil.
        ) else (
            echo PERINGATAN: Gagal mengimpor database!
            color 0C
            pause
        )
    )
)

cd /d "%~dp0app"
"%~dp0php\php.exe" artisan sync:target-kelulusan >nul 2>nul

echo.
echo ===================================================
echo INFORMASI UNTUK SISWA (TULIS DI PAPAN TULIS):
echo ===================================================
echo 1. Sambungkan laptop/HP siswa ke WiFi Ruangan.
echo 2. Buka aplikasi Google Chrome / Browser.
echo 3. Ketik alamat Server Ujian di bawah ini:
echo.
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "ipv4"') do (
    for /f "tokens=1" %%b in ("%%a") do echo        http://%%b:8000
)
echo.
echo 4. Klik "MULAI UJIAN" di layar yang muncul.
echo ===================================================
echo.
echo JANGAN MENUTUP JENDELA INI SELAMA UJIAN BERLANGSUNG!
echo.
echo Membuka aplikasi...
start "" "http://localhost:8000"
cd /d "%~dp0app"
"%~dp0php\php.exe" artisan serve --host=0.0.0.0 --port=8000

