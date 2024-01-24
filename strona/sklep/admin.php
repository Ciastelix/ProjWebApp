
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    
    <title>Panel Administratora</title>
    <style>
      .login-container {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
      }

      .heading {
        text-align: center;
        color: #333;
        font-size: 2em;
      }

      .login-input {
        width: 90%; /* Skrócone inputy */
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin: 0 auto; /* Wyśrodkowanie inputów */
      }

      .login-form input[type="submit"] {
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease; /* Dodane przejście */
      }

      .login-form input[type="submit"]:hover {
        background-color: #0056b3;
      }

      .login-table {
        width: 100%;
      }

      .login-label {
        text-align: right;
        padding-right: 10px;
      }

      .login-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
      }   
    .edit-category-form {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f8f8f8;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-heading {
        text-align: center;
        color: #333;
        font-size: 2em;
    }

    .form-input {
        width: 90%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-bottom: 10px;
    }

    .form-submit {
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        background-color: #007BFF;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .form-submit:hover {
        background-color: #0056b3;
    }

    
</style>
</head>
<body>
    <div class="container">
    <?php
    session_start();
    include('../cfg.php');
    include('./kategorie.php');
    include('./produkty.php');
    include("../admin.php");
    global $link;
    global $pass, $login;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {

        $username = $_POST['login_email'];
        $password = $_POST['login_pass'];

        if ($username === $login && $password === $pass) {
          $_SESSION['logged_in'] = true;
        } else {
          echo "Nieprawidłowy login lub hasło!";
        }
      }
    }

    if (isset($_SESSION['logged_in'])) {
      // Wyświetlanie opcji tylko dla zalogowanych użytkowników
      echo '<form method="post"><input type="submit" name="logout" value="Wyloguj"></form>';
      echo Wyloguj();
      echo '<br/><br/>';
      echo PokazKategorie();
      echo '<br/><br/>';
      echo DodajKategorie();
      echo '<br/><br/>';
      echo EdytujKategorie();
      echo '<br/><br/>';
      echo UsunKategorie();
      echo '<br/><br/>';
      echo "Lista produktów <br/>";
      echo PokazProdukty();
      echo '<br/><br/>';
      echo "Dodaj produkt <br/>";
      echo DodajProdukt();
      echo '<br/><br/>';
      echo EdytujProdukt();
      echo '<br/><br/>';
      echo UsunProdukt();
      echo '<br/><br/>';
      echo '<a href="index.php">Powrót do strony głównej</a>';
      echo ListaPodstron();
      echo EdytujPodstrone();
      echo UsunPodstrone();
      echo DodajNowaPodstrone();
    } else {
      // Wyświetlanie formularza logowania
      echo FormularzLogowania();
    }
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>
    
    
</body>
</html>