<?php
$code = 'echo "Hello World!"; return 42;';
$key_string = 'DOITSUKSES';
$key_hash = hash('sha256', $key_string, true);
$iv = openssl_random_pseudo_bytes(16);
$encrypted = openssl_encrypt($code, 'aes-256-cbc', $key_hash, 0, $iv);
$payload = base64_encode($iv . '::' . $encrypted);
$b64_key = base64_encode($key_string);

$k=hash('sha256',base64_decode($b64_key),true);
$p=explode('::',base64_decode($payload));
$res = eval(openssl_decrypt($p[1],'aes-256-cbc',$k,0,$p[0]));
echo "\nResult: " . $res;
