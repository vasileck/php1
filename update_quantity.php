<?php
require_once 'CProducts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['quantity'])) {
    $products = new CProducts();
    $id = (int)$_POST['id'];
    $quantity = (int)$_POST['quantity'];
    $products->updateProductQuantity($id, $quantity);
}
?>
