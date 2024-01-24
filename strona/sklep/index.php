<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona główna</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    
    <?php
    include('../cfg.php');
    include('./kategorie.php');
    global $link;
    $sql = "SELECT * FROM produkty";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['ilosc_sztuk'] == 0) {
            $sql = "UPDATE produkty SET dostepnosc = 0 WHERE id = " . $row['id'];
            mysqli_query($link, $sql);

        }
    }
    echo PokazKategorieLink();
    ?>

</body>
</html>