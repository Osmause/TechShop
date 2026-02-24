<?php

require_once '../vendor/autoload.php';
require_once '../util/product_display.php';

use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

$page = $_GET['page'] ?? 1;
$category = e($_GET['category'] ?? null);

try {
    $products = getProducts();
    if (!empty($category)) {
        $products = array_filter($products, static fn($product) => $product['category'] === $category);
    }
} catch (\JsonException $e) {
    $products = [];
}

$pagerfanta = new Pagerfanta(new ArrayAdapter($products));
$pagerfanta->setMaxPerPage(20);
$pagerfanta->setCurrentPage(max((int)$page, 1));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/pages/product.css">
    <title>Produits</title>
    <script type="module" src="/assets/js/main.js"></script>
    <script type="module" src="/assets/js/pages/product/page_list.js"></script>
</head>
<body>
    <?php include('../includes/header.html'); ?>

    <main>
        <div data-component="product-wrapper">
            <div data-component="pagination">
                <?php renderPagination($pagerfanta); ?>
            </div>

            <div data-component="filters">
                <form>
                    <label for="category"></label>
                    <select name="category" id="category">
                        <option value="Composants">Composants</option>
                    </select>
                    <input type="hidden" name="page" value="<?php echo $page; ?>">

                    <button type="submit">Chercher</button>
                </form>
            </div>

            <div class="grid column" data-component="list">
                <?php
                foreach ($pagerfanta->getCurrentPageResults() as $product) {
                    renderOneProduct($product);
                }
                ?>
            </div>

            <div data-component="pagination">
                <?php renderPagination($pagerfanta); ?>
            </div>
        </div>
    </main>

    <?php include('../includes/footer.html'); ?>
</body>
</html>
