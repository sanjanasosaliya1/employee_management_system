<?php
session_start();

$txt=rand(10000,99999);

$_SESSION["vercode"]=$txt;
$height=25;
$width=65;

$image=imagecreate($width,$height);
$black=imagecolorallocate($image,0,0,0);
$white=imagecolorallocate($image,255,255,255);

$font=14;

imagestring($image,$font,5,5,$txt,$white);
imagejpeg($image);
?>