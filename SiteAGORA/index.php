<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agora Francia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        header {
            background-color: #5CB8FF;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .logo {
            width: 350px;
            height: auto;
            margin-right: 20px;
        }
        nav {
            background-color: #444;
            padding: 10px;
        }
        nav ul {
            display: flex;
            list-style-type: none;
            margin: 0;
            padding: 0;
            justify-content: center;
        }
        nav li {
            margin-right: 50px;
            border-radius: 5px;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 20px;
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: gray;
        }
        .section1 {
            flex-grow: 1;
            padding: 0;
            background-image: url('photopersonne.png');
            background-size: contain;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        .explore-button {
            background-color: #5CB8FF;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-left: 16%;
            margin-top: 20%;
        }
        .explore-button:hover {
            background-color: #479ace;
        }
        .section3 {
            flex-grow: 1;
            padding: 0;
            background-image: url('verife_article.png');
            background-size: contain;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin-top: -350px;
        }
        footer {
            background-color: #333;
            padding: 20px;
            text-align: center;
        }
        footer a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        footer a:hover {
            background-color: #555;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        header, nav, footer {
            animation: fadeIn 1s ease;
        }
        h2 {
            color: white;
        }
        p {
            color: white;
        }
        .carousel-item {
            position: center;
			width: 600px; /* largeur précise */
            height: 400px; /* hauteur précise */
            left: 300px;
            border-radius: 10px;
        }
        .carousel-caption {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }
        .carousel-button {
            background-color: #5CB8FF;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .carousel-button:hover {
            background-color: #479ace;
        }
		.container-carousel {
            display: flex;
            justify-content: center;
        }
        .rectangle img {
            width: 100%; /* Largeur à 100% pour remplir l'espace disponible */
            height: auto; /* Hauteur automatique pour maintenir le ratio d'aspect */
            object-fit: cover; /* S'assure que l'image est correctement ajustée à la taille spécifiée */
            border-radius: 10px 10px 0 0; /* Si nécessaire */
        }

        .carousel {
            width: 80%; /* ajustez la largeur selon vos besoins */
            margin-left: auto;
            margin-right: auto;
        }
        .section2 {
            padding: 20px;
            background-color: gray;
            margin-top: -250px;
        }
        .section4 {
            background-color: gray;
            padding: 20px;
            margin-top: 0px;
        }
        .section2 .rectangle {
            margin: 10px; /* Réduire l'espace entre les rectangles */
            background-color: #f7f7f7;
            padding: 50px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 280px;
            height: 400px;
            display: inline-block;
            vertical-align: top;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .col-md-3 {
            width: 23%;
            padding: 10px;
			
        }
        .rectangle h2 {
            font-weight: bold;
            margin-top: 0;
	        color:black;
        }
        .rectangle img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }
        .rectangle p {
            margin-bottom: 20px;
	        color:black;
        }
        .button {
            background-color: #5CB8FF;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #479ace;
        }

        .btn{
            margin-top: 13%;
            margin-left: 10%;
        }

        /* Définition d'un container pour gérer l'affichage */
		.btn-1 {
            padding: 10px 20px;
            border-radius: 25px;
            background-color: #5CB8FF;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
			text-decoration: none; /* Empêche la sous-lignement */
            display: inline-block; /* Ajoute le comportement de bloc pour pouvoir définir une largeur et une hauteur */
        }
        .btn-1:hover {
            background-color: #479ace;
        }

        /* Style du bouton 2 */
        .btn-2 {
            padding: 10px 20px;
            border-radius: 15px;
            background-color: #FF6F61;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
			text-decoration: none; /* Empêche la sous-lignement */
            display: inline-block; /* Ajoute le comportement de bloc pour pouvoir définir une largeur et une hauteur */
        }
        .btn-2:hover {
            background-color: #e86054;
        }

        /* Style du bouton 3 */
        .btn-3 {
            padding: 10px 20px;
            border-radius: 25px;
            background-color: #FFD166;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
			text-decoration: none; /* Empêche la sous-lignement */
            display: inline-block; /* Ajoute le comportement de bloc pour pouvoir définir une largeur et une hauteur */
        }
        .btn-3:hover {
            background-color: #f7c759;
        }

        /* Style du bouton 4 */
        .btn-4 {
            padding: 10px 20px;
            border-radius: 35px;
            background-color: #A0D2DB;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none; /* Empêche la sous-lignement */
            display: inline-block; /* Ajoute le comportement de bloc pour pouvoir définir une largeur et une hauteur */
        }
        .btn-4:hover {
            background-color: #93c5cf;
        }
                .panier-icon {
            width: 20px; /* Ajustez la taille de l'icône selon vos préférences */
            height: auto;
        }

        .nav-text {
            margin: 0; /* Supprimez les marges autour du texte pour un alignement propre */
        }
    </style>
    <style>
        h2 {
            display: flex;
            color: #343a40;
            justify-content: center;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-img-top {
            height: 200px; /* Hauteur fixe pour l'image de la carte */
            object-fit: cover; /* Pour s'assurer que l'image couvre entièrement l'espace */
        }

        .card-text {
            overflow: hidden; /* Pour cacher le texte qui dépasse */
        }
        .choix {
            display: flex;
            justify-content: center;
        }
        /* Classe pour ajuster la hauteur des images du carousel */
        .carousel-inner .carousel-item img{
            height: 200px; /* Hauteur fixe pour les images du carousel */
            object-fit: cover; /* Pour s'assurer que l'image couvre entièrement l'espace */
        }

        .card:hover {
            transform: scale(1.05); /* Agrandir légèrement la carte */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ajouter une ombre portée */
        }
        @media (min-width: 1200px) {
            .container, .container-lg, .container-md, .container-sm, .container-xl {
                max-width: 1220px;
            }
        }
	    iframe{
    width: 80%;
    height: 500px;
    filter: invert(100%);
}
    </style>
</head>
<body>
    <!-- En-tête avec barre de navigation -->
    <header>
        <img src="agoralogo.png" alt="Logo Agora" class="logo">
    </header>
    <?php
        session_start();
        $user_id = $_SESSION['user_id'];
    ?>
    <nav>
        <ul>
            <li>
                <a href="index.php">Accueil</a>
            </li>
            <li>
                <a href="browse.php">Tout Parcourir</a>
            </li>
            <li>
                <a href="notifications.php">Notifications</a>
            </li>
            <li>
                <a href="cart.php" style="display: ruby-text;">
                    <img src="panier.png" alt="Panier" class="panier-icon">
                    <p class="nav-text">Panier</p>
                </a>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li>
                    <a href="profile.php">Votre Compte</a>
                </li>
                <li>
                    <a href="logout.php">Déconnexion</a>
                </li>
            <?php else: ?>
                <li>
                    <a href="login.php">Se Connecter</a>
                </li>
                <li>
                    <a href="signup.php">S'inscrire</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- Section avec image de fond -->
    <section class="section1">
        <button class="explore-button"><a href="browse.php">Explorer les articles de créateurs</a></button>
    </section>
	
    <section class="section3">
        <div class="btn">
            <a href="browse.php" class="btn-1">Vétements</a>
            <a href="browse.php" class="btn-2">Mobilié</a><br><br>
            <a href="browse.php" class="btn-3">Bijoux</a>
            <a href="browse.php" class="btn-4">Electronique</a>
        </div>

    
	</section>
    <!-- Carrousel de sélection du jour et ventes flash -->
    <section class="section2">
        <h2>Ventes flash</h2>
        <div class="row">
            <?php
                include 'db_connection.php';
                $query = "SELECT id, name, description, price, category, user_id FROM products WHERE 1 $category_condition $category_sell_condition $price_condition $search_condition";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4" style="padding: 20px;">';
                        echo '<div class="card mb-4" id="item' . htmlspecialchars($row['id']) . '">';

                        // Vérifier s'il y a plusieurs images pour ce produit
                        $stmt_images = $conn->prepare("SELECT * FROM product_images WHERE product_id = ?");
                        $stmt_images->bind_param("i", $row['id']);
                        $stmt_images->execute();
                        $images_result = $stmt_images->get_result();

                        if ($images_result->num_rows > 1) {
                            // Afficher un carrousel
                            echo '<div id="carousel' . htmlspecialchars($row['id']) . '" class="carousel slide" data-ride="carousel">';
                            echo '<div class="carousel-inner">';

                            $first = true;
                            while ($image_row = $images_result->fetch_assoc()) {
                                echo '<div class="carousel-item' . ($first ? ' active' : '') . '">';
                                echo '<img src="' . htmlspecialchars($image_row['image_path']) . '" class="d-block w-100 carousel-image" alt="' . htmlspecialchars($row['name']) . '">';
                                echo '</div>';
                                $first = false;
                            }

                            echo '</div>';
                            echo '<a class="carousel-control-prev" href="#carousel' . htmlspecialchars($row['id']) . '" role="button" data-slide="prev">';
                            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                            echo '<span class="sr-only">Previous</span>';
                            echo '</a>';
                            echo '<a class="carousel-control-next" href="#carousel' . htmlspecialchars($row['id']) . '" role="button" data-slide="next">';
                            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                            echo '<span class="sr-only">Next</span>';
                            echo '</a>';
                            echo '</div>';
                        } else {
                            // Afficher l'image unique du produit
                            if ($images_result->num_rows === 1) {
                                $image_row = $images_result->fetch_assoc();
                                echo '<img src="' . htmlspecialchars($image_row['image_path']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
                            }
                        }
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
                        echo '<p class="card-text">Prix: ' . htmlspecialchars($row['price']) . '€</p>';
                        echo '<div class="choix">';
                        echo '<a href="type_sell.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-primary">Voir Détail</a>';
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
    </section>

    <section class="section4">
        <h2>Sélection du jour</h2>
        <div id="carouselExampleIndicators" class="carousel slide container-carousel" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                    // Connexion à la base de données
                    include 'db_connection.php';

                    // Requête pour obtenir les données des articles
                    $sql = "SELECT id FROM product_images";
                    $result = $conn->query($sql);

                    $firstImage = true;

                    if ($result->num_rows > 0) {
                        // Afficher les données de chaque ligne
                        while ($row = $result->fetch_assoc()) {
                            $itemId = $row['id'];

                            echo '<div class="carousel-item' . ($firstImage ? ' active' : '') . '">';
                            echo '<div class="col-md-3">';
                            echo '<div class="rectangle">';

                            // Requête préparée pour obtenir les images de l'article
                            $stmt_images = $conn->prepare("SELECT image_path FROM product_images WHERE id = ?");
                            $stmt_images->bind_param("i", $itemId);
                            $stmt_images->execute();
                            $images_result = $stmt_images->get_result();

                            if ($images_result->num_rows > 0) {
                                $image_row = $images_result->fetch_assoc();
                                echo '<img src="' . htmlspecialchars($image_row['image_path']) . '" alt="Image de l\'article" style="width: 400%; height: 100% ;">';
                            }

                            $stmt_images->close(); // Fermer la requête

                            echo '<button class="btn btn-primary">Voir plus</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            $firstImage = false;
                        }
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                ?>
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
    </section>

    <!-- Section contact avec Google Maps -->
    <footer>
        <section class="container mt-5">
            <h2>Contactez-nous</h2>
            <p>Adresse : 123 Rue de l'Exemple, Paris, France</p>
            <p>Email : contact@agorafrancia.com</p>
            <p>Téléphone : +33 1 23 45 67 89</p>
            
        
		
    <!-- Script pour charger Google Maps API avec votre clé -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.0576872058036!2d90.
        34664841536264!3d23.745322194886302!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bf950390da7b%3A0xde74ee6ce06f5fd6!2sWest%20dhanmondi%20residential%20a
        rea%20%2C%20bosila%2C%20mohammadpur%20%2C%20Dhaka-%201207!5e0!3m2!1sen!2sbd!4v1651403536263!5m2!1sen!2sbd"
         width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <p>&copy; 2023 Agora Francia</p>
        <a  href="faq.php">FAQ</a>
        <a  href="privacy_policy.php">Politique de Confidentialité</a>
        <a  href="terms.php">Conditions Générales d'Utilisation</a>
		</section>
    </footer>
    <!-- Fin du code HTML -->

    
    
</body>
</html>
