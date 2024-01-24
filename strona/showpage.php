<?php
// ========================
// Funkcja PokazStrone
// ========================
// Ta funkcja pobiera id strony jako parametr, zabezpiecza go przed atakami typu Code Injection,
// a następnie wykonuje zapytanie SQL do bazy danych, aby pobrać zawartość strony o danym id.
// Jeśli strona o danym id nie istnieje, funkcja zwraca komunikat o błędzie.
// W przeciwnym razie zwraca zawartość strony.

// Dołączanie pliku konfiguracyjnego
include('cfg.php');

function PokazStrone($id)
{
    // Użycie zmiennej globalnej $link do połączenia z bazą danych
    global $link;

    // Zabezpieczenie zmiennej $id przed atakami typu Code Injection
    $id_clear = htmlspecialchars($id);

    // Zapytanie SQL do pobrania strony o danym id
    $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";

    // Wykonanie zapytania SQL
    $result = mysqli_query($link, $query);

    // Pobranie wyników zapytania
    $row = mysqli_fetch_array($result);

    // Sprawdzenie, czy strona o danym id istnieje
    if (empty($row)) {
        // Jeśli strona nie istnieje, wyświetl komunikat o błędzie
        echo "Nie znaleziono strony";
    } else {
        // Jeśli strona istnieje, zapisz jej zawartość do zmiennej $web
        $web = $row['page_constent'];
    }

    // Zwróć zawartość strony
    return $web;
}
?>