<?php
// ========================
// Początek pliku
// ========================

// Dołączanie pliku konfiguracyjnego
include('./cfg.php');
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Mateusz Zwierzyński" />
    <link rel="stylesheet" href="./css/styles.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Strona główna</title>
  </head>
  <body>
    <nav class="nav">
           <?php
           // Wyłączanie wyświetlania błędów typu NOTICE i WARNING
           error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

           global $link;
           $sql = "SELECT * from page_list";
           $result = mysqli_query($link, $sql);
           if (!$result) {
             echo mysqli_error($link);
             exit;
           }
           $num_rows = mysqli_num_rows($result);
           $width = 100 / ($num_rows + 1);

           while ($row = mysqli_fetch_assoc($result)) {
             echo "<div class='nav-item' style='width: {$width}%;'>";
             echo "<a href='./?page={$row['id']}'>{$row['page_title']}</a>";
             echo "</div>";
           }
           echo "<div class='nav-item' style='width: {$width}%;'>";
           echo "<a href='./sklep'>sklep</a>";
           echo "</div>";

           ?>
    </nav>

    <?php
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 4;
    }
    global $link;
    $sql = "SELECT * from page_list WHERE id = $page";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    echo "<div class='content'>";
    echo "<p>{$row['page_content']}</p>";
    echo "</div>";

    ?>

    <script>
      // Skrypt jQuery do animacji przejścia między stronami
      $(document).ready(function () {
        $("a").click(function (event) {
          event.preventDefault();
          var link = $(this).attr("href");
          $("body").addClass("leaving");
          setTimeout(function () {
            window.location.href = link;
          }, 500);
        });
      });
    </script>
  </body>
</html>

<?php
// Wyświetlanie informacji o autorze
$nr_indeksu = 167368;
$nrGrupy = 4;
echo "Autor: Mateusz Zwierzyński, nr indeksu: $nr_indeksu, grupa: $nrGrupy</br></br>"
  ?>