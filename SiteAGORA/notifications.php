<?php
session_start();
include 'db_connection.php';

$user_id = $_SESSION['user_id'];

// Récupérer les notifications de l'utilisateur
$stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
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

$categoryStmt->close();
$categorySellResult->close();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Notifications</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h2>Gestion des Notifications</h2>
        <form action="traitement_recherche.php" method="POST">
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
                <label for="prix_max">Prix Maximum :</label>
                <input type="number" class="form-control" id="prix_max" name="prix_max">
            </div>
            <div class="form-group">
                <label for="notifications">Activer les notifications :</label>
                <input type="checkbox" id="notifications" name="notifications" value="1">
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>
        <div class="container mt-5">
            <h2>Notifications</h2>
            <ul class="list-group">
                <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item"><?php echo $row['message']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>
