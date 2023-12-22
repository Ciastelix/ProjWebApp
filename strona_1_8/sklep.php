<?php
function PokazKategorie()
{

    $conn = new mysqli('localhost', 'username', 'password', 'database');
    if ($conn->connect_error) {
        die('Błąd połączenia: ' . $conn->connect_error);
    }


    $sql = 'SELECT * FROM categories WHERE parent = 0 LIMIT 10';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        echo '<ul>';
        while ($row = $result->fetch_assoc()) {
            echo '<li>' . $row['name'] . '</li>';

            $sql2 = 'SELECT * FROM categories WHERE parent = ' . $row['id'];
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {

                echo '<ul>';
                while ($row2 = $result2->fetch_assoc()) {
                    echo '<li>' . $row2['name'] . '</li>';
                }
                echo '</ul>';
            }
        }
        echo '</ul>';
    } else {
        echo 'Brak kategorii';
    }


    $conn->close();
}
?>