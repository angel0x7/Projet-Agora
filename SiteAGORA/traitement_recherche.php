<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $categorie = $_POST['category'];
    $categoriesell = $_POST['category_sell'];
    $prix_max = $_POST['prix_max'];
    // Récupérer la valeur de la case à cocher "Activer les notifications"
    $notifications = isset($_POST['notifications']) ? 1 : 0;
    // Afficher les valeurs reçues du formulaire pour déboguer
    var_dump($_POST['notifications']);

    $notifications = isset($_POST['notifications']) ? 1 : 0;

    // Insérer les critères de recherche dans la base de données
    $stmt = $conn->prepare("INSERT INTO criteres_recherche (user_id, categorie, categorie_sell, prix_max, actif) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $user_id, $categorie, $categoriesell, $prix_max, $notifications);
    $stmt->execute();
    $stmt->close();
    

    // Rediriger l'utilisateur vers la page de notifications
    header("Location: notifications.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
