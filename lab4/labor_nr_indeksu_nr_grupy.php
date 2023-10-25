<html>
    <head></head>
    <body>

    <div>
<?php
$nr_indeksu = '167368';
$nr_grupy="4";
echo "Mateusz Zwierzyński ". $nr_indeksu ." grupa ". $nr_grupy ."<br/><br/>";
echo "Zastosowanie metody include() <br/>";
include("d.php");
echo '<p>' . $dat . '</p>';
echo "Zastosowanie metody require_once() <br/>";
require_once("fruits.php");
echo '<p>' . $fruit . '</p>';
echo "Zastosowanie metody GET <br/>";
echo '<a href="index.php?age=30">Click me</a>';
if (isset($_GET["age"])){
    echo "masz " . $_GET["age"] . " lat";
}
$i = 0;
while ($i < 4) {
    echo '<p>paragraf nr ' . $i . '</p>';
    $i += 1;
}

for ($i = 0; $i < 4; $i++) {
    echo '<span>span nr ' . $i . '</span><br/>';
}
if ($_SERVER["REQUEST_METHOD"] == "GET"){
    
    echo "
    <form method=\"post\">
    <input type=\"text\" name=\"name\" placeholder=\"imie\"/>
    <input type=\"submit\" value=\"Wyślij\">
  </form>
    in
    ";
}
elseif ($_SERVER["REQEST_METHOD"] == "POST"){
    if (isset($_POST["name"])) {
        echo 'witaj ' . $_POST['name'] . '<br/>';
    }
    else{
        echo "Nie podano danych danych";
    }
}
else{
    echo "Nieznana metoda";
}
// start session and if it's not started yet
echo "Sesja <br/>";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Ustawiono zmienne sesji.";
echo "<br/>";
echo "Zmienna sesji favcolor: " . $_SESSION["favcolor"];
echo "<br/>";
echo "Zmienna sesji favanimal: " . $_SESSION["favanimal"];
echo "<br/>";
echo "Zawartość zmiennej sesji: ";
print_r($_SESSION);
echo "<br/>";
echo "kończę sesje";
if (session_status() == PHP_SESSION_ACTIVE) {
    session_destroy();
}

?>
</div>
</body>
</html>