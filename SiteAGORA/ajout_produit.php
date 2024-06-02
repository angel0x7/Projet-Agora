<?php
include 'header.php';
include 'db_connection.php';

// Récupérer les catégories
$stmt = $conn->prepare("SELECT * FROM categories");
$stmt->execute();
$categoriesResult = $stmt->get_result();

$categories = [];
while ($categoryRow = $categoriesResult->fetch_assoc()) {
    $categories[] = $categoryRow;
}

// Récupérer les catégories de vente
$categorySellStmt = $conn->prepare("SELECT * FROM categories_sell");
$categorySellStmt->execute();
$categorySellResult = $categorySellStmt->get_result();

$categorySells = [];
while ($categorySellRow = $categorySellResult->fetch_assoc()) {
    $categorySells[] = $categorySellRow;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos produits en vente</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h3>Ajouter un nouveau produit</h3>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="category_sell">Mode de Vente :</label>
                <select class="form-control" id="category_sell" name="category_sell" required onchange="handleCategorySellChange()">
                    <option value="">Sélectionnez un mode de vente</option>
                    <?php foreach ($categorySells as $categorySell): ?>
                        <option value="<?php echo htmlspecialchars($categorySell['id']); ?>">
                            <?php echo htmlspecialchars($categorySell['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="product-fields" class="hidden">
                <div class="form-group">
                    <label for="productName">Nom du produit :</label>
                    <input type="text" class="form-control" id="productName" name="productName" placeholder="Nom du produit" required>
                </div>
                <div class="form-group">
                    <label for="productDescription">Description :</label>
                    <textarea class="form-control" id="productDescription" name="productDescription" placeholder="Description du produit" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="productPrice">Prix :</label>
                    <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Prix du produit" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="productCategory">Catégorie :</label>
                    <select class="form-control" id="productCategory" name="productCategory">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="productImages">Images :</label>
                    <input type="file" class="form-control-file" id="productImages" name="productImages[]" accept="image/*" multiple required>
                </div>
                <div class="form-group">
                    <label for="productVideo">Vidéo :</label>
                    <input type="file" class="form-control-file" id="productVideo" name="productVideo" accept="video/*">
                </div>
                <div id="auction-fields" class="hidden">
                    <div class="form-group">
                        <label for="end_time">Date et Heure de Fin de l'Enchère :</label>
                        <input type="datetime-local" class="form-control" id="end_time" name="end_time">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter le Produit</button>
            </div>
        </form>
    </div>
    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function handleCategorySellChange() {
            var categorySell = document.getElementById('category_sell').value;
            var productFields = document.getElementById('product-fields');
            var auctionFields = document.getElementById('auction-fields');

            if (categorySell) {
                productFields.classList.remove('hidden');

                if (categorySell === '1') { // Assumer que '1' est l'ID pour les enchères
                    auctionFields.classList.remove('hidden');
                    document.getElementById('end_time').required = true;
                } else {
                    auctionFields.classList.add('hidden');
                    document.getElementById('end_time').required = false;
                }
            } else {
                productFields.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
