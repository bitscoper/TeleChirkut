<?php
/* By Abdullah As-Sadeed */

function Handle_Registered_POST_Requests()
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];
    $includings_path = $GLOBALS['includings_path'];

    $type = Sanitize_String($_POST['type']);

    if ($type == 'Edit_Profile') {
        if (isset($_POST['timezone'])) {
            require_once $includings_path . 'Manually_Required/TimeZone_Editor.php';

            $timezone = Sanitize_String($_POST['timezone']);

            return Edit_TimeZone($timezone);
        } elseif (isset($_POST['introduction'])) {
            require_once $includings_path . 'Manually_Required/Introduction_Editor.php';

            $introduction = Sanitize_String($_POST['introduction']);

            return Edit_Introduction($introduction);
        } else {
            require_once $includings_path . 'Manually_Required/Face_Logo_Editor.php';

            return Edit_Face_Logo();
        }
    } elseif ($type == 'Log_In_Sessions') {
        require_once $includings_path . 'Manually_Required/Log_In_Sessions_Retreiver.php';

        return Retrieve_Log_In_Sessions();
    } elseif ($type == 'Rules') {
        require_once $includings_path . 'Manually_Required/Rules_Printer.php';

        return Print_Rules(false);
    } elseif ($type == 'Follow' && isset($_POST['profile_code'])) {
        $profile_code = Sanitize_String($_POST['profile_code']);

        if (Check_User($profile_code)) {
            require_once $includings_path . 'Manually_Required/Follower.php';

            header('Content-Type: application/json');
            return Follow($profile_code);
        } else {
            http_response_code(404);
        }
    } elseif ($type == 'Text_Message' && isset($_POST['to_profile_code']) && isset($_POST['text_message'])) {
        $to_profile_code = Sanitize_String($_POST['to_profile_code']);

        if (Check_User($to_profile_code)) {
            require_once $includings_path . 'Manually_Required/Text_Message_Receiver.php';

            $text_message = Sanitize_String($_POST['text_message']);

            Receive_Text_Message($to_profile_code, $text_message);
        } else {
            http_response_code(404);
        }
    } elseif ($type == 'Total_Unseen_Counts') {
        require_once $includings_path . 'Manually_Required/Unseen_Counts_Retriever.php';

        header('Content-Type: application/json');
        return Retrieve_Unseen_Counts($my_profile_code);
    } elseif ($type == 'Log_Out') {
        require_once $includings_path . 'Manually_Required/Logger_Out.php';

        return Log_Out();
    } elseif ($type == 'List_Messages_Connections') {
        require_once $includings_path . 'Manually_Required/Messages_Connections_Retriever.php';

        header('Content-Type: application/json');
        return Retrieve_Messages_Connections();
    } elseif ($type == 'Image_Message' && isset($_POST['to_profile_code']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        $to_profile_code = Sanitize_String($_POST['to_profile_code']);

        if (Check_User($to_profile_code)) {
            require_once $includings_path . 'Manually_Required/Image_Message_Receiver.php';

            $image_message = $_FILES['image']['tmp_name'];

            return Receive_Image_Message($to_profile_code, $image_message);
        } else {
            http_response_code(404);
        }
    } elseif ($type == 'Message_Deletion' && isset($_POST['serial'])) {
        require_once $includings_path . 'Manually_Required/Message_Deleter.php';

        $serial = Sanitize_String($_POST['serial']);

        header('Content-Type: application/json');
        return Delete_Message($serial);

    } elseif ($type == 'Post' && isset($_POST['text'])) {
        require_once $includings_path . 'Manually_Required/Post_Receiver.php';

        $post_text = Sanitize_String($_POST['text']);

        return Receive_Post($post_text);
    } elseif ($type == 'Profile' && isset($_POST['profile_code'])) {
        $profile_code = Sanitize_String($_POST['profile_code']);

        if (Check_User($profile_code)) {
            require_once $includings_path . 'Manually_Required/Profile_Elements_Generator.php';

            return Generate_Profile_Elements($profile_code);
        } else {
            http_response_code(404);
        }
    } elseif ($type == 'Post_Reaction' && isset($_POST['serial']) && isset($_POST['reaction'])) {
        $serial = Sanitize_String($_POST['serial']);

        if (Check_Post($serial)) {
            require_once $includings_path . 'Manually_Required/Post_Reacter.php';

            $reaction = Sanitize_String($_POST['reaction']);

            header('Content-Type: application/json');
            return React_Post($serial, $reaction);
        } else {
            http_response_code(404);
        }
    } elseif ($type == 'Retrieve_Post' && $_POST['serial']) {
        $serial = Sanitize_String($_POST['serial']);

        if (Check_Post($serial)) {
            require_once $includings_path . 'Manually_Required/Post_Retriever.php';

            header('Content-Type: application/json');
            return Retrieve_Post($serial);
        } else {
            http_response_code(404);
        }
    } elseif ($type == 'Post_Deletion' && isset($_POST['serial'])) {
        $serial = Sanitize_String($_POST['serial']);

        if (Check_Post($serial)) {
            require_once $includings_path . 'Manually_Required/Post_Deleter.php';

            header('Content-Type: application/json');
            return Delete_Post($serial);
        } else {
            http_response_code(404);
        }
    } elseif ($type == 'Post_Details' && isset($_POST['serial'])) {
        $serial = Sanitize_String($_POST['serial']);

        if (Check_Post($serial)) {
            require_once $includings_path . 'Manually_Required/Post_Details_Retriever.php';

            header('Content-Type: application/json');
            return Retrieve_Post_Details($serial);
        } else {
            http_response_code(404);
        }
    } elseif ($type == 'Notifications') {
        require_once $includings_path . 'Manually_Required/Notifications_Retriever.php';

        header('Content-Type: application/json');
        return Retrieve_Notifications();
    } elseif ($type == 'List_FeedLine_Posts') {
        require_once $includings_path . 'Manually_Required/FeedLine_Posts_Lister.php';

        header('Content-Type: application/json');
        return List_FeedLine_Posts();
    } elseif ($type == 'List_Reacted_Posts') {
        require_once $includings_path . 'Manually_Required/Reacted_Posts_Lister.php';

        header('Content-Type: application/json');
        return List_Reacted_Posts();
    } elseif ($type == 'Users' && isset($_POST['users'])) {
        require_once $includings_path . 'Manually_Required/Users_Lister.php';

        $users = Sanitize_String($_POST['users']);

        if ($users == 'explore') {
            return List_Users('Explore');
        } elseif ($users == 'followings') {
            return List_Users('Followings');
        } elseif ($users == 'followers') {
            return List_Users('Followers');
        } elseif ($users == 'connections') {
            return List_Users('Connections');
        }
    } elseif ($type == 'PassWord_Change' && isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['retyped_password'])) {
        require_once $includings_path . 'Manually_Required/PassWord_Changer.php';

        $current_password = Sanitize_String($_POST['current_password']);
        $new_password = Sanitize_String($_POST['new_password']);
        $retyped_password = Sanitize_String($_POST['retyped_password']);

        header('Content-Type: application/json');
        return Change_PassWord($current_password, $new_password, $retyped_password);
    } elseif ($type == 'End_Another_Session' && isset($_POST['serial'])) {
        require_once $includings_path . 'Manually_Required/Another_Session_Ender.php';

        $serial = Sanitize_String($_POST['serial']);

        return End_Another_Session($serial);
    } elseif ($type == 'Retrieve_Messages' && isset($_POST['to_profile_code'])) {
        require_once $includings_path . 'Manually_Required/Messages_Retriever.php';

        $to_profile_code = Sanitize_String($_POST['to_profile_code']);

        return Retrieve_Messages($to_profile_code);
    } elseif ($type == 'My_Profile_Code') {
        return $my_profile_code;
    } elseif ($type == 'Profile_Card' && isset($_POST['profile_code'])) {
        $profile_code = Sanitize_String($_POST['profile_code']);

        if (Check_User($profile_code)) {
            require_once $includings_path . 'Manually_Required/Profile_Card_Retriever.php';

            header('Content-Type: application/json');
            return Retrieve_Profile_Card($profile_code);
        } else {
            http_response_code(404);
        }
    } elseif ($type == 'Push_Subscribe' && isset($_POST['push_json'])) {
        require_once $includings_path . 'Manually_Required/Push_Subscriber.php';

        $push_json = Sanitize_String($_POST['push_json']);

        Subscribe_Push($push_json);
    } elseif ($type == 'Report_Post' && isset($_POST['serial'])) {
        $serial = Sanitize_String($_POST['serial']);

        if (Check_Post($serial)) {
            require_once $includings_path . 'Manually_Required/Post_Reporter.php';

            header('Content-Type: application/json');
            return Report_Post($serial);
        } else {
            http_response_code(404);
        }
    } elseif ($type == 'Report_User' && isset($_POST['profile_code'])) {
        $profile_code = Sanitize_String($_POST['profile_code']);

        if (Check_User($profile_code) && $profile_code !== $my_profile_code) {
            require_once $includings_path . 'Manually_Required/User_Reporter.php';

            header('Content-Type: application/json');
            return Report_User($profile_code);
        } else {
            http_response_code(404);
        }
    } else {
        http_response_code(404);
    }
}