<?php
/* By Abdullah As-Sadeed */

$includings_path = '../../Server/PHP_Includings/';
require_once $includings_path . 'Manually_Required/CSS_Bundler.php';
?>
<!DOCTYPE html>
<!-- By Abdullah As-Sadeed -->
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8" />
    <base href="https://telechirkut.bitscoper.dev/" />
    <meta name="author" content="Abdullah As-Sadeed" />
    <link rel="manifest" href="TeleChirkut.webmanifest" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="rgb(66, 66, 66)" />
    <link rel="apple-touch-icon" href="Client_Includings/TeleChirkut_192.png" />
    <style>
        <?php
        echo Bundle_CSS();
        ?>
    </style>
    <title>Offline - TeleChirkut</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="description" content="You are offline now!" />
</head>

<body lang="en-US" class="fixed_body">
    <div id="container">
        <div id="header">
            <h3 id="unregistered_header_title">TeleChirkut</h3>
        </div>
        <div id="information">
            <h2>You are offline now</h2>
        </div>
    </div>
    <div id="printing_alert">Printing any portion of TeleChirkut is forbidden!</div>
    <script>
        /* By Abdullah As-Sadeed */
        document.oncontextmenu = function (menu) {
            menu.preventDefault();
            Show_Alert("Context Menues are not allowed");
            return false;
        };
        window.ononline = function () {
            document.getElementById("waiting").style.opacity = 1;
            window.location.reload();
        };
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("TeleChirkut.js");
        }
    </script>
</body>

</html>
<?php
exit();
?>