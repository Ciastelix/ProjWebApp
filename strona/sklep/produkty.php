<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="./css/products.css">
</head>
<body>
    

<?php
include('../cfg.php');
function DodajProdukt()
{
    include('../cfg.php');
    global $link;
    if (isset($_POST['dodaj_prod'])) {
        echo "Formularz został przesłany.<br>";
        // Pobierz dane z formularza
        $tytul = mysqli_real_escape_string($link, $_POST['tytul']);
        $opis = mysqli_real_escape_string($link, $_POST['opis']);
        $data_utworzenia = date('Y-m-d'); // Pobierz aktualną datę i czas
        $data_wygasniecia = mysqli_real_escape_string($link, $_POST['data_wygasniecia']);
        $cena_netto = mysqli_real_escape_string($link, $_POST['cena_netto']);
        $podatek_vat = mysqli_real_escape_string($link, $_POST['podatek_vat']);
        $ills_sztuk = mysqli_real_escape_string($link, $_POST['ills_sztuk']);
        $status_dostepnosci = mysqli_real_escape_string($link, $_POST['status_dostepnosci']);
        $kategoria = mysqli_real_escape_string($link, $_POST['kategoria']);
        $gabaryt = mysqli_real_escape_string($link, $_POST['gabaryt']);

        // Przesyłanie pliku
        $sql = "SELECT MAX(id) AS id FROM produkty";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'] + 1;
        $nazwaPliku = $_FILES['zdjecie']['name'];
        $sciezkaTymczasowa = $_FILES['zdjecie']['tmp_name'];
        $sciezkaDocelowa = "uploads/" . $id . ".jpg";
        if (move_uploaded_file($sciezkaTymczasowa, $sciezkaDocelowa)) {
            echo "Plik został przesłany pomyślnie.<br>";
        } else {
            echo "Wystąpił błąd podczas przesyłania pliku.<br>";
            echo 'Błąd: ' . $_FILES['zdjecie']['error'] . '<br>';
        }

        // Wykonaj zapytanie SQL
        $sql = "INSERT INTO produkty (tytul, opis, data_utworzenia, data_wygasniecia, cena_netto, podatek_vat, ilosc_sztuk, status_dostepnosci, kategoria, gabaryt, zdjecie ) VALUES ('$tytul', '$opis', '$data_utworzenia', '$data_wygasniecia', '$cena_netto', '$podatek_vat', '$ills_sztuk', '$status_dostepnosci', '$kategoria', '$gabaryt', '$sciezkaDocelowa')";
        $result = mysqli_query($link, $sql);
        if ($result) {
            echo "Produkt został dodany pomyślnie.<br>";
        } else {
            echo "Błąd: " . mysqli_error($link);
        }
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

    }
    return '
    <form method="post" enctype="multipart/form-data">
        Tytuł: <input type="text" name="tytul"><br>
        Opis: <textarea name="opis"></textarea><br>
        Data wygaśnięcia: <input type="date" name="data_wygasniecia"><br>
        Cena netto: <input type="number" step="0.01" name="cena_netto"><br>
        Podatek VAT: <input type="number" step="0.01" name="podatek_vat"><br>
        Ilość sztuk: <input type="number" name="ills_sztuk"><br>
        Status dostępności: <input type="text" name="status_dostepnosci"><br>
        Kategoria: <input type="text" name="kategoria"><br>
        Gabaryt: <input type="text" name="gabaryt"><br>
        Zdjęcie: <input type="file" name="zdjecie"><br>
        <input type="submit" name="dodaj_prod" value="Dodaj">
    </form>';
}
function UsunProdukt()
{
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    global $link;
    if (!isset($_POST['wybierz_prod'])) {
        $sql = "SELECT id, tytul FROM produkty";
        $result = mysqli_query($link, $sql);
        echo '<form method="post">';
        echo 'Wybierz produkt do usunięcia: <select name="id_produktu">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row["id"] . '">' . $row["tytul"] . '</option>';
        }
        echo '</select><br>';
        echo '<input type="submit" name="wybierz_prod" value="Wybierz">';
        echo '</form>';
    } else {
        $id_produktu = $_POST['id_produktu'];
        $sql = "DELETE FROM produkty WHERE id = $id_produktu";
        unlink("./uploads/" . $id_produktu);
        if (mysqli_query($link, $sql)) {
            header("Location: " . $_SERVER['PHP_SELF']); // Odśwież stronę
            exit;
        } else {
            echo "Błąd: " . mysqli_error($link);
        }
    }
}
function PokazProdukty()
{
    global $link;
    $sql = "SELECT * FROM produkty";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "id: " . $row["id"] . " - Tytuł: " . $row["tytul"] . "<br/>";
        }
    } else {
        echo "Brak produktów.";
    }
}
function PokazProduktLink($id)
{
    global $link;
    $sql = "SELECT * FROM produkty WHERE id = $id";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo '<a href="produkt.php?id=' . $row["id"] . '">' . $row["tytul"] . '</a>';
    } else {
        echo "Brak produktów.";
    }
}
function PokazProdukt($id)
{
    global $link;
    $sql = "SELECT * FROM produkty WHERE id = $id";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row["tytul"] . "<br/><br/>Opis: " . $row["opis"] . "<br>" . $row["data_wygasniecia"] . "<br>" . $row["cena_netto"] . "<br>" . $row["podatek_vat"] . "<br>" . $row["ills_sztuk"] . "<br>" . $row["status_dostepnosci"] . "<br>" . $row["kategoria"] . "<br>" . $row["gabaryt"] . "<br>";
    } else {
        echo "Brak produktów.";
    }
}
function WybierzProduktDoEdycji()
{
    global $link;
    $sql = "SELECT * FROM produkty";
    $result = mysqli_query($link, $sql);
    echo '<form method="post">';
    echo '<select name="id_produktu">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row["id"] . '">' . $row["tytul"] . '</option>';
    }
    echo '</select>';
    echo '<input type="submit" name="wybierz_prod_e" value="Wybierz">';
    echo '</form>';
}

function EdytujProdukt()
{
    global $link;
    if (isset($_POST['wybierz_prod_e'])) {
        $id_produktu = $_POST['id_produktu'];
        $sql = "SELECT * FROM produkty WHERE id = $id_produktu";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
        echo '<form method="post">';
        echo '<input type="hidden" name="id_produktu" value="' . $id_produktu . '">'; // Dodajemy ukryte pole z ID produktu
        echo 'Tytuł: <input type="text" name="tytul" value="' . $row["tytul"] . '"><br>';
        echo 'Opis: <textarea name="opis">' . $row["opis"] . '</textarea><br>';
        echo 'Data wygaśnięcia: <input type="date" name="data_wygasniecia" value="' . $row["data_wygasniecia"] . '"><br>';
        echo 'Cena netto: <input type="number" name="cena_netto" value="' . $row["cena_netto"] . '"><br>';
        echo 'Podatek VAT: <input type="number" name="podatek_vat" value="' . $row["podatek_vat"] . '"><br>';
        echo 'Ilość sztuk: <input type="number" name="ills_sztuk" value="' . $row["ills_sztuk"] . '"><br>';
        echo 'Status dostępności: <input type="text" name="status_dostepnosci" value="' . $row["status_dostepnosci"] . '"><br>';
        echo 'Kategoria: <input type="text" name="kategoria" value="' . $row["kategoria"] . '"><br>';
        echo 'Gabaryt: <input type="text" name="gabaryt" value="' . $row["gabaryt"] . '"><br>';
        echo 'Zdjęcie: <input type="text" name="zdjecie" value="' . $row["zdjecie"] . '"><br>';
        echo '<input type="submit" name="aktualizuj_prod" value="Aktualizuj">';
        echo '</form>';
    }
    if (isset($_POST['aktualizuj_prod'])) {
        $id_produktu = $_POST['id_produktu'];
        $tytul = $_POST['tytul'];
        $opis = $_POST['opis'];
        $data_wygasniecia = $_POST['data_wygasniecia'];
        $cena_netto = $_POST['cena_netto'];
        $podatek_vat = $_POST['podatek_vat'];
        $ills_sztuk = $_POST['ills_sztuk'];
        $status_dostepnosci = $_POST['status_dostepnosci'];
        $kategoria = $_POST['kategoria'];
        $gabaryt = $_POST['gabaryt'];
        $zdj = '';
        if (isset($_POST['zdjecie'])) {
            $zdjecie = $_POST['zdjecie'];
            $zdj = ", zdjecie = '$zdjecie'";

        }
        $sql = "UPDATE produkty SET tytul = '$tytul', opis = '$opis', data_wygasniecia = '$data_wygasniecia', cena_netto = '$cena_netto', podatek_vat = '$podatek_vat', ills_sztuk = '$ills_sztuk', status_dostepnosci = '$status_dostepnosci', kategoria = '$kategoria', gabaryt = '$gabaryt' $zdj WHERE id = $id_produktu";
        if (mysqli_query($link, $sql)) {
            echo "Produkt został zaktualizowany pomyślnie.";
        } else {
            echo "Błąd: " . mysqli_error($link);
        }
    }
}
?>
</body>
</html>