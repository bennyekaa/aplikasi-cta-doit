$ErrorActionPreference = "Stop"

$ProjectDir = "C:\laragon\www\tryout"
$BuildDir = "$ProjectDir\build_portable"
$PhpDir = "C:\laragon\bin\php\php-8.1.10-Win32-vs16-x64"
$MysqlDir = "C:\laragon\bin\mysql\mysql-8.0.30-winx64"

Write-Host "Mempersiapkan folder build..."
if (Test-Path $BuildDir) {
    Remove-Item -Recurse -Force $BuildDir
}
New-Item -ItemType Directory -Force -Path $BuildDir | Out-Null
New-Item -ItemType Directory -Force -Path "$BuildDir\mysql" | Out-Null

Write-Host "Menyalin PHP..."
Copy-Item -Path "$PhpDir" -Destination "$BuildDir\php" -Recurse

Write-Host "Menyalin MySQL (Tanpa folder data yang lama)..."
Get-ChildItem -Path $MysqlDir | Where-Object { $_.Name -ne "data" } | Copy-Item -Destination "$BuildDir\mysql" -Recurse

Write-Host "Membuat Data MySQL baru (Inisialisasi)..."
New-Item -ItemType Directory -Force -Path "$BuildDir\mysql\data" | Out-Null
& "$BuildDir\mysql\bin\mysqld.exe" --initialize-insecure --datadir="$BuildDir\mysql\data" --console

Write-Host "Mengekspor Database Tryout..."
& "$MysqlDir\bin\mysqldump.exe" -h 127.0.0.1 -u root tryout | Out-File -FilePath "$BuildDir\init.sql" -Encoding utf8

Write-Host "Menyalin Aplikasi Laravel..."
robocopy "$ProjectDir" "$BuildDir\app" /E /XD node_modules .git build_portable /XF package_cat.ps1 encrypt_build.php /NFL /NDL /NJH /NJS
if ($LASTEXITCODE -ge 8) {
    Write-Error "Gagal menyalin file aplikasi."
}

Write-Host "Mengenkripsi kode aplikasi Laravel..."
& "$PhpDir\php.exe" "$ProjectDir\encrypt_build.php"

Write-Host "Memperbarui konfigurasi .env untuk Server Portable..."
$EnvPath = "$BuildDir\app\.env"
(Get-Content $EnvPath) -replace "DB_PORT=3306", "DB_PORT=33066" | Set-Content $EnvPath

Write-Host "Memperbarui konfigurasi php.ini untuk Server Portable..."
$PhpIniPath = "$BuildDir\php\php.ini"
if (Test-Path $PhpIniPath) {
    (Get-Content $PhpIniPath) -replace 'extension_dir\s*=\s*".*ext"', 'extension_dir="ext"' `
                              -replace 'error_log\s*=\s*".*"', ';error_log = ""' `
                              -replace 'session\.save_path\s*=\s*".*"', ';session.save_path = ""' `
                              -replace 'curl\.cainfo\s*=\s*".*"', ';curl.cainfo = ""' `
                              -replace 'include_path\s*=\s*".*"', ';include_path = ""' `
                              -replace 'sendmail_path\s*=\s*".*"', ';sendmail_path=""' | Set-Content $PhpIniPath
}

Write-Host "Membuat start.bat yang sangat stabil..."
$StartBat = @"
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

echo.
echo ===================================================
echo MENGAMBIL DATA KELULUSAN DARI WEB SERVICE...
echo ===================================================
cd /d "%~dp0app"
"%~dp0php\php.exe" artisan sync:target-kelulusan

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

"@
Set-Content -Path "$BuildDir\start.bat" -Value $StartBat -Encoding ASCII

Write-Host "Membuat stop.bat..."
$StopBat = @"
@echo off
TITLE Mematikan Server Ujian CAT

echo Menghapus tabel target kelulusan...
"%~dp0mysql\bin\mysql.exe" -h 127.0.0.1 --port=33066 -u root tryout -e "DROP TABLE IF EXISTS temp_target_kelulusan;"

echo Mematikan MySQL...
"%~dp0mysql\bin\mysqladmin.exe" -h 127.0.0.1 --port=33066 -u root shutdown
echo Mematikan PHP Server...
taskkill /F /IM php.exe /T
echo Selesai!
pause
"@
Set-Content -Path "$BuildDir\stop.bat" -Value $StopBat -Encoding ASCII

Write-Host "Membuat script Inno Setup (installer.iss)..."
$IssContent = @"
[Setup]
AppName=Ujian CAT Intranet
AppVersion=1.0
DefaultDirName=C:\UjianCAT
DefaultGroupName=Ujian CAT
OutputDir=.
OutputBaseFilename=Setup_Ujian_CAT
Compression=lzma2
SolidCompression=yes
PrivilegesRequired=admin

[Dirs]
Name: "{app}"; Permissions: users-modify

[Files]
Source: "*"; DestDir: "{app}"; Flags: ignoreversion recursesubdirs createallsubdirs

[Icons]
Name: "{commondesktop}\Mulai Server Ujian CAT"; Filename: "{app}\start.bat"; IconFilename: "shell32.dll"; IconIndex: 13
Name: "{commondesktop}\Matikan Server Ujian CAT"; Filename: "{app}\stop.bat"; IconFilename: "shell32.dll"; IconIndex: 27

[Run]
Filename: "netsh"; Parameters: "advfirewall firewall add rule name=""Ujian CAT PHP"" dir=in action=allow program=""{app}\php\php.exe"" enable=yes"; Flags: runhidden
Filename: "netsh"; Parameters: "advfirewall firewall add rule name=""Ujian CAT MySQL"" dir=in action=allow program=""{app}\mysql\bin\mysqld.exe"" enable=yes"; Flags: runhidden
Filename: "{app}\start.bat"; Description: "Jalankan Server Ujian Sekarang"; Flags: nowait postinstall skipifsilent

[UninstallRun]
Filename: "netsh"; Parameters: "advfirewall firewall delete rule name=""Ujian CAT PHP"""; Flags: runhidden
Filename: "netsh"; Parameters: "advfirewall firewall delete rule name=""Ujian CAT MySQL"""; Flags: runhidden
"@
Set-Content -Path "$BuildDir\installer.iss" -Value $IssContent -Encoding ASCII

Write-Host "=========================================================="
Write-Host "SELESAI! Folder build_portable telah dibuat."
Write-Host "Sekarang buka file installer.iss dengan Inno Setup dan klik Compile."
Write-Host "=========================================================="
