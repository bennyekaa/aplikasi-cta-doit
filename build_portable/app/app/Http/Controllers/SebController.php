<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SebController extends Controller
{
    public function downloadConfig(Request $request)
    {
        $host = $request->getHttpHost();
        $startUrl = "http://" . $host . "/login";
        
        $xml = '<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE plist PUBLIC "-//Apple Computer//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
  <dict>
    <key>originatorVersion</key>
    <string>SEB_Win_2.4.1</string>
    <key>startURL</key>
    <string>'.$startUrl.'</string>
    <key>sendBrowserExamKey</key>
    <true/>
    <key>browserWindowAllowReload</key>
    <true/>
    <key>showTaskBar</key>
    <true/>
    <key>allowQuit</key>
    <true/>
    <key>quitPassword</key>
    <string>12345</string>
    <key>hashedQuitPassword</key>
    <string>5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5</string>
  </dict>
</plist>';

        return response($xml, 200, [
            'Content-Type' => 'application/seb',
            'Content-Disposition' => 'attachment; filename="Ujian_CAT.seb"'
        ]);
    }
}
