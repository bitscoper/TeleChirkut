<?php
/* By Abdullah As-Sadeed */

function List_Reacted_Posts()
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $serials = [];

    $query_reacted_posts = pg_query($connection, "SELECT feedline_serial FROM post_reactions WHERE from_profile_code = '$my_profile_code' ORDER BY at DESC;");

    if (pg_num_rows($query_reacted_posts) > 0) {
        while ($data_reacted_posts = pg_fetch_assoc($query_reacted_posts)) {
            $serials[] = $data_reacted_posts['feedline_serial'];
        }
    }

    $array = ['serials' => $serials];
    $json = json_encode($array);

    return $json;
}