<?php
/* By Abdullah As-Sadeed */

function Bundle_JavaScript($is_development_mode)
{
    $third_party_includings = '../../../3rd_Party_Includings/';

    $javascript = '"use strict";';

    $javascript .= file_get_contents($third_party_includings . '3rd_Party_JavaScript_Includings/Croppie/Croppie.js');

    foreach (glob('../JavaScript_Includings/*.js') as $javascript_including) {
        $javascript .= file_get_contents('../JavaScript_Includings/' . $javascript_including);
    }
    $javascript .= file_get_contents('../Executive.js');

    if ($is_development_mode) {
        $javascript = preg_replace('/console\.clear\(\);/', '/* console.clear(); */', $javascript);
    }

    if (!$is_development_mode) {
        require_once $third_party_includings . '3rd_Party_PHP_Includings/JShrink/Minifier.php';
        require_once $third_party_includings . '3rd_Party_PHP_Includings/HunterObfuscator/HunterObfuscator.php';

        $javascript = Minifier::minify($javascript);

        $obfuscator = new HunterObfuscator($javascript);
        $obfuscator->addDomainName('telechirkut.bitscoper.dev');
        $javascript = $obfuscator->Obfuscate();
    }

    $javascript = '/* By Abdullah As-Sadeed */' . $javascript;

    return $javascript;
}