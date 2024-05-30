<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Tout Parcourir</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    
    <?php
        include 'header.php';
        include 'db_connection.php';

        session_start();
        $current_user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

        // Récupérer les catégories de la base de données
        $query = "SELECT * FROM categories";
        $result = $conn->query($query);

        // Récupérer les catégories de vente
        $query_sell_categories = "SELECT * FROM categories_sell";
        $result_sell_categories = $conn->query($query_sell_categories);
    ?>

    <div class="container mt-5">
        <h2>Tout Parcourir</h2>
        <form action="browse.php" method="GET" style="display: flex; flex-direction: column;">
            <div class="form-group">
                <label for="search">Rechercher un article:</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Entrez des mots-clés">
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="category">Catégorie:</label>
                    <select class="form-control" id="category" name="category">
                        <option value="">Toutes les catégories</option>
                        <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="category_sell">Mode de vente:</label>
                    <select class="form-control" id="category_sell" name="category_sell">
                        <option value="">Tous les modes de vente</option>
                        <?php
                            if ($result_sell_categories->num_rows > 0) {
                                while($row = $result_sell_categories->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="min_price">Prix Minimum:</label>
                    <input type="number" class="form-control" id="min_price" name="min_price" placeholder="Prix Minimum">
                </div>
                <div class="form-group col-md-4">
                    <label for="max_price">Prix Maximum:</label>
                    <input type="number" class="form-control" id="max_price" name="max_price" placeholder="Prix Maximum">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>
        <div class="col-md-9">
            <h4>Articles</h4>
            <div class="row">
                <?php
                    // Construire la condition de filtrage de la catégorie
                    $category_condition = "";
                    $category_filter = isset($_GET['category']) ? $_GET['category'] : null;
                    if ($category_filter) {
                        $category_condition = "AND category = '$category_filter'";
                    }

                    // Construire la condition de filtrage du mode de vente
                    $category_sell_condition = "";
                    $category_sell_filter = isset($_GET['category_sell']) ? $_GET['category_sell'] : null;
                    if ($category_sell_filter) {
                        $category_sell_condition = "AND category_sell_id = $category_sell_filter";
                    }

                    // Récupérer les produits en fonction des filtres de prix, de recherche, de catégorie et de mode de vente
                    $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : null;
                    $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : null;
                    $price_condition = "";
                    if ($min_price && $max_price) {
                        $price_condition = "AND price BETWEEN $min_price AND $max_price";
                    } elseif ($min_price) {
                        $price_condition = "AND price >= $min_price";
                    } elseif ($max_price) {
                        $price_condition = "AND price <= $max_price";
                    }

                    $search_query = isset($_GET['search']) ? $_GET['search'] : null;
                    $search_condition = "";
                    if ($search_query) {
                        $search_condition = "AND (name LIKE '%$search_query%' OR description LIKE '%$search_query%')";
                    }

                    $query = "SELECT id, name, description, price, category, image_path, user_id FROM products WHERE 1 $category_condition $category_sell_condition $price_condition $search_condition";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-4">';
                            echo '<div class="card mb-4" id="item' . htmlspecialchars($row['id']) . '">';
                            echo '<img src="' . htmlspecialchars($row['image_path']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                            echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
                            echo '<p class="card-text">Prix: ' . htmlspecialchars($row['price']) . '€</p>';
                            /*echo '<div class="choix">';
                            if ($current_user_id != (int)$row['user_id']) { // Notez que nous comparons avec != et nous castons user_id
                                echo '<form action="add_to_cart.php" method="POST">';
                                echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($row['id']) . '">';
                                echo '<button type="submit" class="btn btn-primary">Ajouter au Panier</button>';
                                echo '</form>';
                            }
                            echo '<a href="type_sell.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-primary">Voir Détail</a>';
                            echo '</div>';*/
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Aucun produit trouvé.</p>';
                    }
                    $conn->close();
                ?>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".card").click(function(){
                var itemID = $(this).attr("id");
                window.location.href = "type_sell.php?id=" + itemID.replace('item', '');
            });
        });
    </script>
</body>
</html>