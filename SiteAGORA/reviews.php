<?php
    include 'db_connection.php';

    // Vérifiez si l'ID de l'article est passé en paramètre d'URL
    if (isset($_GET['id'])) {
        // Récupérez l'ID de l'article depuis l'URL
        $itemId = $_GET['id'];

        // Préparez et exécutez la requête SQL pour récupérer les commentaires de l'article avec les détails de l'utilisateur
        $stmt_comments = $conn->prepare("SELECT r.*, u.name, u.profile_picture FROM reviews r INNER JOIN users u ON r.user_id = u.id WHERE r.product_id = ?");
        $stmt_comments->bind_param("i", $itemId);
        $stmt_comments->execute();
        $result_comments = $stmt_comments->get_result();

        // Tableau pour stocker les commentaires
        $comments = array();

        // Vérifiez s'il y a des résultats
        if ($result_comments->num_rows > 0) {
            // Parcourez les résultats et stockez les commentaires dans le tableau
            while ($row = $result_comments->fetch_assoc()) {
                $comments[] = $row;
            }
        }

        // Fermez la requête
        $stmt_comments->close();
    } else {
        // Affichez un message si l'ID de l'article n'est pas fourni dans l'URL
        echo "L'identifiant de l'article n'est pas fourni.";
        exit(); // Arrêtez le script
    }

    // Fermez la connexion à la base de données
    $conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Avis des Utilisateurs</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-5">
        <h2>Avis des Utilisateurs</h2>
        <?php
        // Affichez les commentaires
        if (!empty($comments)) {
            foreach ($comments as $comment) {
        ?>
                <div class="media mb-3">
                    <img src="<?php echo htmlspecialchars($comment['profile_picture']); ?>" class="mr-3" alt="User" width="64">
                    <div class="media-body">
                        <h5 class="mt-0"><?php echo htmlspecialchars($comment['name']); ?></h5>
                        <p>Note: <?php echo htmlspecialchars($comment['rating']); ?></p>
                        <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "Aucun commentaire pour cet article.";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
