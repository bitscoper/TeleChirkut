<?php
/* By Abdullah As-Sadeed */

if (isset($argv[1]) && isset($argv[2]) && isset($argv[3])) {
    $argument_1 = $argv[1];
    $argument_1 = trim($argument_1);
    $to = base64_decode($argument_1);

    $argument_2 = $argv[2];
    $argument_2 = trim($argument_2);
    $subject = base64_decode($argument_2);

    $argument_3 = $argv[3];
    $argument_3 = trim($argument_3);
    $body = base64_decode($argument_3);

    if ($to !== "" && $subject !== "" && $body !== "") {
        $headers = [
            'MIME-Version' => '1.0',
            'From' => 'TeleChirkut <telechirkut@telechirkut.bitscoper.dev>',
            'Content-Type' => 'text/plain; charset=utf8',
            'X-Mailer' => 'TeleChirkut',
            'Reply-To' => 'TeleChirkut <telechirkut@telechirkut.bitscoper.dev>',
            'Return-Path' => 'TeleChirkut <telechirkut@telechirkut.bitscoper.dev>',
            'List-Unsubscribe' => '<mailto:telechirkut@telechirkut.bitscoper.dev>',

        ];

        mail($to, $subject, $body, $headers);
    }
}

exit();