<?php
/* By Abdullah As-Sadeed */

function Censor_String($string)
{
    $connection = $GLOBALS['connection'];

    $query_prohibited_strings = pg_query($connection, "SELECT prohibited FROM prohibited_strings;");

    while ($data_prohibited_strings = pg_fetch_assoc($query_prohibited_strings)) {
        $match_string = '/\b' . preg_quote($data_prohibited_strings['prohibited'], '/') . '\b/ium';

        $string = preg_replace_callback($match_string, function ($string_matches) {
            return '<span class="censored_text" data-type="string" data-original="' . $string_matches[0] . '">' . str_repeat('*', strlen($string_matches[0])) . '</span>';
        }, $string, -1);
    }

    $query_prohibited_emojis = pg_query($connection, "SELECT prohibited FROM prohibited_emojis;");

    while ($data_prohibited_emojis = pg_fetch_assoc($query_prohibited_emojis)) {
        $match_emoji = '/\x{' . dechex($data_prohibited_emojis['prohibited']) . '}/um';

        $string = preg_replace_callback($match_emoji, function ($emoji_matches) {
            return '<span class="censored_text" data-type="emoji" data-original="' . $emoji_matches[0] . '">***</span>';
        }, $string, -1);
    }

    return $string;
}
