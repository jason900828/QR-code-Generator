<?php
header("Content-Type:text/html; charset=utf-8");

echo exec("pip3 install requests",$array, $ret);
echo exec("pip3 install BeautifulSoup4",$array, $ret);

?>