<?php
/* By Abdullah As-Sadeed */

function Log_In($profile_code, $password)
{
    $includings_path = $GLOBALS['includings_path'];
    $connection = $GLOBALS['connection'];

    require_once $includings_path . 'Manually_Required/PassWord_Hash_Retriever.php';

    if (Check_User($profile_code) && password_verify($password, Retrieve_PassWord_Hash($profile_code))) {
        require_once $includings_path . 'Manually_Required/Client_IP_Address_Retriever.php';

        $token = base64_encode(random_bytes(128));

        $user_agent = get_browser(null, true);
        $platform = $user_agent['platform'];
        $agent = $user_agent['parent'];

        $last_ip_address = Retrieve_Client_IP_Address();
        $last_seen = time();

        pg_query($connection, "INSERT INTO log_in_sessions(profile_code, token, platform, agent, last_ip_address, last_seen) VALUES ('$profile_code', '$token',  '$platform', '$agent', '$last_ip_address', '$last_seen');");

        setcookie('TeleChirkut_1', $profile_code, time() + (86400 * 30), '/', 'telechirkut.bitscoper.dev', true, true);
        setcookie('TeleChirkut_2', $token, time() + (86400 * 30), '/', 'telechirkut.bitscoper.dev', true, true);

        $logged_in = true;
        $error = '';

        $body = 'You have a new log in on IP address ' . $last_ip_address;
        Initiate_Send_EMail($profile_code, 'New Log In', $body);

        Initiate_Push_Send($profile_code, 'Security', 'New Login on IP ' . $last_ip_address, '', '');
    } else {
        $logged_in = false;
        $error = 'Not Matched!';
    }

    $array = ['logged_in' => $logged_in, 'error' => $error];
    $json = json_encode($array);

    return $json;
}