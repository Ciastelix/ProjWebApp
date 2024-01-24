
<?php
//  Nagłówki kodu
session_start();

// Funkcja zwracająca listę podstron
function ListaPodstron()
{
    include('cfg.php');
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
    global $login, $pass;

    $wynik = '
    <div class="login-container">
        <h1 class="heading">Panel CMS:</h1>
        <div class="login-form">
            <form
                method="post"
                name="LoginForm"
                enctype="multipart/form-data"
                action="' . $_SERVER['REQUEST_URI'] . '"
            >
                <table class="login-table">
                    <tr>
                        <td class="login-label">[email]</td>
                        <td><input type="text" name="login_email" class="login-input" /></td>
                    </tr>
                    <tr>
                        <td class="login-label">[haslo]</td>
                        <td><input type="password" name="login_pass" class="login-input" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input
                                type="submit"
                                name="x1_submit"
                                value="Zaloguj"
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

function Wyloguj()
{
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
    }
}


?>
