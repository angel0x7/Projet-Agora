<!-- templates/header.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Agora Francia</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
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
                    <a class="nav-link" href="account.php">Votre Compte</a>
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
</nav>
