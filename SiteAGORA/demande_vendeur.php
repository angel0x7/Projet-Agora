<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $raison = $_POST['raison'];

    $stmt = $conn->prepare("INSERT INTO demande_vendeur (user_id, raison) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $raison);
    $stmt->execute();
    $stmt->close();

    // Rediriger l'utilisateur après la soumission de la demande
    header("Location: ajout_produit.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande pour Devenir Vendeur</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <div class="mt-4">
            <h2>Demande pour Devenir Vendeur</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label>Raison pour devenir vendeur :</label>
                    <textarea class="form-control" name="raison" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer la Demande</button>
            </form>
        </div>
        <?php include 'nav_profile.php'; ?>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
