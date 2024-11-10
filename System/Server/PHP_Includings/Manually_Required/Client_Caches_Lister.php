<?php
/* By Abdullah As-Sadeed */

function List_Client_Caches()
{
    $list = [];

    $client_includings_list = array_diff(scandir('Client_Includings'), ['.', '..']);

    foreach ($client_includings_list as $client_including) {
        $list[] = 'Client_Includings/' . $client_including;
    }

    $list[] = 'favicon.ico';

    $list[] = 'offline.php';

    $array = ['caches' => $list];
    $json = json_encode($array);

    return $json;
}
