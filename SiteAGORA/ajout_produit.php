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

    <!-- Formulaire pour ajouter un nouveau produit -->
    <h3>Ajouter un nouveau produit</h3>
    <form id="addProductForm">
        <div class="form-group">
            <label for="productName">Nom du produit :</label>
            <input type="text" class="form-control" id="productName" name="productName" placeholder="Nom du produit" required>

        </div>
        <div class="form-group">
            <label for="productDescription">Description :</label>
            <textarea type="text" class="form-control" id="productDescription" name="productDescription" placeholder="Description du produit"rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="productPrice">Prix :</label>
            <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Prix du produit" required>
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
        <button type="button" class="btn btn-primary" id="addProductButton">Ajouter le Produit</button>
    </form>

    <?php include 'footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).on("click", "#addProductButton", function() {
            var formData = {
                productName: $("#productName").val(),
                productDescription: $("#productDescription").val(),
                productPrice: $("#productPrice").val(),
                productCategory: $("#productCategory").val()
            };

            $.ajax({
                url: 'add_product.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    try {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.success) {
                            window.location.href = 'my_product.php'; // Optionally, you can clear the form or update the UI here
                        } else {
                            alert('Erreur lors de l\'ajout du produit.');
                        }
                    } catch (e) {
                        alert('Erreur lors de l\'ajout du produit.');
                    }
                },
                error: function() {
                    alert('Erreur lors de l\'ajout du produit.');
                }
            });
        });
    </script>
</body>
</html>
