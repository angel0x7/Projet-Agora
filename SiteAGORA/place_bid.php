<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['productId'];
    $max_bid = $_POST['maxBid'];

    // Vérifiez si l'utilisateur a déjà placé une enchère pour cet article
    $stmt = $conn->prepare("SELECT id FROM bids WHERE product_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Mettre à jour l'enchère existante
        $stmt = $conn->prepare("UPDATE bids SET max_bid = ? WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("dii", $max_bid, $product_id, $user_id);
    } else {
        // Insérer une nouvelle enchère
        $stmt = $conn->prepare("INSERT INTO bids (product_id, user_id, max_bid) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $product_id, $user_id, $max_bid);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false]);
}
?>
