<?php

namespace App\Helpers;

class EncryptHelper
{
    public static function encrypt($data, $key)
    {
        $keyHash = hash('sha256', $key, true);
        $iv = substr($keyHash, 0, 16);
        $encrypted = openssl_encrypt(json_encode($data), 'AES-256-CBC', $keyHash, OPENSSL_RAW_DATA, $iv);
        return base64_encode($encrypted);
    }

    public static function decrypt($data, $key)
    {
        $keyHash = hash('sha256', $key, true);
        $iv = substr($keyHash, 0, 16);
        $decrypted = openssl_decrypt(base64_decode($data), 'AES-256-CBC', $keyHash, OPENSSL_RAW_DATA, $iv);
        return json_decode($decrypted, true);
    }
}
