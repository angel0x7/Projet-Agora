
<?php
    session_start();
    $user_id = $_SESSION['user_id'];
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assurez-vous d'ajuster le chemin selon votre structure de fichiers -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }

            header {
                background-color: #5CB8FF;
                padding: 20px;
                text-align: center;
                margin: 0 auto; /* Centrer le header */
				border-radius:20px;
				
            }

            .header-content {
                display: flex;
                justify-content: space-between; /* Pour aligner les éléments sur les côtés */
                align-items: center; /* Pour aligner verticalement les éléments */
				
            }
			.nav-container {
    flex-grow: 1; /* Pour que les boutons occupent tout l'espace disponible */
    text-align: right; /* Aligner les éléments vers la droite */
	
     /* Ajouter de l'espace entre les boutons et la photo */
}

.logo-container {
    margin-right: 800px; /* Marge à droite pour séparer l'image des boutons */
}

            

            .navbar-nav {
                display: flex;
                list-style-type: none;
                padding: 0;
                margin: 0;
                justify-content: flex-end; /* Pour aligner les éléments vers la droite */
            }

            .nav-item {
                margin-left: 20px; /* Marge entre les éléments de navigation */
            }

            .nav-link {
                color: black;
                text-decoration: none;
                padding: 5px 10px;
                border-radius: 20px;
                transition: background-color 0.3s ease;
            }

            .nav-link:hover {
                background-color: white;
            }

            .logo {
                width: 200px; /* Ajustez la taille de votre logo selon vos besoins */
                height: auto;
            }
        </style>

        <!-- En-tête avec barre de navigation -->
        <header>
            <div class="header-content">
                <div class="logo-container">
                    <img src="agoralogo.png" alt="Logo Agora" class="logo">
                </div>
                <div class="nav-container">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="browse.php">Tout Parcourir</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="notifications.php">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">Panier</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="search.php">Recherche</a>
                        </li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php">Votre Compte</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Déconnexion</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Se Connecter</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="signup.php">S'inscrire</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </header>
        <div class="collapse navbar-collapse" id="navbarNav">
            
        </div>
    </nav>
</body>
</html>


