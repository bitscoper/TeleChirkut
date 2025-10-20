<?php
/* By Abdullah As-Sadeed */

function Retrieve_Messages($to_profile_code)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    if (Check_Users_Connection($my_profile_code, $to_profile_code)) {
        $query_messages = pg_query($connection, "SELECT serial, profile_code, to_profile_code, type, at, message, seen FROM messages WHERE profile_code = '$my_profile_code' AND to_profile_code = '$to_profile_code' UNION SELECT serial, profile_code, to_profile_code, type, at, message, seen FROM messages WHERE profile_code = '$to_profile_code' AND to_profile_code = '$my_profile_code' ORDER BY serial ASC;");
        $total_messages = pg_num_rows($query_messages);

        $messages = '';
        if ($total_messages > 0) {
            while ($data_messages = pg_fetch_assoc($query_messages)) {
                $serial = $data_messages['serial'];
                $sender_profile_code = $data_messages['profile_code'];
                $receiver_profile_code = $data_messages['to_profile_code'];
                $type = $data_messages['type'];
                $at_raw = $data_messages['at'];
                $at_display = Format_Date_Time($at_raw);

                if ($sender_profile_code == $my_profile_code) {
                    $display_name = 'You';
                } else {
                    $query_full_name = pg_query($connection, "SELECT full_name FROM users WHERE profile_code = '$sender_profile_code';");

                    while ($data_full_name = pg_fetch_assoc($query_full_name)) {
                        $display_name = $data_full_name['full_name'];
                    }
                }
                $messages .= '<div class="message';

                if ($sender_profile_code == $my_profile_code) {
                    $messages .= ' my_message';
                }

                $messages .= '">
<img class="message_sender_face" loading="lazy" src="/?face_logo=' . $sender_profile_code . '" title="' . $display_name . '" alt=""/>
<div class="message_column_box">
<div class="message_box">
<span data-serial="' . $serial . '" class="message_body">';
                if ($type == 'text') {
                    $messages .= Decrypt_Simmetrically($data_messages['message'], $sender_profile_code * $receiver_profile_code * $at_raw);
                } elseif ($type == 'image') {
                    $messages .= '<img class="image_message" data-serial="' . $serial . '" title="View Large" src="/?image_message=' . $serial . '" loading="lazy" alt=""/>';
                }

                $messages .= '</span>
</div>
<div class="sent_date_time">' . $at_display . '</div>
</div>
</div>';

                if ($data_messages['seen'] !== true) {
                    pg_query($connection, "UPDATE messages SET seen = TRUE WHERE to_profile_code = '$my_profile_code' AND serial = '$serial';");
                }
            }

            $query_to_unseen_messages = pg_query($connection, "SELECT serial FROM messages WHERE profile_code = '$my_profile_code' AND to_profile_code = '$to_profile_code' AND NOT seen = TRUE;");

            $to_unseen_messages_count = pg_num_rows($query_to_unseen_messages);

            if ($to_unseen_messages_count > 1) {
                $plural = 's';
            } else {
                $plural = '';
            }

            if ($to_unseen_messages_count > 0) {
                $query_to_full_name = pg_query($connection, "SELECT full_name FROM users WHERE profile_code = '$to_profile_code';");

                while ($data_to_full_name = pg_fetch_assoc($query_to_full_name)) {
                    $messages .= '<div id="to_unseen_count">' . $data_to_full_name['full_name'] . ' has not seen last <b>' . $to_unseen_messages_count . '</b> message' . $plural . '.</div>';
                }
            }
        } else {
            $messages .= 'No messages';
        }

        return $messages;
    } else {
        return 'Error_404';
    }
}