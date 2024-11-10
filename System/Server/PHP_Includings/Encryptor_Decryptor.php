<?php
/* By Abdullah As-Sadeed */

function Encrypt_Simmetrically($data, $key)
{
    $method = 'aes-256-gcm';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    $tag = '';
    $result = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv, $tag, '', 16);

    return base64_encode($iv . $tag . $result);
}

function Decrypt_Simmetrically($data, $key)
{
    $method = 'aes-256-gcm';
    $data = base64_decode($data);
    $ivLength = openssl_cipher_iv_length($method);
    $iv = substr($data, 0, $ivLength);
    $tag = substr($data, $ivLength, 16);
    $text = substr($data, $ivLength + 16);

    return openssl_decrypt($text, $method, $key, OPENSSL_RAW_DATA, $iv, $tag);
}
