<?php
/* By Abdullah As-Sadeed */

function Generate_Error_Page($error_code, $error_details)
{
    $additional_css = '';

    $body = '<div id="information">
<h2>Error ' . $error_code . '</h2>
<div id="details">' . $error_details . '</div>
</div>';

    return Generate_Page('Error ' . $error_code . ' - TeleChirkut', 'Error ' . $error_code . ' - ' . $error_details, $additional_css, true, true, $body);
}
