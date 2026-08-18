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
