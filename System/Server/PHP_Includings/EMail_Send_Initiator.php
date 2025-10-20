<?php
/* By Abdullah As-Sadeed */

function Initiate_Send_EMail($profile_code, $subject, $body)
{
    $connection = $GLOBALS['connection'];
    $php_path = $GLOBALS['php_path'];
    $background_null_device = $GLOBALS['background_null_device'];
    $sender_program = '/var/internet_server/TeleChirkut/System/Server/EMail_Sender.php';

    $query_user = pg_query($connection, "SELECT full_name, recovery_email_address FROM users WHERE profile_code = '$profile_code';");

    while ($data_user = pg_fetch_assoc($query_user)) {
        $full_name = $data_user['full_name'];
        $recovery_email_address = $data_user['recovery_email_address'];
    }

    $to = $full_name . ' <' . $recovery_email_address . '>';

    $body = $full_name . ",\n" . $body . "\n\nTeleChirkut";

    $to = base64_encode($to);
    $subject = base64_encode($subject);
    $body = base64_encode($body);

    shell_exec($php_path . ' ' . $sender_program . ' ' . $to . ' ' . $subject . ' ' . $body . ' ' . $background_null_device);

    return true;
}