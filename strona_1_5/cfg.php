<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$baza = "jazz";
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);
if (!$link) {
    echo "<b>przerwane połączenie</b>";
}
if (!mysqli_select_db($link, $baza)) {
    echo "<b>nie wybrano bazy danych</b>";
}
?>