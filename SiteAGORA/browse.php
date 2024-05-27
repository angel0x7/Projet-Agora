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
    <?php include 'header.php';?>

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
                    <div class="col-md-4">
                        <div class="card mb-4" id="item1">
                            <img src="images/item1.jpg" class="card-img-top" alt="Item 1">
                            <div class="card-body">
                                <h5 class="card-title">Item 1</h5>
                                <p class="card-text">Description de l'article 1.</p>
                                <div class="choix">
                                    <a href="#" class="btn btn-primary">Acheter</a>
                                    <a href="item_detail.php" class="btn btn-primary">Voir Détail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Répétez pour plus d'articles -->
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
                window.location.href = "item_detail.php?id=" + itemID;
            });
        });
    </script>
</body>
</html>