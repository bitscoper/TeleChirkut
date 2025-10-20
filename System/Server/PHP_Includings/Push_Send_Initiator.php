<?php
/* By Abdullah As-Sadeed */

function Initiate_Push_Send($profile_code, $title, $body_text, $image_url, $date_time)
{
    $connection = $GLOBALS['connection'];

    $query_push_json = pg_query($connection, "SELECT push_json FROM log_in_sessions WHERE profile_code = '$profile_code' ORDER BY last_seen DESC;");
    while ($data_push_json = pg_fetch_assoc($query_push_json)) {
        $push_json = $data_push_json['push_json'];

        if ($push_json !== '') {
            $php_path = $GLOBALS['php_path'];
            $background_null_device = $GLOBALS['background_null_device'];

            $array = ['title' => $title, 'body_text' => $body_text, 'image_url' => $image_url, 'date_time' => $date_time];
            $data_json = json_encode($array);
            $data_json = base64_encode($data_json);

            $push_json = base64_encode($push_json);

            shell_exec($php_path . ' ../../Server/Push_Sender.php ' . $push_json . ' ' . $data_json . ' ' . $background_null_device);
        }
    }
}