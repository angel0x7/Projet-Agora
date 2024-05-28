<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$userId = $_SESSION['user_id'];
$productName = $_POST['productName'];
$productDescription = $_POST['productDescription'];
$productPrice = $_POST['productPrice'];
$productCategory = $_POST['productCategory'];

include 'db_connection.php';

// Préparer et exécuter la requête SQL pour insérer le produit
$stmt = $conn->prepare("INSERT INTO products (user_id, name, description, price, category) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issds", $userId, $productName, $productDescription, $productPrice, $productCategory);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du produit: ' . $stmt->error]);
}

$stmt->close();
$conn->close();


?>
