<?php
header("Content-Type:text/html; charset=utf-8");


$title=exec("python ../py/youtubecrawler.py ".$_GET['url'].' ',$array, $ret);//2>error.txt 2>&1

$title=iconv(mb_detect_encoding($title), "UTF-8",  $title);
echo $title;
?>
