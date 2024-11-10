<?php
/* By Abdullah As-Sadeed */

function Bundle_CSS()
{

    $includings_path = $GLOBALS['includings_path'];
    require_once $includings_path . 'Manually_Required/CSS_Minifier.php';

    $css = '';

    $css .= file_get_contents('../../../3rd_Party_Includings/3rd_Party_CSS_Includings/Croppie/Croppie.css');

    foreach (glob('../Stylesheets/Default/*.css') as $stylesheets) {
        $css .= file_get_contents($stylesheets);
    }
    $css .= file_get_contents('../Stylesheets/Wide_Screen.css');

    $css = Minify_CSS($css);

    return $css;
}