<?php
session_start();
include 'db_connection.php';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $cardId = $_POST['card_id']; // Supposons que l'ID de la carte utilisée pour le paiement est envoyé via POST
    $addressId = $_POST['address_id']; // Supposons que l'ID de l'adresse de livraison choisie est envoyé via POST
    $totalPrice = $_POST['total_price']; // Supposons que le prix total de la commande est envoyé via POST

    // Statut initial de la commande
    $status = 'Delivered';

    // Insérer les informations de commande dans la table orders
    $stmt = $conn->prepare("INSERT INTO orders (user_id, card_id, address_id, total_price, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiis", $userId, $cardId, $addressId, $totalPrice, $status);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Récupérer l'ID de la commande qui vient d'être insérée
        $orderId = $conn->insert_id;

        // Redirection vers la page de confirmation de commande avec l'ID de la commande
        header('Location: order_confirmation.php?order_id=' . $orderId);
        exit; // Arrêter l'exécution du script après la redirection
    } else {
        echo "Erreur lors de l'enregistrement de la commande.";
    }

    $stmt->close();
} else {
    echo "Utilisateur non connecté.";
}

$conn->close();
?>
