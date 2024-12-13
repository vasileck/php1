<?php
require_once 'CProducts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $products = new CProducts();
    $id = (int)$_POST['id'];
    $products->hideProduct($id);
}
?>
