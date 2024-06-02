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

// Vérifier que le formulaire a été soumis et que negotiation_id et counter_offer sont définis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['negotiation_id']) && isset($_POST['counter_offer'])) {
    $negotiationId = $_POST['negotiation_id'];
    $counterOffer = $_POST['counter_offer'];

    // Vérifier que negotiationId et counterOffer ne sont pas vides ou nuls
    if (empty($negotiationId) || empty($counterOffer)) {
        echo "Erreur: Les données soumises sont invalides.";
        exit();
    }

    // Récupérer la négociation et vérifier si l'utilisateur connecté est bien l'une des parties concernées
    $stmt = $conn->prepare("SELECT * FROM negotiations WHERE id = ?");
    $stmt->bind_param("i", $negotiationId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['seller_id'] != $userId && $row['buyer_id'] != $userId) {
            echo "Erreur: Vous n'êtes pas autorisé à faire une contre-offre pour cette négociation.";
            exit();
        }
        if ($row['round'] >= 5) {
            echo "Erreur: La limite de 5 tours de négociation a été atteinte.";
            exit();
        }
        // Vérifier que l'utilisateur ne puisse pas renchérir sur sa propre offre
        if (($row['round'] % 2 == 0 && $row['seller_id'] == $userId) || ($row['round'] % 2 == 1 && $row['buyer_id'] == $userId)) {
            echo "Erreur: Vous devez attendre la réponse de l'autre partie avant de faire une nouvelle offre.";
            exit();
        }
        $newRound = $row['round'] + 1;
        $productId = $row['product_id']; // Récupérer l'identifiant du produit
    } else {
        echo "Erreur: Négociation non trouvée.";
        exit();
    }

    // Mettre à jour la négociation avec la contre-offre et le nouveau tour
    $stmt = $conn->prepare("UPDATE negotiations SET counter_offer = ?, round = ?, status = 'pending', updated_at = NOW() WHERE id = ?");
    $stmt->bind_param("dii", $counterOffer, $newRound, $negotiationId);

    if ($stmt->execute()) {
        echo "Contre-offre soumise avec succès.";
        // Rediriger vers l'interface de négociation avec l'identifiant du produit
        header("Location: interface_negociation.php?id=" . $productId);
        exit();
    } else {
        echo "Erreur lors de la soumission de la contre-offre : " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Erreur: Requête non valide.";
}

$conn->close();
?>
