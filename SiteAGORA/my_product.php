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
    <?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    include 'header.php';
    include 'db_connection.php';

    $user_id = $_SESSION['user_id'];
    ?>

    <div class="container">
        <h2>Vos produits en vente</h2>

        <!-- Affichage des produits en vente -->
        <div id="productsContainer" style="display: flex; flex-wrap: wrap;">
            <!-- Les produits seront affichés ici -->
        </div>

        <!-- Ajoutez d'autres champs si nécessaire -->
        <a href="ajout_produit.php" class="btn btn-primary">Ajouter un Produit</a>
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
