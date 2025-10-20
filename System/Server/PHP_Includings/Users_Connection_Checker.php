<?php
/* By Abdullah As-Sadeed */

function Check_Users_Connection($profile_code_1, $profile_code_2)
{
    $connection = $GLOBALS['connection'];

    if ($profile_code_1 !== $profile_code_2) {
        if (Check_Follow($profile_code_1, $profile_code_2) && Check_Follow($profile_code_2, $profile_code_1)) {

            return true;
        } else {
            return false;
        }
    }
}