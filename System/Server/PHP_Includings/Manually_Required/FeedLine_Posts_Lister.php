<?php
/* By Abdullah As-Sadeed */

function List_FeedLine_Posts()
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    $serials = [];

    $query_feedline = pg_query($connection, "SELECT serial FROM feedline WHERE ((profile_code IN (SELECT to_profile_code FROM follows WHERE from_profile_code = '$my_profile_code') OR profile_code = '$my_profile_code')) ORDER BY serial DESC;");

    while ($data_feedline = pg_fetch_assoc($query_feedline)) {
        $serials[] = $data_feedline['serial'];
    }

    $array = ['serials' => $serials];
    $json = json_encode($array);

    return $json;
}