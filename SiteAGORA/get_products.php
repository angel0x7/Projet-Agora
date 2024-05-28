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
    echo "<div>";
    echo "<h4>" . htmlspecialchars($row['name']) . "</h4>";
    echo "<p>Description : " . htmlspecialchars($row['description']) . "</p>";
    echo "<p>Prix : " . htmlspecialchars($row['price']) . "€" . "</p>";
    echo "<p>Catégorie : " . htmlspecialchars($row['category']) . "</p>";
    // Afficher l'image du produit
    if (!empty($row['image_path'])) {
        echo '<img src="' . htmlspecialchars($row['image_path']) . '" alt="Image du produit" style="width:200px;height:auto;">';
    } else {
        echo '<p>Aucune image disponible.</p>';
    }

    echo "</div>";
}

$stmt->close();
$conn->close();
?>
