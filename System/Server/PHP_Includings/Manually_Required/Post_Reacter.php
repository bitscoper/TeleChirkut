<?php
/* By Abdullah As-Sadeed */

function React_Post($serial, $reaction)
{
    $connection = $GLOBALS['connection'];
    $my_profile_code = $GLOBALS['my_profile_code'];

    if ($reaction == 'love' || $reaction == 'support' || $reaction == 'celebrate' || $reaction == 'amazing' || $reaction == 'curious' || $reaction == 'funny' || $reaction == 'sad' || $reaction == 'angry') {
        $query_poster_profile_code = pg_query($connection, "SELECT profile_code FROM feedline WHERE serial = '$serial';");

        while ($data_poster_profile_code = pg_fetch_assoc($query_poster_profile_code)) {
            $poster_profile_code = $data_poster_profile_code['profile_code'];
        }

        if ($my_profile_code !== $poster_profile_code && Check_User($poster_profile_code) && Check_Follow($my_profile_code, $poster_profile_code)) {
            $query_previous_reaction = pg_query($connection, "SELECT type FROM post_reactions WHERE from_profile_code = '$my_profile_code' AND feedline_serial = '$serial';");

            if (pg_num_rows($query_previous_reaction) == 1) {
                while ($data_previous_reaction = pg_fetch_assoc($query_previous_reaction)) {
                    $previous_reaction = $data_previous_reaction['type'];
                }

                if ($previous_reaction == $reaction) {
                    pg_query($connection, "DELETE FROM post_reactions WHERE type = '$reaction' AND from_profile_code = '$my_profile_code' AND feedline_serial = '$serial';");

                    $action = 'REMOVED';
                } else {
                    pg_query($connection, "UPDATE post_reactions SET type = '$reaction', seen = FALSE WHERE type = '$previous_reaction' AND from_profile_code = '$my_profile_code' AND feedline_serial = '$serial';");

                    $action = $reaction;
                }
            } else {
                $at = time();

                pg_query($connection, "INSERT INTO post_reactions(type, from_profile_code, feedline_serial, at) VALUES('$reaction', '$my_profile_code', '$serial', '$at');");

                $action = $reaction;
            }

            $query_love = pg_query($connection, "SELECT serial FROM post_reactions WHERE type = 'love' AND feedline_serial = '$serial';");
            $love_count = pg_num_rows($query_love);

            $query_support = pg_query($connection, "SELECT serial FROM post_reactions WHERE type = 'support' AND feedline_serial = '$serial';");
            $support_count = pg_num_rows($query_support);

            $query_celebrate = pg_query($connection, "SELECT serial FROM post_reactions WHERE type = 'celebrate' AND feedline_serial = '$serial';");
            $celebrate_count = pg_num_rows($query_celebrate);

            $query_amazing = pg_query($connection, "SELECT serial FROM post_reactions WHERE type = 'amazing' AND feedline_serial = '$serial';");
            $amazing_count = pg_num_rows($query_amazing);

            $query_curious = pg_query($connection, "SELECT serial FROM post_reactions WHERE type = 'curious' AND feedline_serial = '$serial';");
            $curious_count = pg_num_rows($query_curious);

            $query_funny = pg_query($connection, "SELECT serial FROM post_reactions WHERE type = 'funny' AND feedline_serial = '$serial';");
            $funny_count = pg_num_rows($query_funny);

            $query_sad = pg_query($connection, "SELECT serial FROM post_reactions WHERE type = 'sad' AND feedline_serial = '$serial';");
            $sad_count = pg_num_rows($query_sad);

            $query_angry = pg_query($connection, "SELECT serial FROM post_reactions WHERE type = 'angry' AND feedline_serial = '$serial';");
            $angry_count = pg_num_rows($query_angry);

            $array = ['action' => $action, 'love_count' => $love_count, 'support_count' => $support_count, 'celebrate_count' => $celebrate_count, 'amazing_count' => $amazing_count, 'curious_count' => $curious_count, 'funny_count' => $funny_count, 'sad_count' => $sad_count, 'angry_count' => $angry_count];
            $json = json_encode($array);

            return $json;
        }
    }
}