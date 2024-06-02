
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
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #5CB8FF;
            padding: 0px 20px 0px 20px;
            text-align: center;
            border-radius: 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-container {
            text-align: right;
        }

        .logo-container {
            margin-right: auto;
        }

        .navbar-nav {
            display: flex;
            list-style-type: none;
            padding: 0;
            margin: 0;
            justify-content: flex-end;
        }

        .nav-item {
            margin-left: 20px;
        }

        .nav-link {
            color: black;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 20px;
            transition: background-color 0.3s ease;
        }

        .nav-link:hover {
            background-color: white;
        }

        .logo {
            width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="display: block">
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <header>
            <div class="header-content">
                <div class="logo-container">
                    <a class="navbar-brand" href="index.php"><img src="agoralogo.png" alt="Logo Agora" class="logo"></a>
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
