<style>
    .link-effect {
        color: #343a40;
        transition: all 0.3s ease;
    }

    .link-effect:hover {
        color: #007bff;
        transform: translateY(-3px);
    }

    .list-group-item {
        padding: 0; /* Ajout de cette ligne pour supprimer le padding */
    }
</style>
<?php
    session_start();
    include 'db_connection.php';


    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc(); // Récupérer les données de l'utilisateur
    $user_type = $user['user_type']; // Extraire le type d'utilisateur
    $stmt->close();
?>

<div class="mt-4">
    <h3 class="mb-4">Liens Utiles</h3>
    <ul class="list-group list-group-flush">
        <li class="list-group-item border-0 bg-transparent rounded-0">
            <a href="profile.php" class="nav-link link-effect">Mon Profil</a>
        </li>
        <li class="list-group-item border-0 bg-transparent rounded-0">
            <a href="manege_card.php" class="nav-link link-effect">Gérer mes Cartes</a>
        </li>
        <li class="list-group-item border-0 bg-transparent rounded-0">
            <a href="manage_livraison.php" class="nav-link link-effect">Gérer mes Adresses de Livraison</a>
        </li>
        <li class="list-group-item border-0 bg-transparent rounded-0">
            <a href="wishlist.php" class="nav-link link-effect">Ma Wishlist</a>
        </li>
        <li class="list-group-item border-0 bg-transparent rounded-0">
            <a href="order_history.php" class="nav-link link-effect">Historique des Commandes</a>
        </li>
        <li class="list-group-item border-0 bg-transparent rounded-0">
            <a href="my_product.php" class="nav-link link-effect">Mes Produits en Vente</a>
        </li>
        <?php if ($user_type === 'administrateur'): ?>
            <li class="list-group-item border-0 bg-transparent rounded-0">
                <a href="gestion_Vendeur.php" class="nav-link link-effect">Gestion des vendeurs</a>
            </li>
        <?php endif; ?>
    </ul>
</div>
