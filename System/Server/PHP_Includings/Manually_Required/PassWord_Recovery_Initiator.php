<?php
/* By Abdullah As-Sadeed */

function Initiate_PassWord_Recovery($profile_code)
{
    $connection = $GLOBALS['connection'];

    if (Check_User($profile_code)) {
        $valid_profile_code = true;

        $verification_code = base64_encode(random_bytes(128));
        $authentication_code = random_int(11111111, 99999999);

        pg_query($connection, "UPDATE users SET last_recovery_verification_code = '$verification_code', last_recovery_authentication_code = '$authentication_code' WHERE profile_code = '$profile_code';");

        $body = 'Your authentication code for password recovery is ' . $authentication_code;
        Initiate_Send_EMail($profile_code, "Authentication Code for Password Recovery", $body);

    } else {
        $valid_profile_code = false;
        $verification_code = '';
    }

    $array = ['valid_profile_code' => $valid_profile_code, 'verification_code' => $verification_code];
    $json = json_encode($array);

    return $json;
}