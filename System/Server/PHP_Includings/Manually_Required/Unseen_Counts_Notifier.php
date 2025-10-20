<?php
/* By Abdullah As-Sadeed */

function Notify_Unseen_Counts()
{
    $connection = $GLOBALS['connection'];
    $includings_path = $GLOBALS['includings_path'];

    require_once $includings_path . 'Manually_Required/Unseen_Counts_Retriever.php';

    $receipients = 0;

    $query_users = pg_query($connection, "SELECT profile_code FROM users;");
    while ($data_users = pg_fetch_assoc($query_users)) {
        $profile_code = $data_users["profile_code"];

        $json_string = Retrieve_Unseen_Counts($profile_code);
        $json = json_decode($json_string);
        $messages = $json->messages;
        $notifications = $json->notifications;

        if ($messages > 0 || $notifications > 0) {
            if ($messages == 1) {
                $text_for_messaages = $messages . ' fresh message';
            } elseif ($messages > 1) {
                $text_for_messaages = $messages . ' fresh messages';
            } else {
                $text_for_messaages = '';
            }

            if ($notifications == 1) {
                $text_for_notifications = $notifications . ' new notification';
            } elseif ($notifications > 1) {
                $text_for_notifications = $notifications . ' new notifications';
            } else {
                $text_for_notifications = '';
            }

            if ($messages > 0 && $notifications > 0) {
                $conjuction = ' and ';
            } else {
                $conjuction = '';
            }

            $body = 'You\'ve got ' . $text_for_messaages . $conjuction . $text_for_notifications . ' waiting for you!';
            Initiate_Send_EMail($profile_code, 'Reminder', $body);

            // Initiate_Push_Send($profile_code, 'Reminder', $body, '', '');

            $receipients++;
        }
    }

    $array = ['receipients' => $receipients];
    $json = json_encode($array);

    return $json;
}