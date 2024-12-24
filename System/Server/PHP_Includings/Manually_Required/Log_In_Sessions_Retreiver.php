<?php
/* By Abdullah As-Sadeed */

function Retrieve_Log_In_Sessions()
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $log_ins = [];

    $query_log_in_sessions = pg_query($connection, "SELECT serial, token, platform, agent, last_ip_address, last_seen FROM log_in_sessions WHERE profile_code = '$my_profile_code' ORDER BY last_seen DESC;");

    while ($data_log_in_sessions = pg_fetch_assoc($query_log_in_sessions)) {
        $serial = $data_log_in_sessions['serial'];
        $token = $data_log_in_sessions['token'];

        if ($token == "" || $token == null) {
            $status = false;
        } else {
            $token = Sanitize_String($_COOKIE['TeleChirkut_2']);

            $query_check_current_session = pg_query($connection, "SELECT serial FROM log_in_sessions WHERE serial = '$serial' AND profile_code = '$my_profile_code' AND token = '$token';");

            if (pg_num_rows($query_check_current_session) == 1) {
                $status = 'Current';
            } else {
                $status = true;
            }
        }

        $token = null;

        $platform = $data_log_in_sessions['platform'];
        $agent = $data_log_in_sessions['agent'];

        $last_ip_address = $data_log_in_sessions['last_ip_address'];
        $last_seen = Format_Date_Time($data_log_in_sessions['last_seen']);

        $log_ins[] = ['serial' => $serial, 'platform' => $platform, 'agent' => $agent, 'last_ip_address' => $last_ip_address, 'last_seen' => $last_seen, 'status' => $status];
    }

    $array = ['log_in_sessions' => $log_ins];
    $json = json_encode($array);

    return $json;
}