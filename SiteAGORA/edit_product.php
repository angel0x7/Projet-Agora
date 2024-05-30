<?php
session_start();
include 'db_connection.php';

// Vérifier si l'ID du produit est passé en paramètre d'URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Préparer et exécuter la requête SQL pour récupérer les détails du produit à modifier
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Récupérer les catégories
    $categoryStmt = $conn->prepare("SELECT * FROM categories");
    $categoryStmt->execute();
    $categoriesResult = $categoryStmt->get_result();

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
    $categoryStmt->close();
    $conn->close();

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        ?>

        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier le Produit</title>
            <link rel="stylesheet" href="css/styles.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <?php include 'header.php'; ?>
            <div class="container mt-5">
                <h2>Modifier le Produit</h2>
                <form action="update_product.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                    <div class="form-group">
                        <label for="name">Nom du Produit:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Prix:</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie:</label>
                        <select class="form-control" id="category" name="category" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php if ($category['id'] == $product['category']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Nouvelle Image:</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <div class="form-group">
                        <label for="end_time">Date et Heure de Fin de l'Enchère</label>
                        <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="<?php echo date('Y-m-d\TH:i', strtotime($product['end_time'])); ?>" required>
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
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>
            </div>
            <?php include 'footer.php'; ?>
            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>

    <?php
    } else {
        // Rediriger si le produit n'est pas trouvé
        header("Location: my_product.php");
        exit();
    }
} else {
    // Rediriger si l'ID du produit n'est pas spécifié
    header("Location: my_product.php");
    exit();
}
?>
