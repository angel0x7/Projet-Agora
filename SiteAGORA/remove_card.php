<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit();
}

if (!isset($_POST['card_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de carte manquant']);
    exit();
}

include 'db_connection.php';

$card_id = $_POST['card_id'];

$sqlDelete = "DELETE FROM user_cards WHERE id = $card_id";
if ($conn->query($sqlDelete) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression de la carte : ' . $conn->error]);
}

$conn->close();
?>
