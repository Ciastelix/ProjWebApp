<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="./css/product.css">
    <title>Kategoria</title>
    <style>
    a{
        text-decoration: none;
        color: black;
    }
    a:hover{
        color: blue;
    }
    a:visited{
        color: black;
    }
    </style>
</head>
<body>
    <?php
    if (isset($_GET['id'])) {
        include('../cfg.php');
        include('./produkty.php');
        global $link;
        $id = (int) $_GET['id'];
        $result = mysqli_query($link, "SELECT nazwa,id FROM kategorie WHERE matka = $id");
        echo "<nav class='nav'>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='nav-item'>";
            echo "<a href='./kategoria.php?id=" . $row["id"] . "'>{$row['nazwa']}</a>";
            echo "</div>";

        }
        echo "</nav>";
        $result = mysqli_query($link, "SELECT tytul,id, zdjecie FROM produkty WHERE kategoria = $id");
        if (mysqli_num_rows($result) == 0) {
            echo "Brak produktów";
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='product-card'>";
                echo "<a href='produkt.php?id=" . $row["id"] . "'><h1>" . $row['tytul'] . "</h1></a><br/>";
                echo "<img src='{$row['zdjecie']}' width='200px' height='200px'><br/>";
                echo "</div>";
            }
        }

    } else {
        header("Location: ./index.php");
        exit;
    }
    ?>
</body>
</html>