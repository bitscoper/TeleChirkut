<?php
/* By Abdullah As-Sadeed */

/*
/usr/local/lsws/lsphp81/bin/lsphp /var/internet_server/TeleChirkut/System/Server/Manual_EMail_Sender.php
*/

$includings_path = __DIR__ . '/PHP_Includings/';

require_once $includings_path . 'Manually_Required/Shell_Execution_Variables.php';

date_default_timezone_set('UTC');

require_once $includings_path . 'Manually_Required/DataBase_Connector.php';
Connect_DataBase();

if (isset($argv[1]) && isset($argv[2])) {
    require_once $includings_path . 'String_Sanitizer.php';

    require_once $includings_path . 'User_Checker.php';

    $argument_1 = $argv[1];
    $subject = Sanitize_String($argument_1);

    $argument_2 = $argv[2];
    $argument_2 = Sanitize_String($argument_2);
    $body = base64_decode($argument_2);

    if ($subject == "") {
        echo "\nError: Subject can not be empty!\n\n";
    } else if ($body == "") {
        echo "\nError: Body can not be empty!\n\n";
    } else {
        require_once $includings_path . 'EMail_Send_Initiator.php';

        $query_user = pg_query($connection, "SELECT profile_code FROM users;");

        while ($data_user = pg_fetch_assoc($query_user)) {
            $profile_code = $data_user['profile_code'];

            if (Initiate_Send_EMail($profile_code, $subject, $body)) {
                echo "\nSent to " . $profile_code . "\n";
            }
        }

    }

} else {
    echo "\nError: Missing Arguments!\n\n";
}

pg_close($connection);
exit();