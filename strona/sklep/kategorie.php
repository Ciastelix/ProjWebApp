<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="./css/categories.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php
include('../cfg.php');

// ========================
// DodajKategorie
// ========================
function DodajKategorie()
{
    global $link;
    if (isset($_POST['dodaj'])) {
        $nazwa = mysqli_real_escape_string($link, $_POST['nazwa']);
        $matka = (int) $_POST['matka'];
        mysqli_query($link, "INSERT INTO kategorie (nazwa, matka) VALUES ('$nazwa', $matka)");
        header("Location: " . $_SERVER['PHP_SELF']); // Odśwież stronę
        exit;
    }
    return '
    <form method="post">
        <h2>Dodaj Kategorię</h2>
        Nazwa: <input type="text" name="nazwa"><br>
        Matka: <input type="number" name="matka"><br>
        <input type="submit" name="dodaj" value="Dodaj">
    </form>';
}

// ========================
// UsunKategorie
// ========================
function UsunKategorie()
{
    global $link;
    if (isset($_POST['usun'])) {
        $id = (int) $_POST['id'];
        mysqli_query($link, "DELETE FROM kategorie WHERE id = $id");
        header("Location: " . $_SERVER['PHP_SELF']); // Odśwież stronę
        exit;
    }

    // Pobierz wszystkie kategorie
    $result = mysqli_query($link, "SELECT id, nazwa FROM kategorie");
    $options = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='{$row['id']}'>{$row['nazwa']}</option>";
    }

    return '
    <form method="post">
        <h2>Usuń Kategorię</h2>
        Kategoria: <select name="id">' . $options . '</select><br>
        <input type="submit" name="usun" value="Usuń">
    </form>';
}

// ========================
// EdytujKategorie
// ========================
function EdytujKategorie()
{
    global $link;
    if (isset($_POST['edytuj'])) {
        $id = (int) $_POST['id'];
        $nazwa = mysqli_real_escape_string($link, $_POST['nazwa']);
        $matka = (int) $_POST['matka'];
        mysqli_query($link, "UPDATE kategorie SET nazwa = '$nazwa', matka = $matka WHERE id = $id");
        header("Location: " . $_SERVER['PHP_SELF']); // Odśwież stronę
        exit;
    }
    return '
    <form method="post" class="edit-category-form">
        <h2 class="form-heading">Edytuj Kategorię</h2>
        ID: <input type="number" name="id" class="form-input"><br>
        Nazwa: <input type="text" name="nazwa" class="form-input"><br>
        Matka: <input type="number" name="matka" class="form-input"><br>
        <input type="submit" name="edytuj" value="Edytuj" class="form-submit">
    </form>';
}




// ========================
// PokazKategorie
// ========================
function PokazKategorie()
{
    global $link;
    $result = mysqli_query($link, "SELECT * FROM kategorie WHERE matka = 0");
    if (!$result) {
        return 'Błąd zapytania';
    }
    if (mysqli_num_rows($result) == 0) {
        return '<h2>Brak kategorii</h2>';
    }
    $output = '<h2>kategorie:</h2><ul>';

    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<li>' . $row['nazwa'] . ' - ' . $row['id'] . '<ul>';
        $result2 = mysqli_query($link, "SELECT * FROM kategorie WHERE matka = " . $row['id']);
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $output .= '<li>' . $row2['nazwa'] . ' - ' . $row2['id'] . '</li>';
        }
        $output .= '</ul></li>';
    }
    $output .= '</ul>';
    return $output;
}
function PokazKategorieLink()
{
    global $link;
    $result = mysqli_query($link, "SELECT * FROM kategorie WHERE matka = 0");
    if (!$result) {
        return 'Błąd zapytania';
    }
    $output = "<nav class='nav'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= '<div class="nav-item"><a href="kategoria.php?id=' . $row['id'] . '">' . $row['nazwa'] . '</a></div>';
    }
    $output .= '</div>';
    return $output;
}

?>
