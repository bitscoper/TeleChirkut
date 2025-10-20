<?php
/* By Abdullah As-Sadeed */

function Retrieve_Client_IP_Address()
{
    $includings_path = $GLOBALS['includings_path'];
    require_once $includings_path . 'Manually_Required/IP_Address_Validator.php';

    $ip_headers = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];

    foreach ($ip_headers as $ip_header) {
        if (isset($_SERVER[$ip_header])) {
            $ip_address = $_SERVER[$ip_header];

            if (Validate_IP_Address($_SERVER[$ip_header])) {
                return Sanitize_String($_SERVER[$ip_header]);
            }
        }
    }

    return false;
}