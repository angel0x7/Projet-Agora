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
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        include 'header.php';
        include 'db_connection.php';

        $user_id = $_SESSION['user_id'];

        // Récupérer les produits de la base de données
        $query = "SELECT id, name, description, price, category FROM products";
        $result = $conn->query($query);
    ?>

    <div class="container mt-5">
        <h2>Tout Parcourir</h2>
        <div class="row">
            <div class="col-md-3">
                <h4>Catégories</h4>
                <ul class="list-group">
                    <li class="list-group-item">Articles rares</li>
                    <li class="list-group-item">Articles haut de gamme</li>
                    <li class="list-group-item">Articles réguliers</li>
                </ul>
            </div>
            <div class="col-md-9">
                <h4>Articles</h4>
                <div class="row">
                    <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<div class="col-md-4">';
                                echo '<div class="card mb-4" id="item' . htmlspecialchars($row['id']) . '">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                                echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
                                echo '<p class="card-text">Prix: ' . htmlspecialchars($row['price']) . '€</p>';
                                echo '<div class="choix">';
                                echo '<a href="#" class="btn btn-primary">Acheter</a>';
                                echo '<a href="item_detail.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-primary">Voir Détail</a>';
                                echo '</div>';
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
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".card").click(function(){
                var itemID = $(this).attr("id");
                window.location.href = "item_detail.php?id=" + itemID.replace('item', '');
            });
        });
    </script>
</body>
</html>
