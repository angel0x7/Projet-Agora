<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

// Récupérer l'ID de l'utilisateur
$userId = $_SESSION['user_id'];

// Préparer et exécuter la requête SQL pour récupérer les produits de l'utilisateur
$stmt = $conn->prepare("SELECT * FROM products WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Afficher les produits
while ($row = $result->fetch_assoc()) {
    echo '<div class="col-md-4">';
    echo '<div class="card mb-4" id="item' . htmlspecialchars($row['id']) . '">';
    echo '<img src="' . htmlspecialchars($row['image_path']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>';
    echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
    echo '<p class="card-text">Prix: ' . htmlspecialchars($row['price']) . '€</p>';
    echo '<div class="choix">';
    // Lien pour supprimer le produit
    echo '<a href="delete_product.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-danger">Supprimer</a>';
    // Lien pour modifier le produit (vers une page de modification)
    echo '<a href="edit_product.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-primary">Modifier</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

$stmt->close();
$conn->close();
?>
