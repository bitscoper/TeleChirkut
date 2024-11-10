<?php
/* By Abdullah As-Sadeed */

function Reset_Test_User_PassWord()
{
    $test_user_profile_code = 13;
    $test_user_password = 'Te$t_U$er_1';

    $connection = $GLOBALS['connection'];

    $cost = Elect_Hashing_Cost();
    $new_password_hash = password_hash($test_user_password, PASSWORD_BCRYPT, ['cost' => $cost]);

    pg_query($connection, "UPDATE users SET password_hash = '$new_password_hash' WHERE profile_code = '$test_user_profile_code';");

    return $new_password_hash;
}