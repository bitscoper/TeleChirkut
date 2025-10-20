<?php
/* By Abdullah As-Sadeed */

function Generate_Client_Page()
{
    $includings_path = $GLOBALS['includings_path'];
    $javascript_nonce = $GLOBALS['javascript_nonce'];

    require_once $includings_path . 'Manually_Required/CSS_Bundler.php';
    require_once $includings_path . 'Manually_Required/TimeZone_Select_Generator.php';
    require_once $includings_path . 'Manually_Required/XHTML_Minifier.php';

    $xhtml = file_get_contents('../Client.xhtml');

    $css = Bundle_CSS();
    $xhtml = str_replace('<style></style>', '<style>' . $css . '</style>', $xhtml);

    $timezone_select_element = Generate_TimeZone_Select();
    $xhtml = str_replace('__SADEED_TIMEZONE_SELECT_ELEMENT__', $timezone_select_element, $xhtml);

    $xhtml = str_replace('__SADEED_NONCE__', $javascript_nonce, $xhtml);

    $xhtml = str_replace('__SADEED_TIME__', time(), $xhtml);

    $xhtml = Minify_XHTML($xhtml);

    return $xhtml;
}