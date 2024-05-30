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
</head>
<body>
    <!-- Formulaire pour ajouter un nouveau produit -->
    <div class="container mt-5">
        <h3>Ajouter un nouveau produit</h3>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productName">Nom du produit :</label>
                <input type="text" class="form-control" id="productName" name="productName" placeholder="Nom du produit" required>
            </div>
            <div class="form-group">
                <label for="productDescription">Description :</label>
                <textarea type="text" class="form-control" id="productDescription" name="productDescription" placeholder="Description du produit"rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="productPrice">Prix :</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Prix du produit" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="productCategory">Catégorie</label>
                <select class="form-control" id="productCategory" name="productCategory">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $itemCategoryId) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="productImage">Image:</label>
                <input type="file" class="form-control-file" id="productImage" name="productImage" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="end_time">Date et Heure de Fin de l'Enchère</label>
                <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
            </div>
            <div class="form-group">
                <label for="category_sell">Mode de Vente:</label>
                <select class="form-control" id="category_sell" name="category_sell" required>
                    <?php foreach ($categorySells as $categorySell): ?>
                        <option value="<?php echo htmlspecialchars($categorySell['id']); ?>" <?php if ($categorySell['id'] == $product['category_sell_id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($categorySell['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Ajoutez d'autres champs si nécessaire -->
            <button type="submit" class="btn btn-primary">Ajouter le Produit</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>