<?php
$arr = "dhakdhkjahjkda  [12313 ] => 12312321 dakhdkja  '123123'";

$pattern = "/(?<!['\d])(\d+)(?!['\d])/";
// $pattern = '/(?!\'))(?:\d+)/';
$matches = array();
$lio_arr = preg_match_all($pattern, $arr,$matches,PREG_PATTERN_ORDER);
print_r($matches[0]);
?>
