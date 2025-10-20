<?php
/* By Abdullah As-Sadeed */

function Generate_Profile_Elements($profile_code)
{
    $connection = $GLOBALS['connection'];
    $registration = $GLOBALS['registration'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $query_profile = pg_query($connection, "SELECT full_name, verification, note, timezone, introduction  FROM users WHERE profile_code = '$profile_code';");

    while ($data_profile = pg_fetch_assoc($query_profile)) {
        $full_name = $data_profile['full_name'];
        $GLOBALS['full_name'] = $full_name;
        $verification = $data_profile['verification'];
        $note = $data_profile['note'];
        $timezone = $data_profile['timezone'];
        $introduction = $data_profile['introduction'];
        $GLOBALS['introduction'] = $introduction;
    }

    $query_followers_count = pg_query($connection, "SELECT serial FROM follows WHERE to_profile_code = '$profile_code';");

    $followers_count = pg_num_rows($query_followers_count);

    $query_posts_count = pg_query($connection, "SELECT serial FROM feedline WHERE profile_code = '$profile_code';");

    $posts_count = pg_num_rows($query_posts_count);

    $page = '<div id="profile_about">
<div id="profile_face_logo_container">
<img loading="lazy" src="/?face_logo=' . $profile_code . '" title="Face" id="profile_face_logo" alt=""/>';

    if ($registration && $profile_code == $my_profile_code) {
        $page .= '<img src="Client_Includings/Edit_Profile.svg" id="edit_face_logo_icon" title="Edit Face / Logo" alt=""/>';
    }

    $page .= '</div>
<span id="profile_details_container">
<span class="profile_details" title="Profile Code">
<img src="Client_Includings/Profile_Code.svg" alt=""/> <span>' . $profile_code;

    if ($verification == true) {
        $page .= ' | Verified';
    }

    $page .= '</span>
</span>
<span class="profile_details" title="Timezone">
<img src="Client_Includings/TimeZone.svg" alt=""/> <span id="profile_timezone">' . $timezone . '</span>';

    if ($registration && $profile_code == $my_profile_code) {
        $page .= '<img src="Client_Includings/Edit_Profile.svg" id="edit_timezone_icon" title="Edit Timezone" alt=""/>';
    }

    $page .= '</span>
<span class="profile_details" title="Followers Count">
<img src="Client_Includings/Followed.svg" alt=""/> <span><span id="followers_count">' . $followers_count . '</span> Followers</span>
</span>';

    $page .= '<span class="profile_details" title="Posts Count">
<img src="Client_Includings/Posts.svg" alt=""/> <span> ' . $posts_count . ' Post';

    if ($posts_count > 1) {
        $page .= 's';
    }

    $page .= '</span>
</span>
</span>';

    if ($note !== '') {
        $page .= '<div id="profile_note" title="Note">' . $note . '</div>';
    }

    $page .= '<div><span id="profile_introduction" title="Introduction">' . $introduction . '</span>';

    if ($registration && $profile_code == $my_profile_code) {
        $page .= '<img src="Client_Includings/Edit_Profile.svg" id="edit_introduction_icon" title="Edit Introduction" alt=""/>';
    }

    $page .= '</div>
</div>';

    if ($registration && $profile_code !== $my_profile_code) {
        $page .= '<div id="profile_actions">
<div>';

        if (Check_Follow($my_profile_code, $profile_code)) {
            $page .= '<span data-fullname="' . $full_name . '" title="Unfollow ' . $full_name . '" class="button_light follow_icon" id="follow_' . $profile_code . '" data-profile_code="' . $profile_code . '">Followed</span>';
        } else {
            $page .= '<span data-fullname="' . $full_name . '" title="Follow ' . $full_name . '" class="button follow_icon" id="follow_' . $profile_code . '" data-profile_code="' . $profile_code . '">Follow</span>';
        }

        $page .= '</div>
<div>
<span class="button" id="profile_message_icon" title="Message ' . $full_name . '" data-profile_code="' . $profile_code . '">Message</span>
</div>
<div>
<span class="button" id="profile_report_icon" title="Report ' . $full_name . '" data-profile_code="' . $profile_code . '">Report</span>
</div>
</div>';
    }

    $page .= '<div id="feedline">';

    if ($registration) {
        $query_feedline = pg_query($connection, "SELECT serial FROM feedline WHERE profile_code = '$profile_code' ORDER BY serial DESC;");

        if (pg_num_rows($query_feedline) == 0) {
            if (isset($my_profile_code)) {
                if ($profile_code == $my_profile_code) {
                    $full_name = 'You';
                }
            }

            $page .= '<div class="empty_flex">' . $full_name . ' did not post anything yet.</div>';
        } else {
            while ($data_feedline = pg_fetch_assoc($query_feedline)) {
                $page .= '<span class="post" data-serial="' . $data_feedline['serial'] . '" data-loading="not_requested"></span>';
            }
        }
    } else {
        $page .= '<div class="empty_flex">You must log in to see ' . $full_name . '\'s posts.</div>';
    }

    $page .= '</div>';

    return $page;
}