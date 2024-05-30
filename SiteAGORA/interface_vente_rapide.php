<?php
session_start();
include 'db_connection.php';

// Vérifiez si l'ID de l'article est passé en paramètre d'URL
if (isset($_GET['id'])) {
    // Récupérez l'ID de l'article depuis l'URL
    $itemId = $_GET['id'];
    $_SESSION['product_id'] = $itemId; // Définissez la variable de session

    // Préparez et exécutez la requête SQL pour récupérer les détails de l'article
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifiez s'il y a des résultats
    if ($result->num_rows > 0) {
        // Récupérez les détails de l'article
        $row = $result->fetch_assoc();
        $itemName = htmlspecialchars($row['name']);
        $itemDescription = htmlspecialchars($row['description']);
        $itemPrice = htmlspecialchars($row['price']);
        $itemImage = htmlspecialchars($row['image_path']);
        $itemUserId = (int)$row['user_id']; // ID de l'utilisateur qui a ajouté l'article
        $endTime = $row['end_time']; // Heure de fin de la vente aux enchères
    } else {
        // Affichez un message si l'article n'est pas trouvé
        echo "Aucun article trouvé avec cet identifiant.";
        exit(); // Arrêtez le script
    }

    // Fermez la requête
    $stmt->close();
} else {
    // Affichez un message si l'ID de l'article n'est pas fourni dans l'URL
    echo "L'identifiant de l'article n'est pas fourni.";
    exit(); // Arrêtez le script
}

// Rouvrez la connexion à la base de données pour la requête des enchères
include 'db_connection.php';

// Récupérer la plus haute enchère actuelle avec les informations de l'utilisateur
$stmt = $conn->prepare("SELECT b.max_bid, u.name, u.profile_picture 
                        FROM bids b
                        JOIN users u ON b.user_id = u.id
                        WHERE b.product_id = ? 
                        ORDER BY b.max_bid DESC 
                        LIMIT 1");
$stmt->bind_param("i", $itemId);
$stmt->execute();
$result = $stmt->get_result();
$highest_bid = $result->fetch_assoc();
$stmt->close();

// Fermez la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Détail de l'Article</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo $itemImage; ?>" class="img-fluid" alt="<?php echo $itemName; ?>">
            </div>
            <div class="col-md-6">
                <h2><?php echo $itemName; ?></h2>
                <p><?php echo $itemDescription; ?></p>
                <h4>Prix : <?php echo $itemPrice; ?>€</h4>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $itemUserId) { ?>
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $itemId; ?>">
                    <button type="submit" class="btn btn-primary">Ajouter au Panier</button>
                </form>
                <?php } else { ?>
                <p class="text-danger">Vous ne pouvez pas acheter votre propre produit.</p>
                <?php } ?>
            </div>
        </div>

        <div class="mt-5">
            <h3>Commentaires et Évaluations</h3>
            <!-- Ajoutez le formulaire et les commentaires ici -->
            <form action="add_reviews.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $itemId; ?>">

                <div class="form-group">
                    <label for="comment">Votre Commentaire</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="rating">Votre Note</label>
                    <select class="form-control" id="rating" name="rating" required>
                        <option value="1">1 - Très Mauvais</option>
                        <option value="2">2 - Mauvais</option>
                        <option value="3">3 - Moyen</option>
                        <option value="4">4 - Bon</option>
                        <option value="5">5 - Excellent</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Soumettre</button>
            </form>
            <?php include 'reviews.php'; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
    