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

// Récupérer l'ID du produit depuis la requête POST
$productId = $_POST['product_id'];

// Supprimer l'article du panier
$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->bind_param("ii", $userId, $productId);

if ($stmt->execute()) {
    echo "Article supprimé du panier avec succès.";
} else {
    echo "Erreur lors de la suppression de l'article du panier : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
