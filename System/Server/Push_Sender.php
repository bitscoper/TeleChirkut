<?php
/* By Abdullah As-Sadeed */

require_once __DIR__ . '/../../3rd_Party_Includings/3rd_Party_PHP_Includings/Push/vendor/autoload.php';

use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

if (isset($argv[1]) && isset($argv[2])) {
    $argument_1 = $argv[1];
    $argument_1 = trim($argument_1);
    $push_json_string = base64_decode($argument_1);

    $argument_2 = $argv[2];
    $argument_2 = trim($argument_2);
    $data_json_string = base64_decode($argument_2);

    if ($push_json_string !== "" && $data_json_string !== "") {
        $push_json = json_decode($push_json_string, true);

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => 'mailto: <telechirkut@telechirkut.bitscoper.dev>',
                'publicKey' => 'REDUCTED_CREDENTIAL',
                'privateKey' => 'REDUCTED_CREDENTIAL',
            ],
        ]);

        $report = $webPush->sendOneNotification(
            Subscription::create($push_json),
            $data_json_string
        );

        $endpoint = $report->getRequest()->getUri()->__toString();

        if ($report->isSuccess()) {
            echo true;
        } else {
            echo $report->getReason();
        }
    }
}

exit();