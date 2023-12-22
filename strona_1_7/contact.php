<?php

function PokazKontakt() {
    echo '<form action="contact.php" method="post">
        Temat: <input type="text" name="temat"><br>
        E-mail: <input type="text" name="email"><br>
        Wiadomość: <textarea name="tresc"></textarea><br>
        <input type="submit" name="submit" value="Wyślij">
    </form>';
}

function WyslijMailKontakt($odbiorca) {
    if(empty($_POST["temat"])||empty($_POST["tresc"]) || empty($_POST["email"])) {
        echo "Nie wypełniono wszystkich pól";
        echo PokazKontakt();
    } else {
        $mail["subject"] = $_POST["temat"];
        $mail["message"] = $_POST["tresc"];
        $mail["sender"] = $_POST["email"];
        $mail["receiver"] = $odbiorca;
        $header = "From Formularz Kontaktowy" . $mail["sender"] . "\r\n";
        $header .= "Content-type: text/html; charset=utf-8\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "X-Mailer: PHP/" . phpversion();
        mail($mail["receiver"], $mail["subject"], $mail["message"], $header);
        echo "Wiadomość została wysłana";
    }
}

function PrzypomnijHaslo($odbiorca, $haslo) {
    if(empty($odbiorca) || empty($haslo)) {
        echo "Nie podano adresu e-mail lub hasła";
    } else {
        $mail["subject"] = "Przypomnienie hasła";
        $mail["message"] = "Twoje hasło to: " . $haslo;
        $mail["sender"] = "admin@twojastrona.pl";
        $mail["receiver"] = $odbiorca;
        $header = "From: " . $mail["sender"] . "\r\n";
        $header .= "Content-type: text/html; charset=utf-8\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "X-Mailer: PHP/" . phpversion();
        mail($mail["receiver"], $mail["subject"], $mail["message"], $header);
        echo "Wiadomość z hasłem została wysłana";
    }
}


?>
