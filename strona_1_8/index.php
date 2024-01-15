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
    <script src="./js/kolorujtlo.js"></script>
    <script src="./js/dropdown.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Strona główna</title>
  </head>
  <body>
     <?php
     // Wyłączanie wyświetlania błędów typu NOTICE i WARNING
     error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

     // Zabezpieczenie zmiennej $_GET przed atakami typu Code Injection
     $idp = htmlspecialchars($_GET['idp']);

     // Wybór strony do wyświetlenia na podstawie zmiennej $_GET['idp']
     if (!isset($idp)) {
       $strona = './html/glowna.html';
     } elseif ($idp == 'glowna' && file_exists('./html/glowna.html')) {
       $strona = './html/glowna.html';
     } elseif ($idp == 'filmy' && file_exists('./html/filmy.html')) {
       $strona = 'html/filmy.html';
     } elseif ($idp == 'louis' && file_exists('./html/louis.html')) {
       $strona = 'html/louis.html';
     } elseif ($idp == 'charlie' && file_exists('./html/charlie.html')) {
       $strona = 'html/charlie.html';
     } elseif ($idp == 'ella' && file_exists('./html/ella.html')) {
       $strona = 'html/ella.html';
     } elseif ($idp == 'josh' && file_exists('./html/josh.html')) {
       $strona = 'html/josh.html';
     } elseif ($idp == 'nina' && file_exists('./html/nina.html')) {
       $strona = 'html/nina.html';
     } elseif ($idp == 'historia' && file_exists('./html/historia.html')) {
       $strona = './html/historia.html';
     } else {
       $strona = './html/strona_bledu.html';
     }
     ?>
    <nav class="nav">
      <div class="nav-item">
        <a href="index.php">strona główna</a>
      </div>

      <div class="nav-item">
        <a href="index.php?idp=historia">historia</a>
      </div>
      <div class="nav-item">
        <a href="index.php?idp=filmy">filmy</a>
      </div>
      <div class="dropdown nav-item">
        TWÓRCY
        <div class="dropdown-content">
          <a href="index.php?idp=louis">Louis Armstrong</a>
          <a href="index.php?idp=charlie">Charlie Parker</a>
          <a href="index.php?idp=ella">Ella Fitzgerald</a>
          <a href="index.php?idp=josh">John Coltrane</a>
          <a href="index.php?idp=nina">Nina Simone</a>
        </div>
      </div>
    </nav>

    <?php
    // Włączanie wybranej strony
    include($strona);
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