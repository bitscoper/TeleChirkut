<?php
/* By Abdullah As-Sadeed */

function Recover_PassWord($profile_code, $verification_code, $authentication_code, $new_password, $retyped_password)
{
    if (Check_User($profile_code)) {
        if ($new_password == $retyped_password) {
            if (strlen($new_password) >= 11) {
                if (strlen($authentication_code) >= 8) {
                    $connection = $GLOBALS['connection'];

                    $query_user = pg_query($connection, "SELECT last_recovery_verification_code, last_recovery_authentication_code FROM users WHERE profile_code = '$profile_code';");

                    while ($data_user = pg_fetch_assoc($query_user)) {
                        $retrieved_verification_code = $data_user['last_recovery_verification_code'];
                        $retrieved_authentication_code = $data_user['last_recovery_authentication_code'];
                    }

                    if ($retrieved_verification_code == $verification_code) {
                        if ($retrieved_authentication_code == $authentication_code) {
                            $includings_path = $GLOBALS['includings_path'];
                            require_once $includings_path . 'Manually_Required/Client_IP_Address_Retriever.php';
                            require_once $includings_path . 'Manually_Required/Logger_In.php';

                            $cost = Elect_Hashing_Cost();
                            $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => $cost]);

                            pg_query($connection, "UPDATE users SET password_hash = '$new_password_hash', last_recovery_verification_code = '', last_recovery_authentication_code = 0 WHERE profile_code = '$profile_code';");

                            pg_query($connection, "UPDATE log_in_sessions SET token = '', push_json = '' WHERE profile_code = '$profile_code';");

                            $password_recovered = true;
                            $error = '';

                            $ip_address = Retrieve_Client_IP_Address();

                            $body = 'Your password has been changed from IP Address ' . $ip_address . ' through recovery option.';
                            Initiate_Send_EMail($profile_code, "Password Recovered", $body);

                            Initiate_Push_Send($profile_code, 'Security', 'Password has been recovered.', '', '');

                            Log_In($profile_code, $new_password);
                        } else {
                            $password_recovered = false;
                            $error = 'Wrong Authentication Code!';
                        }
                    } else {
                        $password_recovered = false;
                        $error = 'Malformed request!';
                    }
                } else {
                    $password_recovered = false;
                    $error = 'Authentication Code does not meet minimum length!';
                }
            } else {
                $password_recovered = false;
                $error = 'New password does not meet minimum length!';
            }
        } else {
            $password_recovered = false;
            $error = 'New password and re-entered new password does not match!';
        }
    } else {
        $password_recovered = false;
        $error = 'Profile Code is invalid!';
    }

    $array = ['password_recovered' => $password_recovered, 'error' => $error];
    $json = json_encode($array);

    return $json;
}