<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // Récupérer les données de l'utilisateur
$user_type = $user['user_type']; // Extraire le type d'utilisateur
$stmt->close();

// Vérifier si l'utilisateur est autorisé à ajouter un produit
$allowed = false;
if ($user_type === 'vendeur' || $user_type === 'administrateur') {
    $allowed = true;
}

// Si l'utilisateur est un acheteur, vérifier s'il a déjà soumis une demande pour devenir vendeur
if ($user_type === 'acheteur') {
    $stmt = $conn->prepare("SELECT * FROM demande_vendeur WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        // L'utilisateur a déjà soumis une demande
        $demande_existe = true;
    } else {
        $demande_existe = false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifiez à nouveau si l'utilisateur est autorisé à ajouter un produit
    if ($allowed) {
        // Ajouter le produit à la base de données
    } else {
        // L'utilisateur n'est pas autorisé à ajouter un produit
        // Vérifier s'il a déjà soumis une demande pour devenir vendeur
        if (!$demande_existe) {
            // Si aucune demande n'a été soumise, insérer une nouvelle demande dans la table
            $stmt = $conn->prepare("INSERT INTO demande_vendeur (user_id) VALUES (?)");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5" style="display: flex; flex-direction: row-reverse;">
        <div class="mt-4">
            <?php if ($allowed): ?>
                <h2>Vos produits en vente</h2>
                <!-- Affichage des produits en vente -->
                <div id="productsContainer" style="display: flex; flex-wrap: wrap;">
                    <!-- Les produits seront affichés ici -->
                </div>

                <!-- Ajoutez d'autres champs si nécessaire -->
                <a href="ajout_produit.php" class="btn btn-primary">Ajouter un Produit</a>
            <?php else: ?>
            <h2>Devenez Vendeur</h2>
            <p>Vous devez être un vendeur ou un administrateur pour ajouter un produit.</p>
            <?php if (!$demande_existe): ?>
            <h2>Devenez Vendeur</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <button type="submit" class="btn btn-primary">Faire une demande pour devenir vendeur</button>
            </form>
            <?php else: ?>
            <p>Votre demande pour devenir vendeur est en cours de traitement.</p>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php include 'nav_profile.php'; ?>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Chargement initial des produits en vente
            loadProducts();

            // Fonction pour charger les produits en vente depuis la base de données
            function loadProducts() {
                $.ajax({
                    url: 'get_products.php',
                    type: 'GET',
                    success: function(response) {
                        $("#productsContainer").html(response);
                    },
                    error: function() {
                        alert('Erreur lors du chargement des produits.');
                    }
                });
            }
        });
    </script>
</body>
</html>
