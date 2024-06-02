<?php
session_start();
include 'db_connection.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer l'ID de l'utilisateur
$userId = $_SESSION['user_id'];

// Vérifier que le formulaire a été soumis et que product_id et initial_offer sont définis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['initial_offer'])) {
    $productId = $_POST['product_id'];
    $initialOffer = $_POST['initial_offer'];

    // Vérifier que product_id et initial_offer ne sont pas vides ou nuls
    if (empty($productId) || empty($initialOffer)) {
        echo "Erreur: Les données soumises sont invalides.";
        exit();
    }
    
    // Récupérer l'ID du vendeur associé au produit
    $stmt = $conn->prepare("SELECT user_id FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $sellerId = $product['user_id'];
    } else {
        echo "Erreur: Produit non trouvé.";
        exit();
    }

    // Créer une nouvelle négociation avec le vendeur approprié
    $stmt = $conn->prepare("INSERT INTO negotiations (product_id, buyer_id, seller_id, initial_offer, counter_offer, round, status) VALUES (?, ?, ?, ?, ?, 1, 'pending')");
    $stmt->bind_param("iiidd", $productId, $userId, $sellerId, $initialOffer, $initialOffer);

    if ($stmt->execute()) {
        echo "Offre initiale soumise avec succès.";
        header("Location: interface_negociation.php?id=" . $productId);
        exit();
    } else {
        echo "Erreur lors de la soumission de l'offre initiale: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Erreur: Requête non valide.";
}

$conn->close();
?>
