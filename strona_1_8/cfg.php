<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$baza = 'jazz_strona';
$login = 'admin';
$pass = 'admin';

$link = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$link)
    echo '<b> przerwane połączenie </b>';
if (!mysql_select_db($baza))
    echo 'nie wybrano bazy';

?>