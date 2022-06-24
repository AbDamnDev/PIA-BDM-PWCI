<?php
//include_once __DIR__."News_class.php";
include_once 'News_class.php';

$var = new News();
$res = $var->getDashboard();
$res2 = $var->topLikes();
$res3 = $var->ActiveCatsWActiveNews();
?>