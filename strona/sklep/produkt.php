<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="./css/item.css">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();
    include('../cfg.php');
    include("./cart.php");
    global $link;
    if (isset($_GET["id"])) {
        $sql = "SELECT * FROM produkty WHERE id = {$_GET['id']}";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) == 0) {
            echo "Brak produktu";
        } else {
            echo '<div class="product-container">';
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['status_dostepnosci'] == 0) {
                    continue;
                }
                echo "<h1>{$row['tytul']}</h1>";
                echo "<img src='{$row['zdjecie']}' width='200px' height='200px'><br/>";
                echo "<p>{$row['opis']}</p>";
                echo "<p>Cena: {$row['cena_netto']} + {$row['podatek_vat']} zł</p>";
                echo "<p>Dostępnych: {$row['ilosc_sztuk']}</p>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='id' value='{$_GET['id']}'>";
                echo "<input type='number' name='ilosc' value='1', max='" . $row['ilosc_sztuk'] . "' min='1'/>";
                echo "<input type='hidden' name='cena_netto' value={$row['cena_netto']}>";
                echo "<input type='hidden'  name='podatek_vat' value={$row['podatek_vat']}>";
                echo "<input type='submit' name='dodaj' value='Dodaj do koszyka'>";
                echo "</form>";
                if (isset($_POST['dodaj'])) {
                    addToCart($_GET['id'], $_POST['ilosc'], (int) ($_POST['cena_netto'] + $_POST['podatek_vat']));
                    header("Location: ./cart.php?cart=1");
                    exit;
                }
            }
            echo '</div>';
        }
    }
    ?>
    
</body>
</html>