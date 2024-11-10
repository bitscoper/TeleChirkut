<?php
/* By Abdullah As-Sadeed */

function Ensure_Paired_Cookies()
{
    if ((isset($_COOKIE['TeleChirkut_1']) && !isset($_COOKIE['TeleChirkut_2'])) || (!isset($_COOKIE['TeleChirkut_1']) && isset($_COOKIE['TeleChirkut_2']))) {
        $includings_path = $GLOBALS['includings_path'];
        require_once $includings_path . 'Manually_Required/Logger_Out.php';

        Log_Out();
    }
}