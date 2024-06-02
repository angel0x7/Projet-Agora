<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Recherche Avancée</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Recherche Avancée</h2>
        <form action="search_results.php" method="GET">
            <div class="form-group">
                <label for="keyword">Mot-clé</label>
                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Entrez un mot-clé" required>
            </div>
            <div class="form-group">
                <label for="category">Catégorie</label>
                <select class="form-control" id="category" name="category">
                    <option value="all">Toutes les catégories</option>
                    <option value="books">Livres</option>
                    <option value="electronics">Électronique</option>
                    <!-- Ajoutez d'autres catégories ici -->
                </select>
            </div>
            <div class="form-group">
                <label for="price_range">Fourchette de prix</label>
                <input type="number" class="form-control" id="min_price" name="min_price" placeholder="Prix minimum">
                <input type="number" class="form-control mt-2" id="max_price" name="max_price" placeholder="Prix maximum">
            </div>
            <button type="submit" class="btn btn-primary" href="search_results.php">Rechercher</button>
        </form>
    </div>
    
    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
