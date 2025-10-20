<?php
/* By Abdullah As-Sadeed */

function Retrieve_PassWord_Hash($profile_code)
{
    $connection = $GLOBALS['connection'];

    $query_password_hash = pg_query($connection, "SELECT password_hash FROM users WHERE profile_code = '$profile_code';");

    while ($data_password_hash = pg_fetch_assoc($query_password_hash)) {
        $password_hash = $data_password_hash['password_hash'];
    }

    return $password_hash;
}