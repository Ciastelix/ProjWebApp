<?php
// ========================
// Początek konfiguracji bazy danych
// ========================

// Dane logowania
$login = "admin";
$pass = "admin";

// Dane serwera bazy danych
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$baza = "jazz";

// Nawiązanie połączenia z bazą danych
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);

// Sprawdzenie, czy połączenie z bazą danych zostało nawiązane
if (!$link) {
    die("<b>przerwane połączenie</b>");
}

// Wybór bazy danych
if (!mysqli_select_db($link, $baza)) {
    die("<b>nie wybrano bazy danych</b>");
}

// Sprawdzenie, czy wystąpił błąd podczas nawiązywania połączenia z bazą danych
if (mysqli_connect_errno()) {
    printf("Błąd połączenia: %s\n", mysqli_connect_error());
    exit();
}

// ========================
// Koniec konfiguracji bazy danych
// ========================
?>