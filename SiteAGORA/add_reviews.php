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

// Récupérer l'ID du produit depuis le formulaire
$productId = $_POST['product_id'];

// Récupérer les données du formulaire
$comment = $_POST['comment'];
$rating = $_POST['rating'];

// Préparer et exécuter la requête SQL pour insérer le commentaire dans la base de données
$stmt = $conn->prepare("INSERT INTO reviews (user_id, comment, rating, product_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isii", $userId, $comment, $rating, $productId);

if ($stmt->execute()) {
    // Rediriger vers la page de détails de l'article après l'ajout du commentaire
    header("Location: item_detail.php?id=" . $productId);
    exit();
} else {
    echo "Erreur lors de l'enregistrement du commentaire : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
