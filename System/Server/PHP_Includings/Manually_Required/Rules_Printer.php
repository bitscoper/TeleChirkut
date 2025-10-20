<?php
/* By Abdullah As-Sadeed */

function Print_Rules($make_page)
{
    $rules_file = '../../Server/Data_For_Generation/Rules.xhtml';
    $privacy_policy_file = '../../Server/Data_For_Generation/Privacy_Policy.xhtml';

    $rules = file_get_contents($rules_file) . '<hr/>' . file_get_contents($privacy_policy_file);

    if ($make_page) {
        $body = '<div id="sub_header">
<h4>Rules</h4>
</div>
<div id="rules_page">' . $rules . '</div>';

        return Generate_Page('Rules - TeleChirkut', 'Read the TeleChirkut Rules carefully.', '', false, true, $body);
    } elseif (!$make_page) {
        return $rules;
    }
}