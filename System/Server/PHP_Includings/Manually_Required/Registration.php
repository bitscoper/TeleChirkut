<?php
/* By Abdullah As-Sadeed */

function Register($full_name, $timezone, $introduction, $password, $retyped_password, $recovery_email_address)
{
    $includings_path = $GLOBALS['includings_path'];
    $user_uploads_path = $GLOBALS['user_uploads_path'];
    $connection = $GLOBALS['connection'];

    $recovery_email_address = filter_var($recovery_email_address, FILTER_SANITIZE_EMAIL);

    if ($password !== '' && $retyped_password !== '' && $full_name !== '' && $timezone !== '' && $introduction !== '' && $password == $retyped_password && filter_var($recovery_email_address, FILTER_VALIDATE_EMAIL) && getimagesize($_FILES['face_logo']['tmp_name'])) {
        require_once $includings_path . 'Manually_Required/Logger_In.php';

        $time = time();

        $query = pg_query($connection, "INSERT INTO users(full_name, timezone, introduction, recovery_email_address, last_face_logo) VALUES('$full_name', '$timezone', '$introduction', '$recovery_email_address', '$time') RETURNING profile_code;");

        $my_profile_code = pg_fetch_result($query, 0, 'profile_code');

        $GLOBALS['my_profile_code'] = $my_profile_code;

        $cost = Elect_Hashing_Cost();

        $password_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost]);

        pg_query($connection, "UPDATE users SET password_hash = '$password_hash' WHERE profile_code = '$my_profile_code';");

        Process_Image($_FILES['face_logo']['tmp_name'], 128, 128, $user_uploads_path . 'Faces_Logos/Face_' . $my_profile_code . '_' . $time . '.webp');

        $body = 'Thanks for starting a new journey. Your Profile Code is ' . $my_profile_code . ' and profile link is https://telechirkut.bitscoper.dev/#' . $my_profile_code;
        Initiate_Send_EMail($my_profile_code, 'Welcome', $body);

        Log_In($my_profile_code, $password);

        $registered = true;
    } else {
        $registered = false;
        $my_profile_code = '';
    }

    $array = ['registered' => $registered, 'profile_code' => $my_profile_code];
    $json = json_encode($array);

    return $json;
}