<?php
$projectDir = __DIR__;
$buildAppDir = $projectDir . '/build_portable/app';

if (!is_dir($buildAppDir)) {
    echo "Build directory not found.\n";
    exit(1);
}

// Directories to encrypt
$dirsToEncrypt = [
    $buildAppDir . '/app',
    $buildAppDir . '/routes',
    $buildAppDir . '/database/seeders',
    $buildAppDir . '/database/factories',
];

$key_string = 'DOITSUKSES';

foreach ($dirsToEncrypt as $dir) {
    if (!is_dir($dir)) continue;

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $path = $file->getPathname();
            $content = file_get_contents($path);
            
            // Skip already encrypted files just in case
            if (strpos($content, 'eval(openssl_decrypt') !== false || strpos($content, 'eval(base64_decode') !== false) {
                continue;
            }

            $content = trim($content);
            if (substr($content, 0, 5) === '<?php') {
                $code = substr($content, 5);
            } else {
                $code = "?>" . $content;
            }
            
            // Base64-kan kodenya
            $encoded_code = base64_encode($code);
            // Base64-kan secret key-nya agar tidak terlihat mencolok
            $encoded_key = base64_encode($key_string);
            
            // Gabungkan Base64 Key + Base64 Code + Base64 Key
            $payload = $encoded_key . $encoded_code . $encoded_key;
            
            $obfuscated = "<?php\n"
                        . "return eval(base64_decode(str_replace('$encoded_key', '', '$payload')));\n";
            file_put_contents($path, $obfuscated);
        }
    }
}

echo "Encryption complete.\n";
