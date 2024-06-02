<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié.']);
    exit();
}

include 'db_connection.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['card_id'])) {
    $card_id = $_POST['card_id'];

    // Mettre à jour les commandes pour supprimer la référence à cette carte
    $sql_update_orders = "UPDATE orders SET card_id = NULL WHERE card_id = ? AND user_id = ?";
    $stmt_update = $conn->prepare($sql_update_orders);
    $stmt_update->bind_param("ii", $card_id, $user_id);

    if ($stmt_update->execute()) {
        // Requête SQL pour supprimer la carte de paiement
        $stmt_delete = $conn->prepare("DELETE FROM user_cards WHERE id = ? AND user_id = ?");
        $stmt_delete->bind_param("ii", $card_id, $user_id);

        if ($stmt_delete->execute()) {
            if ($stmt_delete->affected_rows > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Aucune carte supprimée. Veuillez vérifier que la carte existe et vous appartient.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression de la carte : ' . $stmt_delete->error]);
        }

        $stmt_delete->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour des commandes : ' . $stmt_update->error]);
    }

    $stmt_update->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID de carte manquant.']);
}

$conn->close();
?>
