<?php
require_once 'CProducts.php';

$products = new CProducts();
$items = $products->getProducts(20);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <table border="1" id="productsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Артикул</th>
                <th>Количество</th>
                <th>Дата</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr data-id="<?= htmlspecialchars($item['ID']) ?>">
                    <td><?= htmlspecialchars($item['PRODUCT_ID']) ?></td>
                    <td><?= htmlspecialchars($item['PRODUCT_NAME']) ?></td>
                    <td><?= htmlspecialchars($item['PRODUCT_PRICE']) ?></td>
                    <td><?= htmlspecialchars($item['PRODUCT_ARTICLE']) ?></td>
                    <td>
                        <button class="decrease">-</button>
                        <span class="quantity"><?= htmlspecialchars($item['PRODUCT_QUANTITY']) ?></span>
                        <button class="increase">+</button>
                    </td>
                    <td><?= htmlspecialchars($item['DATE_CREATE']) ?></td>
                    <td><button class="hideProduct">Скрыть</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        $(document).on('click', '.hideProduct', function() {
            const row = $(this).closest('tr');
            const productId = row.data('id');

            $.ajax({
                url: 'hide_product.php',
                method: 'POST',
                data: { id: productId },
                success: function() {
                    row.hide();
                },
                error: function() {
                    alert('Ошибка скрытия товара.');
                }
            });
        });

        $(document).on('click', '.increase, .decrease', function() {
            const row = $(this).closest('tr');
            const productId = row.data('id');
            const quantityElem = row.find('.quantity');
            let quantity = parseInt(quantityElem.text());

            if ($(this).hasClass('increase')) {
                quantity++;
            } else if ($(this).hasClass('decrease') && quantity > 0) {
                quantity--;
            }

            $.ajax({
                url: 'update_quantity.php',
                method: 'POST',
                data: { id: productId, quantity: quantity },
                success: function() {
                    quantityElem.text(quantity);
                },
                error: function() {
                    alert('Ошибка обновления количества.');
                }
            });
        });
    </script>
</body>
</html>
