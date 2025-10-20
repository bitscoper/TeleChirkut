<?php
/* By Abdullah As-Sadeed */

function Connect_DataBase()
{
    $GLOBALS['connection'] = pg_connect("host=localhost port=REDUCTED_CREDENTIAL user=postgres password=REDUCTED_CREDENTIAL dbname=telechirkut options='--client_encoding=UTF8 --application_name=TeleChirkut'");
    $connection = $GLOBALS['connection'];

    pg_set_error_verbosity($connection, PGSQL_ERRORS_VERBOSE);

    pg_set_client_encoding($connection, 'UTF8');
}
