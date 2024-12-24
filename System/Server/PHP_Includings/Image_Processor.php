<?php
/* By Abdullah As-Sadeed */

function Process_Image($input_file, $width, $height, $output_file)
{
    $image_file = imagecreatefromstring(file_get_contents($input_file));

    $original_width = imagesx($image_file);
    $original_height = imagesy($image_file);

    if ($original_width < $width) {
        $output_width = $original_width;
    }
    else {
        $output_width = $width;
    }

    if ($height !== -1) {
        if ($original_height < $height) {
            $output_height = $original_height;
        }
        else {
            $output_height = $height;
        }
    }
    elseif ($height == -1) {
        $output_height = $height;
    }

    imagewebp(imagescale($image_file, $output_width, $output_height, IMG_BICUBIC), $output_file, 100);
}