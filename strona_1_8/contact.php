<?php
// ========================
// Początek funkcji PokazKontakt
// ========================

/**
 * Wyświetla formularz kontaktowy i obsługuje jego wysłanie.
 * 
 * Ta funkcja sprawdza, czy formularz został wysłany, a następnie przekazuje dane do funkcji WyslijMailKontakt.
 * 
 * @return string Formularz kontaktowy.
 */
function PokazKontakt()
{
    if (isset($_POST['submit'])) {
        // Zabezpieczenie przed atakami typu Code Injection
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

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

// ========================
// Początek funkcji WyslijMailKontakt
// ========================

/**
 * Wysyła e-mail z danymi z formularza kontaktowego.
 * 
 * Ta funkcja wysyła e-mail do określonego adresu e-mail z danymi z formularza kontaktowego.
 * 
 * @param string $name Imię osoby wysyłającej.
 * @param string $email Adres e-mail osoby wysyłającej.
 * @param string $message Wiadomość od osoby wysyłającej.
 * @return void
 */
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

// ========================
// Początek funkcji PrzypomnijHaslo
// ========================

/**
 * Wysyła e-mail z przypomnieniem hasła.
 * 
 * Ta funkcja wysyła e-mail do określonego adresu e-mail z przypomnieniem hasła.
 * 
 * @param string $email Adres e-mail, na który ma zostać wysłane przypomnienie.
 * @return void
 */
function PrzypomnijHaslo($email)
{
    $password = 'admin';
    $message = 'Twoje hasło to: ' . $password;

    WyslijMailKontakt('Admin', $email, $message);
}

echo PokazKontakt();

// ========================
// Koniec pliku
// ========================
?>