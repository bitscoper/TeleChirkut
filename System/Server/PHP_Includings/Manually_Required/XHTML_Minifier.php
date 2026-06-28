<?php

/* By Abdullah As-Sadeed */

function Minify_XHTML($xhtml)
{
  $match = [
    "/\>[^\S ]+/s", // strip whitespaces after tags except space
    "/[^\S ]+\</s", // strip whitespaces before tags except space
    "/(\s)+/s", // shorten multiple whitespace sequences
  ];

  $replace = [">", "<", '\\1'];

  $xhtml = preg_replace($match, $replace, $xhtml);

  return $xhtml;
}
