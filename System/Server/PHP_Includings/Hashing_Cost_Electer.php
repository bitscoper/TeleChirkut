<?php
/* By Abdullah As-Sadeed */

function Elect_Hashing_Cost()
{
    $cost = 8;
    $test_password = 'Sadeed_1104';

    do {
        ++$cost;
        $start_time = microtime(true);

        password_hash($test_password, PASSWORD_BCRYPT, ['cost' => $cost]);

        $end_time = microtime(true);
    } while (($end_time - $start_time) < 0.05);

    return $cost;
}