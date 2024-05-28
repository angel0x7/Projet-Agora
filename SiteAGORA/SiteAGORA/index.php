<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia - Accueil</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <?php include 'header.php'; ?>

    <!-- Carrousel de sélection du jour -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/item1.jpg" class="d-block w-100" alt="Item 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Item 1</h5>
                    <p>Description de l'article 1.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/item2.jpg" class="d-block w-100" alt="Item 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Item 2</h5>
                    <p>Description de l'article 2.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/item3.jpg" class="d-block w-100" alt="Item 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Item 3</h5>
                    <p>Description de l'article 3.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <?php include 'contact.php'; ?>

    <?php include 'footer.php'; ?>

</body>
</html>
