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

// Vérifier si l'ID du produit est passé dans le formulaire
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // Préparer et exécuter la requête SQL pour récupérer l'enchère la plus élevée pour ce produit
    $stmt = $conn->prepare("SELECT max_bid FROM bids WHERE product_id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si une enchère existe pour ce produit
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productPrice = $row['max_bid']; // Récupérer le prix de l'enchère
    } else {
        echo "Aucune enchère trouvée pour ce produit.";
        exit();
    }
    echo $productPrice;
    // Vérifier si le produit est déjà dans le panier
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si le produit est déjà dans le panier, afficher un message d'erreur
        echo "Ce produit est déjà dans votre panier.";
    } else {
        // Sinon, ajouter le produit au panier avec le prix de l'enchère
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, price, quantity) VALUES (?, ?, ?, 1)");
        $stmt->bind_param("iid", $userId, $productId, $productPrice);
        
        if ($stmt->execute()) {
            echo "Produit ajouté au panier avec succès.";
            // Rediriger vers la page du panier ou afficher un message de succès
            header("Location: cart.php");
        } else {
            echo "Erreur lors de l'ajout du produit au panier : " . $stmt->error;
        }
    }

    $stmt->close();
} else {
    echo "ID du produit non fourni.";
}

$conn->close();
?>
