<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

// Vérifier les données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $productPrice = $_POST['productPrice'];
    $productCategory = $_POST['productCategory'];
    $userId = $_SESSION['user_id'];

    // Préparer et exécuter la requête SQL pour insérer le produit
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isds", $productName, $productDescription, $productPrice, $productCategory);
    if ($stmt->execute()) {
        echo "Le produit a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du produit : " . $stmt->error;
    }
    $stmt->close();
} else {
    header("HTTP/1.1 400 Bad Request");
}
?>
