<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Wishlist</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Votre Wishlist</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemple d'article dans la wishlist -->
                <tr>
                    <td>Article 1</td>
                    <td>100€</td>
                    <td>
                        <button class="btn btn-danger">Supprimer</button>
                        <button class="btn btn-primary">Ajouter au Panier</button>
                    </td>
                </tr>
                <!-- Répétez pour plus d'articles -->
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
