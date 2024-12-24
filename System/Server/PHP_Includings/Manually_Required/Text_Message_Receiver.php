<?php
/* By Abdullah As-Sadeed */

function Receive_Text_Message($to_profile_code, $text_message)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    if (Check_Users_Connection($my_profile_code, $to_profile_code)) {
        $text_message = Censor_String($text_message);

        $at = time();

        $text_message = Encrypt_Simmetrically($text_message, $my_profile_code * $to_profile_code * $at);

        pg_query($connection, "INSERT INTO messages(profile_code, to_profile_code, type, message, at) VALUES ('$my_profile_code', '$to_profile_code', 'text', '$text_message', '$at');");
    }
}
