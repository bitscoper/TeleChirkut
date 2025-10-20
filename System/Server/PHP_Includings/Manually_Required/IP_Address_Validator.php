<?php
/* By Abdullah As-Sadeed */

function Validate_IP_Address($ip_address)
{
    return filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
}