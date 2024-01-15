<?php
function PokazKontakt()
{
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        WyslijMailKontakt($name, $email, $message);
    }
    return '
    <form method="post" action="">
        <label for="name">Imię:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email"><br>
        <label for="message">Wiadomość:</label><br>
        <textarea id="message" name="message"></textarea><br>
        <input type="submit" name="submit" value="Wyślij">
    </form>
    ';
}

function WyslijMailKontakt($name, $email, $message)
{
    $to = 'tenlegitmati@gmail.com';
    $subject = 'Nowa wiadomość od ' . $name;
    $headers = 'From: ' . $email;

    if (mail($to, $subject, $message, $headers)) {
        echo "Wiadomość wysłana pomyślnie!";
    } else {
        echo "Wystąpił błąd podczas wysyłania wiadomości.";
    }
}

function PrzypomnijHaslo($email)
{
    $password = 'admin';
    $message = 'Twoje hasło to: ' . $password;

    WyslijMailKontakt('Admin', $email, $message);
}
echo PokazKontakt();
?>