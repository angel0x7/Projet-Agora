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

// Vérifier que le formulaire a été soumis et que product_id est défini
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // Vérifier que productId n'est pas vide ou nul
    if (empty($productId)) {
        echo "Erreur: L'ID du produit est manquant.";
        exit();
    }

    // Récupérer le prix du produit depuis la base de données
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productPrice = $row['price'];
    } else {
        echo "Erreur: Produit non trouvé.";
        exit();
    }

    // Vérifier si le produit est déjà dans le panier
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si le produit est déjà dans le panier, augmenter la quantité
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $userId, $productId);
    } else {
        // Sinon, ajouter le produit au panier
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, price) VALUES (?, ?, 1, ?)");
        $stmt->bind_param("iii", $userId, $productId, $productPrice);
    }

    if ($stmt->execute()) {
        // Rediriger vers la page du panier ou afficher un message de succès
        header("Location: cart.php");
    } else {
        echo "Erreur lors de l'ajout du produit au panier : " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Erreur: Requête non valide.";
}

$conn->close();
?>
