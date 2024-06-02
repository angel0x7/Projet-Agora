<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Résultats de Recherche</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Résultats de Recherche</h2>
        <div class="row">
            <!-- Exemple de résultat de recherche -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="images/item1.jpg" class="card-img-top" alt="Item 1">
                    <div class="card-body">
                        <h5 class="card-title">Article 1</h5>
                        <p class="card-text">Description courte de l'article.</p>
                        <a href="item_detail.php" class="btn btn-primary">Voir Détail</a>
                    </div>
                </div>
            </div>
            <!-- Répétez pour plus de résultats -->
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
