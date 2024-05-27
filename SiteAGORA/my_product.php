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
        <div id="productsContainer">
            <!-- Les produits seront affichés ici -->
        </div>

        <!-- Formulaire pour ajouter un nouveau produit -->
        <h3>Ajouter un nouveau produit</h3>
        <form id="addProductForm">
            <div class="form-group">
                <label for="productName">Nom du produit :</label>
                <input type="text" class="form-control" id="productName" name="productName" required>
            </div>
            <div class="form-group">
                <label for="productDescription">Description :</label>
                <textarea class="form-control" id="productDescription" name="productDescription" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="productPrice">Prix :</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice" required>
            </div>
            <div class="form-group">
                <label for="productCategory">Catégorie :</label>
                <select class="form-control" id="productCategory" name="productCategory" required>
                    <option value="Electronique">Electronique</option>
                    <option value="Mode">Mode</option>
                    <option value="Maison">Maison</option>
                    <!-- Ajoutez d'autres options selon vos catégories -->
                </select>
            </div>
            <!-- Ajoutez d'autres champs si nécessaire -->
            <button type="button" class="btn btn-primary" id="addProductButton">Ajouter</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Chargement initial des produits en vente
            loadProducts();

            // Ajout du produit lorsqu'on appuie sur le bouton "Ajouter"
            $("#addProductButton").click(function() {
                // Récupérer les données du formulaire
                var formData = $("#addProductForm").serialize();
                alert(Hello)
                // Envoyer les données du formulaire via AJAX pour ajouter le produit
                $.ajax({
                    url: 'add_product.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Recharger les produits après l'ajout du nouveau produit
                        loadProducts();
                    },
                    error: function(xhr, status, error) {
                        // Récupérer le message d'erreur renvoyé par le serveur
                        var errorMessage = xhr.responseText;
                        alert('Erreur lors de l\'ajout du produit : ' + errorMessage);
                    }
                });
            });

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
