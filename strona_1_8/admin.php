<?php
//  Nagłówki kodu
session_start();
include('cfg.php');

// Funkcja zwracająca listę podstron
function ListaPodstron()
{
    global $link;

    $query = "SELECT * FROM page_list LIMIT 100";
    $result = mysqli_query($link, $query);

    if (!$result) {
        die('Błąd zapytania: ' . mysqli_error($link));
    }

    $pages = '';
    while ($row = mysqli_fetch_array($result)) {
        $pages .= $row['id'] . ' ' . $row['page_title'] . ' <br/> ';
    }

    return $pages;
}

// Funkcja edytująca podstronę
function EdytujPodstrone()
{
    global $link;

    if (isset($_POST['id'], $_POST['title'], $_POST['content'], $_POST['active'])) {
        $id = mysqli_real_escape_string($link, $_POST['id']);
        $title = mysqli_real_escape_string($link, $_POST['title']);
        $content = mysqli_real_escape_string($link, $_POST['content']);
        $active = $_POST['active'] ? 1 : 0;

        $query = "UPDATE page_list SET page_title = '$title', page_content = '$content', status = $active WHERE id = '$id' LIMIT 1";
        mysqli_query($link, $query);
    }

    $form = '
    <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" />

        <label for="title">Tytuł:</label>
        <input type="text" id="title" name="title" />

        <label for="content">Treść:</label>
        <textarea id="content" name="content"></textarea>

        <label for="active">Aktywna:</label>
        <input type="checkbox" id="active" name="active" />

        <input type="submit" value="Zapisz" />
    </form>
    ';

    return $form;
}

// Funkcja usuwająca podstronę
function UsunPodstrone()
{
    global $link;
    if (isset($_POST['id'])) {
        $id = htmlspecialchars($_POST['id']);
        $query = "DELETE FROM page_list WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($link, $query);
        if (!$result) {
            die('Błąd zapytania: ' . mysqli_error($link));
        } else {
            echo "Usunięto podstronę";
        }
    }

    $form = '
    <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" />

        <input type="submit" value="Usuń" />
    </form>
    ';

    return $form;
}

// Funkcja dodająca nową podstronę
function DodajNowaPodstrone()
{
    global $link;
    if (isset($_POST['title'], $_POST['content'], $_POST['active'])) {
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $active = $_POST['active'] ? 1 : 0;

        $query = "INSERT INTO page_list (`page_title`, `page_content`, `status`) VALUES ('$title', '$content', $active)";
        $result = mysqli_query($link, $query);
        if (!$result) {
            die('Błąd zapytania: ' . mysqli_error($link));
        } else {
            echo "Dodano nową podstronę";
        }
    }

    $form = '
    <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
        <label for="title">Tytuł:</label>
        <input type="text" id="title" name="title" />
        <br/><br/>

        <label for="content">Treść:</label>
        <textarea id="content" name="content"></textarea>
        <br/><br/>
        <label for="active">Aktywna:</label>
        <input type="checkbox" id="active" name="active" />
        <br/><br/>
        <input type="submit" value="Dodaj" />
    </form>
    ';

    return $form;
}

// Funkcja generująca formularz logowania
function FormularzLogowania()
{
    $message = '';
    if (isset($_SESSION['error_message'])) {
        $message = '<p class="error">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']);
    }
    $wynik = $message = '
    <div class="logowanie">
        <h1 class="heading">Panel CMS:</h1>
        <div class="logowanie">
            <form
                method="post"
                name="LoginForm"
                enctype="multipart/form-data"
                action="' . $_SERVER['REQUEST_URI'] . '"
            >
                <table class="logowanie">
                    <tr>
                        <td class="log4_t">[email]</td>
                        <td><input type="text" name="login_email" class="logowanie" /></td>
                    </tr>
                    <tr>
                        <td class="log4_t">[haslo]</td>
                        <td><input type="password" name="login_pass" class="logowanie" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input
                                type="submit"
                                name="x1_submit"
                                value="Zaloguj"
                                class="logowanie"
                            />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    ';
    return $wynik;
}

// Logika logowania
if (isset($_POST['x1_submit'])) {
    $login_email = $_POST['login_email'];
    $login_pass = $_POST['login_pass'];

    if ($login_email == $login && $login_pass == $pass) {
        $_SESSION['logged_in'] = true;
    } else {
        $_SESSION['error_message'] = 'Niepoprawne dane logowania.';
    }
}

// Sprawdzenie sesji zalogowanego użytkownika
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    // Wyświetlanie opcji tylko dla zalogowanych użytkowników
    echo "Dodaj nową podstronę <br/>";
    echo DodajNowaPodstrone();
    echo '<br/><br/>';
    echo "Lista podstron <br/>";
    echo ListaPodstron();
    echo '<br/><br/>';
    echo "Edytuj podstronę <br/>";
    echo EdytujPodstrone();
    echo '<br/><br/>';
    echo "Usuń podstronę <br/>";
    echo UsunPodstrone();
    echo '<br/><br/>';
    echo '<a href="index.php">Powrót do strony głównej</a>';
} else {
    // Wyświetlanie formularza logowania
    echo FormularzLogowania();
}
?>
