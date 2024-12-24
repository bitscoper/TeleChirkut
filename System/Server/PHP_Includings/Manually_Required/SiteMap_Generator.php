<?php
/* By Abdullah As-Sadeed */

function Generate_SiteMap()
{
    $connection = $GLOBALS['connection'];

    $sitemap = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
    $sitemap->addAttribute('xmlns:comment', 'By Abdullah As-Sadeed');

    $static_urls = [
        'https://telechirkut.bitscoper.dev/',
        'https://telechirkut.bitscoper.dev/rules',
        'https://telechirkut.bitscoper.dev/registration',
        'https://telechirkut.bitscoper.dev/#owner'
    ];

    foreach ($static_urls as $url) {
        $url_element = $sitemap->addChild('url');
        $url_element->addChild('loc', $url);
    }

    $query_profile_codes = pg_query($connection, 'SELECT profile_code FROM users ORDER BY profile_code ASC;');
    while ($data_profile_code = pg_fetch_assoc($query_profile_codes)) {
        $url_element = $sitemap->addChild('url');
        $url_element->addChild('loc', 'https://telechirkut.bitscoper.dev/#profile=' . $data_profile_code['profile_code']);
    }

    $dom = dom_import_simplexml($sitemap)->ownerDocument;
    $dom->formatOutput = true;

    return $dom->saveXML();
}