<?php
/* By Abdullah As-Sadeed */

function Generate_Page($title, $description, $additional_css, $if_fixed_body, $if_public_header, $body)
{
    $includings_path = $GLOBALS['includings_path'];
    $javascript_nonce = $GLOBALS['javascript_nonce'];

    require_once $includings_path . 'Manually_Required/CSS_Bundler.php';
    require_once $includings_path . 'Manually_Required/XHTML_Minifier.php';

    $page = '<!DOCTYPE html>
<!-- By Abdullah As-Sadeed -->
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8" />
<base href="https://telechirkut.bitscoper.dev/" />
<meta name="author" content="Abdullah As-Sadeed" />
<link rel="manifest" href="TeleChirkut.webmanifest" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="theme-color" content="rgb(66, 66, 66)" />
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<link rel="apple-touch-icon" href="Client_Includings/TeleChirkut_192.png" />
<meta name="keywords" content="TeleChirkut, Social, Network, Media, Medium, Telecommunication, Conversation, Messaging, Messenger"/>
<title>' . $title . '</title>
<meta name="description" content="' . $description . '"/>
<meta name="keywords" content="TeleChirkut"/>
<style>' . Bundle_CSS() . $additional_css . '</style>
</head>
<body lang="en-US"';

    if ($if_fixed_body) {
        $page .= ' class="fixed_body"';
    }

    $page .= '>
<div id="initialization_container">
    <div id="initialization">
        <img
            src="Client_Includings/TeleChirkut_48.png"
            alt=""
            id="initialization_icon"
        />
    </div>
</div>
<div id="container">';

    if ($if_public_header) {
        $page .= '<div id="header">
        <h3 id="unregistered_header_title">TeleChirkut</h3>
<a href="/" title="Home" target="_self" id="unregistered_header_link">Home</a>
</div>';
    }

    $page .= $body;

    $page .= '</div>
<div id="printing_alert">Printing any portion of TeleChirkut is forbidden!</div>
<script nonce="' . $javascript_nonce . '" src="/?javascript=' . time() . '"></script>
</body>
</html>';

    $page = Minify_XHTML($page);

    return $page;
}