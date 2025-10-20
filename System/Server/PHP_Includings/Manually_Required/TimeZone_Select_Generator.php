<?php
/* By Abdullah As-Sadeed */

function Generate_TimeZone_Select()
{
    $connection = $GLOBALS['connection'];

    $select = '<select title="Select Timezone" name="timezone">
    <option value="" disabled>(Please select)</option>';

    $query_timezones = pg_query($connection, "SELECT timezone FROM timezones ORDER BY timezone ASC;");

    while ($data_timezones = pg_fetch_assoc($query_timezones)) {
        $timezone = $data_timezones['timezone'];

        $select .= '<option value="' . $timezone . '">' . $timezone . '</option>';
    }

    $select .= '</select>';

    return $select;
}