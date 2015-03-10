<?php

$targ_w = $targ_h = 150;
$jpeg_quality = 90;

$src = 'http://images.puckermob.com/articlesites/puckermob/large/5788_tall.jpg';
$img_r = imagecreatefromjpeg($src);
$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

imagecopyresampled($dst_r,$img_r,0,0,0,0,
    $targ_w,$targ_h,700,400);

header('Content-type: image/jpeg');
imagejpeg($dst_r, null, $jpeg_quality);

?>