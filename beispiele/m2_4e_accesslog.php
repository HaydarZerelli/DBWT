<?php
/**
 * Praktikum DBWT. Autoren
 * Philipp, Hünnerscheidt, 3192361
 * Haydar, Zerelli, 3204408
 */
$file = fopen("./accesslog.txt", "a");
if(!$file) {
    die("öffnen fehlgeschlagen!");
}
date_default_timezone_set('UTC');
$log = ['date' => date('d-m-Y  H:i:s'), 'user-agent' => $_SERVER['HTTP_USER_AGENT'], 'IP' => $_SERVER['REMOTE_ADDR']];
fwrite($file, $log);
fclose($file);

var_dump(date('d-m-Y  H:i:s'));
?>