<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer l'ID de l'utilisateur
$userId = $_SESSION['user_id'];

// Vérifier si l'ID du produit est passé en paramètre d'URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Récupérer les détails du produit et de la négociation
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $productResult = $stmt->get_result();
    $product = $productResult->fetch_assoc();

    // Nouvelle requête pour récupérer le chemin de l'image du produit à partir de la table product_images
    $stmt_images = $conn->prepare("SELECT image_path FROM product_images WHERE product_id = ?");
    $stmt_images->bind_param("i", $itemId);
    $stmt_images->execute();
    $images_result = $stmt_images->get_result();
    $stmt_images->close(); // Fermer la requête

    // Nouvelle requête pour récupérer le chemin de l'image du produit à partir de la table product_images
    $stmt_video = $conn->prepare("SELECT video_path FROM product_videos WHERE product_id = ?");
    $stmt_video->bind_param("i", $itemId);
    $stmt_video->execute();
    $video_result = $stmt_video->get_result();
    $stmt_video->close(); // Fermer la requête

    $stmt->close(); // Fermer la première requête

    $stmt = $conn->prepare("SELECT * FROM negotiations WHERE product_id = ? ORDER BY updated_at DESC LIMIT 1");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $negotiationResult = $stmt->get_result();
    $negotiation = $negotiationResult->fetch_assoc();

    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Négociation</title>
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <?php
                        if ($images_result->num_rows > 0 || $video_result->num_rows > 0) {
                            // Afficher un carrousel
                            echo '<div id="carousel' . htmlspecialchars($row['id']) . '" class="carousel slide" data-ride="carousel">';
                            echo '<div class="carousel-inner">';

                            $first = true;
                            // Ajoutez les images au carrousel
                            while ($image_row = $images_result->fetch_assoc()) {
                                echo '<div class="carousel-item' . ($first ? ' active' : '') . '">';
                                echo '<img src="' . htmlspecialchars($image_row['image_path']) . '" class="d-block w-100" alt="' . htmlspecialchars($row['name']) . '">';
                                echo '</div>';
                                $first = false;
                            }

                            // Ajoutez la vidéo au carrousel si disponible
                            if ($video_result->num_rows > 0) {
                                $video_row = $video_result->fetch_assoc();
                                echo '<div class="carousel-item' . ($first ? ' active' : '') . '">';
                                echo '<video class="d-block w-100" controls>';
                                echo '<source src="' . htmlspecialchars($video_row['video_path']) . '" type="video/mp4">';
                                echo 'Votre navigateur ne supporte pas les vidéos HTML5.';
                                echo '</video>';
                                echo '</div>';
                            }

                            echo '</div>';
                            echo '<a class="carousel-control-prev" href="#carousel' . htmlspecialchars($row['id']) . '" role="button" data-slide="prev">';
                            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                            echo '<span class="sr-only">Previous</span>';
                            echo '</a>';
                            echo '<a class="carousel-control-next" href="#carousel' . htmlspecialchars($row['id']) . '" role="button" data-slide="next">';
                            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                            echo '<span class="sr-only">Next</span>';
                            echo '</a>';
                            echo '</div>';
                        }
                        else {
                            // Afficher l'image unique du produit
                            if ($images_result->num_rows === 1) {
                                $image_row = $images_result->fetch_assoc();
                                echo '<img src="' . htmlspecialchars($image_row['image_path']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
                            }
                        }
                    ?>
                </div>
                <div class="col-md-6">
                    <h2>Négociation pour <?php echo htmlspecialchars($product['name']); ?></h2>
                    <h5>Détails du produit</h5>
                    <p>Description: <?php echo htmlspecialchars($product['description']); ?></p>
                    <p>Prix: <?php echo htmlspecialchars($product['price']); ?> €</p>

                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $itemUserId && $negotiation['status'] !== 'accepted') { ?>
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $itemId; ?>">
                            <button type="submit" class="btn btn-primary">Ajouter au Panier</button>
                        </form>
                        <?php } else { ?>
                        <p class="text-danger">Vous ne pouvez pas acheter votre propre produit.</p>
                    <?php } ?>
                </div>
            </div>

            <div class="mt-4">
                <h4>Négociation en cours</h4>
                <?php if ($negotiation): ?>
                    <p>Offre achete: <?php echo htmlspecialchars($negotiation['initial_offer']); ?> €</p>
                    <p>Contre-offre actuelle: <?php echo htmlspecialchars($negotiation['counter_offer']); ?> €</p>
                    <p>Tour actuel: <?php echo htmlspecialchars($negotiation['round']); ?></p>
                    <p>Status: <?php echo htmlspecialchars($negotiation['status']); ?></p>

                    <?php if ($negotiation['status'] === 'pending' && $negotiation['round'] < 5): ?>
                        <?php if (($negotiation['round'] % 2 == 0 && $negotiation['buyer_id'] == $userId) || ($negotiation['round'] % 2 == 1 && $negotiation['seller_id'] == $userId)): ?>
                            <form action="submit_counter_offer.php" method="POST">
                                <input type="hidden" name="negotiation_id" value="<?php echo $negotiation['id']; ?>">
                                <div class="form-group">
                                    <label for="counter_offer">Votre contre-offre:</label>
                                    <input type="text" class="form-control" id="counter_offer" name="counter_offer" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Soumettre</button>
                            </form>
                            <form action="accept_offer.php" method="POST">
                                <input type="hidden" name="negotiation_id" value="<?php echo $negotiation['id']; ?>">
                                <button type="submit" class="btn btn-success">Accepter</button>
                            </form>
                        <?php else: ?>
                            <p>En attente de la réponse de l'autre partie.</p>
                        <?php endif; ?>
                    <?php elseif ($negotiation['status'] === 'pending' && $negotiation['round'] >= 5): ?>
                        <p>Limite de négociation atteinte. Veuillez accepter ou refuser l'offre actuelle.</p>
                        <form action="accept_offer.php" method="POST">
                            <input type="hidden" name="negotiation_id" value="<?php echo $negotiation['id']; ?>">
                            <button type="submit" class="btn btn-success">Accepter</button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != htmlspecialchars($product['user_id'])): ?>
                        <h4>Soumettre une offre initiale</h4>
                        <form action="submit_offer.php" method="POST">
                            <input type="hidden" id="product_id "name="product_id" value="<?php echo $product['id']; ?>">
                            <div class="form-group">
                                <label for="initial_offer">Votre offre initiale:</label>
                                <input type="text" class="form-control" id="initial_offer" name="initial_offer" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Soumettre</button>
                        </form>
                    <?php else: ?>
                        <p>En attente de l'offre initiale de l'acheteur.</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php include 'footer.php'; ?>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>

    <?php
} else {
    echo "Erreur: ID du produit non spécifié.";
}

$conn->close();
?>



