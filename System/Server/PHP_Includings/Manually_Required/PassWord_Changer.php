<?php
/* By Abdullah As-Sadeed */

function Change_PassWord($current_password, $new_password, $retyped_password)
{
    $includings_path = $GLOBALS['includings_path'];
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    require_once $includings_path . 'Manually_Required/Client_IP_Address_Retriever.php';
    $ip_address = Retrieve_Client_IP_Address();

    require_once $includings_path . 'Manually_Required/PassWord_Hash_Retriever.php';

    if (password_verify($current_password, Retrieve_PassWord_Hash($my_profile_code))) {
        if ($current_password !== $new_password) {
            if ($new_password == $retyped_password) {
                if (strlen($new_password) >= 11) {
                    $cost = Elect_Hashing_Cost();
                    $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => $cost]);

                    pg_query($connection, "UPDATE users SET password_hash = '$new_password_hash' WHERE profile_code = '$my_profile_code';");

                    $token = Sanitize_String($_COOKIE['TeleChirkut_2']);

                    pg_query($connection, "UPDATE log_in_sessions SET token = '', push_json = '' WHERE profile_code = '$my_profile_code' AND NOT token = '$token';");

                    $password_changed = true;
                    $error = '';

                    $body = 'Your password has been changed from IP Address ' . $ip_address;
                    Initiate_Send_EMail($my_profile_code, "Password Changed", $body);

                    Initiate_Push_Send($my_profile_code, 'Security', 'Password has been changed.', '', '');
                } else {
                    $password_changed = false;
                    $error = 'New password does not meet minimum length!';
                }
            } else {
                $password_changed = false;
                $error = 'New password and re-entered new password does not match!';
            }
        } else {
            $password_changed = false;
            $error = 'New password can not be as same as entered current password!';
        }
    } else {
        $password_changed = false;
        $error = 'You entered wrong password!';

        $body = 'There has been a failed attempt to change your password from IP Address ' . $ip_address;
        Initiate_Send_EMail($my_profile_code, "Failed Password Change Attempt", $body);

        Initiate_Push_Send($my_profile_code, 'Security', 'There has been a failed attempt to change your password.', '', '');
    }

    $array = ['password_changed' => $password_changed, 'error' => $error];
    $json = json_encode($array);

    return $json;
}