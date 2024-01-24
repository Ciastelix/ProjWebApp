<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="./css/cart.css">
</head>
<body>

<?php
session_start();

function addToCart($id, $quantity, $price)
{
    $_SESSION['cart'] = [
        'id' => $id,
        'quantity' => $quantity,
        'price' => $price,

    ];

}

function clearCart()
{
    if (!isset($_GET['clear'])) {
        return;
    }
    unset($_SESSION['cart']);
    header("index.php");
    exit;
}
function order()
{
    include('../cfg.php');
    // global $link;

    if (!isset($_GET['order'])) {
        return;
    }
    $quantity = $_SESSION['cart']['quantity'];
    $productId = $_GET['order'];

    $sql = "UPDATE produkty SET ilosc_sztuk = ilosc_sztuk - " . $quantity . " WHERE id = {$productId}";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo mysqli_error($link);
        exit;
    }

    unset($_SESSION['cart']);
    echo "Zamówienie zostało złożone";
}
function removeFromCart()
{
    if (!isset($_GET['remove'])) {
        return;
    }
    $productId = $_GET['remove'];
    unset($_SESSION['cart'][$productId]);
}

function showCart()
{
    include('../cfg.php');
    // global $link;
    if (!isset($_GET['cart'])) {
        return;
    }
    $total = 0;
    if (!isset($_SESSION['cart'])) {
        echo "Koszyk jest pusty";
        return;
    }
    $product = $_SESSION['cart'];
    $sql = "SELECT * FROM produkty WHERE id = {$product['id']}";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $total += $product['price'];
    echo "<div class='cart-item'>";
    echo "<div class='cart-item-name'>";
    echo $row['tytul'];
    echo "</div>";
    echo "<div class='cart-item-price'>";
    echo "<p>Cena:" . $product['price'] . " zł</p>";
    echo "</div>";
    echo "<div class='cart-item-quantity'>";
    echo "<p>Ilość:" . $product['quantity'] . "</p>";
    echo "</div>";
    echo "<div class='cart-item-remove'>";
    echo "<a href='cart.php?remove=" . $product['id'] . "'>Usuń</a>";
    echo "</div>";
    echo "<div>";
    echo "<a href='cart.php?clear=1'>Wyczyść Koszyk</a>";
    echo "</div>";
    echo "<div>";
    echo "<a href='cart.php?order=" . $product['id'] . "'>Zamów</a>";
    echo "</div>";
    echo "</div>";



}
echo "<a href='index.php'>Powrót do strony głównej</a>";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
clearCart();
order();
showCart();
?>
</body>
</html>