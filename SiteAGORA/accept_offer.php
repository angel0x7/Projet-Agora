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

// Vérifier que le formulaire a été soumis et que negotiation_id est défini
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['negotiation_id'])) {
    $negotiationId = $_POST['negotiation_id'];

    // Récupérer la négociation et vérifier si l'utilisateur connecté est bien l'une des parties concernées
    $stmt = $conn->prepare("SELECT * FROM negotiations WHERE id = ?");
    $stmt->bind_param("i", $negotiationId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['seller_id'] != $userId && $row['buyer_id'] != $userId) {
            echo "Erreur: Vous n'êtes pas autorisé à accepter cette offre.";
            exit();
        }
        $finalOffer = $row['counter_offer'] ? $row['counter_offer'] : $row['initial_offer'];
        $productId = $row['product_id'];
    } else {
        echo "Erreur: Négociation non trouvée.";
        exit();
    }

    // Mettre à jour le statut de la négociation en 'accepted'
    $stmt = $conn->prepare("UPDATE negotiations SET status = 'accepted', updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("i", $negotiationId);
    if ($stmt->execute()) {
        
        // Ajouter le produit au panier de l'acheteur avec le prix final de la négociation
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, price) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $row['buyer_id'], $productId, $finalOffer);
        $stmt->execute();

        echo "Offre acceptée avec succès.";
        
        // Rediriger vers la page du panier
        header("Location: cart.php");
        exit();
    } else {
        echo "Erreur lors de l'acceptation de l'offre : " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Erreur: Requête non valide.";
}

$conn->close();
?>
