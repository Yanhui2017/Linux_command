<?php
date_default_timezone_set('UTC'); 
//echo date('j');
$ymd = date('YmdHis',time());
$first = rand(1,9);
echo intval($first.$ymd).'==='.strlen(intval($first.$ymd));
echo "\n";
?>
