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

        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $itemUserId) { ?>
        <h3>Enchérir</h3>
        <form id="bidForm">
            <div class="form-group">
                <label for="maxBid">Votre enchère maximale</label>
                <input type="number" class="form-control" id="maxBid" name="maxBid" required>
            </div>
            <button type="button" class="btn btn-primary" id="placeBidButton">Placer Enchère</button>
        </form>
        <?php } else { ?>
        <p class="text-danger">Vous ne pouvez pas Enchérir sur votre propre produit.</p>
        <?php } ?>

        <div id="temps-restant" style="color: green;"></div>
        <div id="temps-ecoule" style="color: red;"></div>
        <div id="bidStatus"></div>

        <h3>Enchères actuelles</h3>
        <?php
            if ($highest_bid) {
                echo "<div class='media mb-3'>";
                echo "<img src='" . htmlspecialchars($highest_bid['profile_picture']) . "' class='mr-3' alt='User' width='64'>";
                echo "<div class='media-body'>";
                echo "<h5 class='mt-0'>" . htmlspecialchars($highest_bid['name']) . "</h5>";
                echo "<p>Enchère actuelle la plus élevée : " . htmlspecialchars($highest_bid['max_bid']) . " €</p>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "<p>Aucune enchère pour cet article.</p>";
            }
        ?>

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
    <script>
        $(document).on("click", "#placeBidButton", function() {
            var maxBid = $("#maxBid").val();
            var productId = <?php echo $itemId; ?>;

            $.ajax({
                url: 'place_bid.php',
                type: 'POST',
                data: { maxBid: maxBid, productId: productId },
                success: function(response) {
                    try {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            $("#bidStatus").html('<div class="alert alert-success">Votre enchère a été placée avec succès.</div>');
                        } else {
                            $("#bidStatus").html('<div class="alert alert-danger">Erreur lors de la soumission de l\'enchère.</div>');
                        }
                    } catch (e) {
                        $("#bidStatus").html('<div class="alert alert-danger">Erreur lors de la soumission de l\'enchère.</div>');
                    }
                },
                error: function() {
                    $("#bidStatus").html('<div class="alert alert-danger">Erreur lors de la soumission de l\'enchère.</div>');
                }
            });
        });

        $(document).ready(function() {
            // Fonction pour comparer l'heure actuelle avec l'heure de fin de la vente aux enchères
            function comparerHeureFinEnchere() {
                // Obtenez l'heure actuelle
                var maintenant = new Date();
                // Formatez l'heure actuelle pour correspondre au format de votre base de données
                var maintenantFormatte = maintenant.getFullYear() + '-' + ('0' + (maintenant.getMonth() + 1)).slice(-2) + '-' + ('0' + maintenant.getDate()).slice(-2) + ' ' + ('0' + maintenant.getHours()).slice(-2) + ':' + ('0' + maintenant.getMinutes()).slice(-2) + ':' + ('0' + maintenant.getSeconds()).slice(-2);

                // Convertissez l'heure de fin de la vente aux enchères en objet Date
                var finEnchere = new Date("<?php echo $endTime; ?>");
                // Calculez la différence de temps en millisecondes
                var difference = finEnchere - maintenant;

                // Si la différence est positive, affichez le temps restant
                if (difference > 0) {
                    // Calculez le temps restant avant la fin des enchères
                    var heuresRestantes = Math.floor(difference / (1000 * 60 * 60));
                    var minutesRestantes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                    var secondesRestantes = Math.floor((difference % (1000 * 60)) / 1000);

                    // Affichez le temps restant sur la page HTML
                    $("#temps-restant").html("Temps restant : " + heuresRestantes + "h " + minutesRestantes + "m " + secondesRestantes + "s");
                } else {
                    // Effacez le temps restant s'il est négatif ou égal à zéro
                    $("#temps-restant").html("");

                    // Calculez le temps écoulé depuis la fin des enchères (en valeurs absolues)
                    difference = Math.abs(difference);
                    var heuresEcoulees = Math.floor(difference / (1000 * 60 * 60));
                    var minutesEcoulees = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                    var secondesEcoulees = Math.floor((difference % (1000 * 60)) / 1000);

                    // Affichez le temps écoulé sur la page HTML
                    $("#temps-ecoule").html("Temps écoulé : " + heuresEcoulees + "h " + minutesEcoulees + "m " + secondesEcoulees + "s");

                    // Vérifiez si l'utilisateur a participé à la vente aux enchères avant d'ajouter l'article dans le panier
                    if (<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
                        console.log("L'heure actuelle est après l'heure de fin de la vente aux enchères et l'utilisateur a participé à la vente aux enchères.");
                        $.ajax({
                            url: 'check_auctions.php',
                            type: 'POST',
                            data: { product_id: "<?php echo $itemId; ?>" }, // Inclure l'ID du produit
                            success: function(response) {
                                // Traitez la réponse si nécessaire
                                console.log("Réponse du serveur :", response);
                            },
                            error: function(xhr, status, error) {
                                // Traitez l'erreur si nécessaire
                                console.error("Erreur lors de l'appel AJAX :", error);
                            }
                        });
                    } else {
                        console.log("L'heure actuelle est après l'heure de fin de la vente aux enchères mais l'utilisateur n'a pas participé à la vente aux enchères.");
                    }
                }
            }

            // Appelez la fonction pour comparer l'heure de fin de la vente aux enchères lorsque la page est chargée
            comparerHeureFinEnchere();
            // Actualisez la fonction toutes les secondes pour mettre à jour le temps restant
            setInterval(comparerHeureFinEnchere, 1000);
        });
    </script>
</body>
</html>
    